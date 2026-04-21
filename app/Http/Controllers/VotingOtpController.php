<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\otps;
use App\Mail\VotingOtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Models\Election;
use App\Models\wardCandidate;
use App\Models\vote;
// use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;


class VotingOtpController extends Controller
{

    //==========================Send OTP==========================
    public function sendOtp(Request $request)
    {
        // 1. Configurable limits (put these in config/rate_limiting.php or .env)
        $limit = config('rate_limiting.otp.max_requests', 5);      // max 5 requests
        $window = config('rate_limiting.otp.window_seconds', 60);  // per 60 seconds
        $blockTime = config('rate_limiting.otp.block_seconds', 60); // block for 60 seconds

        $ip = $request->ip();
        $rateKey = 'rate_limit:otp:sliding:' . $ip;
        $blockKey = 'rate_limit:block:' . $ip;

        // 2. Check if already blocked
        if (Cache::has($blockKey)) {
            $remainingBlock = Cache::ttl($blockKey); // seconds left
            toast("Too many OTP requests. Please try again in {$remainingBlock} seconds.", 'error');
            return redirect()->back();
        }

        // 3. Atomic sliding window using cache lock (prevents race conditions)
        $lock = Cache::lock($rateKey . '_lock', 2); // 2 seconds timeout

        try {
            $lock->block(2); // Wait up to 2 seconds for lock

            // Retrieve and filter timestamps
            $timestamps = Cache::get($rateKey, []);
            $now = now()->timestamp;

            $timestamps = array_filter($timestamps, function ($timestamp) use ($now, $window) {
                return ($now - $timestamp) < $window;
            });

            $requestCount = count($timestamps);

            if ($requestCount >= $limit) {
                // Block this IP
                Cache::put($blockKey, true, $blockTime);
                Cache::forget($rateKey); // Clear the sliding window
                $lock->release();

                Log::warning("OTP rate limit exceeded", ['ip' => $ip, 'count' => $requestCount]);
                toast("Too many OTP requests. Blocked for {$blockTime} seconds.", 'error');
                return redirect()->back();
            }

            // Add current request timestamp
            $timestamps[] = $now;
            Cache::put($rateKey, $timestamps, $window);
            $lock->release();

        } catch (\Illuminate\Contracts\Cache\LockTimeoutException $e) {
            // Lock timeout – another request is processing, wait and retry or fail gracefully
            toast('System busy, please try again.', 'error');
            return redirect()->back();
        }

        // ========== OTP generation (unchanged) ==========
        $user = Auth::user();

        // Delete previous unused OTP
        Otps::where('user_id', $user->id)->where('is_used', false)->delete();

        $plainOtp = random_int(100000, 999999); // more secure than rand()
        Otps::create([
            'user_id' => $user->id,
            'otp' => Hash::make($plainOtp),
            'expires_at' => Carbon::now()->addMinutes(5),
        ]);

        Mail::to($user->email)->send(new VotingOtpMail($plainOtp));

        toast('OTP sent to your email.', 'success');
        return back();
    }

    //==========================Show OTP form==========================
    public function castVote()
    {
        $election = Election::where('status','process')->orderBy('election_date', 'asc')->first();
        $Candidates = wardCandidate::where('palika_id', Auth::user()->citizen->palika_id)->where('election', $election->id)->get();

        return view('voting.vote-page', compact('Candidates', 'election'));
    }

    //==========================Verify OTP==========================
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $user = Auth::user();

        $otpRecord = otps::where('user_id', $user->id)
            ->where('is_used', false)
            ->latest()
            ->first();

        if (!$otpRecord) {
            return back()->with('error', 'No OTP found.');
        }

        // Check expiry
        if (Carbon::now()->greaterThan($otpRecord->expires_at)) {
            return back()->with('error', 'OTP expired.');
        }

        // Check attempts
        if ($otpRecord->attempts >= 3) {
            return back()->with('error', 'Maximum attempts exceeded.');
        }

        // Verify OTP
        if (!Hash::check($request->otp, $otpRecord->otp)) {

            $otpRecord->increment('attempts');

            return back()->with('error', 'Invalid OTP.');
        }

        // Mark as used
        $otpRecord->update([
            'is_used' => true
        ]);

        // Mark as used
        $otpRecord->update([
            'is_used' => true
        ]);

        // Set session flag
        session(['otp_verified' => true]);

        toast('OTP verified. You can now cast your vote.', 'success');
        return redirect()->route('vote.page');
    }

    // ==========================Submit Vote==========================
    public function submitVote(Request $request)
    {
        $request->validate([
            'vote' => 'required|array',
        ]);

        $election = Election::where('status','process')->orderBy('election_date', 'asc')->first();

        $alreadyVoted = vote::where('user_id', Auth::user()->id)->where('election_id', $election->id)->exists();
        if ($alreadyVoted) {
            toast('You have already cast your vote for this election!', 'error');
            return back();
        }

        foreach ($request->vote as $post => $candidateId) {
            $candidate = wardCandidate::find($candidateId);
            if ($candidate) {
                $candidate->vote = $candidate->vote ? intval($candidate->vote) + 1 : 1;
                $candidate->save();
            }

            vote::create([
                'user_id' => Auth::user()->id,
                'candidate_id' => $candidate->id,
                'election_id' => $candidate->election,
                'post' => $post,
            ]);
        }

        toast('Your vote has been submitted!', 'success');
        return back();
    }

}
