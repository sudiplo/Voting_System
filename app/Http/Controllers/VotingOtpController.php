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
use App\Services\Paillier;

class VotingOtpController extends Controller
{

    //==========================Send OTP==========================
    public function sendOtp(Request $request)
    {
        // Sliding window settings
        $limit = 5;      // max requests                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 per window
        $window = 60;    // window size in seconds
        $blockTime = 60; // block duration (seconds) if limit exceeded

        $ip = $request->ip();
        $rateKey = 'rate_limit:otp:sliding:' . $ip;
        $blockKey = 'rate_limit:block:' . $ip;

        // Check if currently blocked
        if (Cache::has($blockKey)) {
            toast('You are blocked for 1 minute due to too many OTP requests.', 'error');
            return redirect()->back();
        }

        // Retrieve stored timestamps (decoded from cache)
        $timestamps = Cache::get($rateKey, []);
        $now = now()->timestamp;

        // Keep only timestamps that are still inside the current window
        $timestamps = array_filter($timestamps, function ($timestamp) use ($now, $window) {
            return ($now - $timestamp) < $window;
        });

        // Count requests in the current sliding window
        $requestCount = count($timestamps);

        if ($requestCount >= $limit) {
            // Block this IP for $blockTime seconds
            Cache::put($blockKey, true, $blockTime);
            Cache::forget($rateKey); // clean up rate key

            toast('Too many OTP requests. Blocked for 1 minute.', 'error');
            return redirect()->back();
        }

        // Add current request timestamp
        $timestamps[] = $now;
        Cache::put($rateKey, $timestamps, $window);

        // ========== OTP generation (unchanged) ==========
        $user = Auth::user();

        // Delete previous unused OTP
        Otps::where('user_id', $user->id)->where('is_used', false)->delete();

        $plainOtp = rand(100000, 999999);
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
    // public function submitVote(Request $request)
    // {
    //     $request->validate([
    //         'vote' => 'required|array',
    //     ]);

    //     $election = Election::where('status','process')->orderBy('election_date', 'asc')->first();

    //     $alreadyVoted = vote::where('user_id', Auth::user()->id)->where('election_id', $election->id)->exists();
    //     if ($alreadyVoted) {
    //         toast('You have already cast your vote for this election!', 'error');
    //         return back();
    //     }

    //     foreach ($request->vote as $post => $candidateId) {
    //         $candidate = wardCandidate::find($candidateId);
    //         if ($candidate) {
    //             $candidate->vote = $candidate->vote ? intval($candidate->vote) + 1 : 1;
    //             $candidate->save();
    //         }

    //         vote::create([
    //             'user_id' => Auth::user()->id,
    //             'candidate_id' => $candidate->id,
    //             'election_id' => $candidate->election,
    //             'post' => $post,
    //         ]);
    //     }

    //     toast('Your vote has been submitted!', 'success');
    //     return back();
    // }

    public function submitVote(Request $request)
{
    $request->validate(['vote' => 'required|array']);

    $election = Election::where('status', 'process')
                ->orderBy('election_date', 'asc')
                ->first();

    // Prevent double voting (keep this for production)
    $alreadyVoted = vote::where('user_id', Auth::id())
                    ->where('election_id', $election->id)
                    ->exists();
    if ($alreadyVoted) {
        toast('You have already cast your vote for this election!', 'error');
        return back();
    }

    $paillier = new Paillier();

    foreach ($request->vote as $post => $candidateId) {
        $candidate = wardCandidate::find($candidateId);
         if (!$candidate) continue;

        // Get the raw database value (bypass any model accessor)
        $currentRaw = $candidate->getRawOriginal('vote'); // uses getOriginal

        // Decrypt to get current plain vote
        $currentPlain = $currentRaw ? (int) $paillier->decrypt($currentRaw) : 0;

        // Increment
        $newPlain = $currentPlain + 1;

        // Encrypt the new value
        $newCipher = $paillier->encrypt($newPlain);

        // Force update the raw attribute without any casting
        $candidate->setRawAttributes(array_merge($candidate->getAttributes(), ['vote' => $newCipher]));
        $candidate->save();

        // 4. Record metadata for double-vote prevention
        vote::create([
            'user_id'      => Auth::id(),
            'candidate_id' => $candidate->id,
            'election_id'  => $candidate->election,
            'post'         => $post,
        ]);
    }

    toast('Your vote has been submitted!', 'success');
    return back();
}
}
