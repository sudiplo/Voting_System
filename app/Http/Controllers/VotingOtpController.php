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

class VotingOtpController extends Controller
{

    //==========================Send OTP==========================
    public function sendOtp(Request $request)
    {
        // Rate limiting algo (sliding window)
        $limit = 5;
        $window = 60;
        $blockTime = 60;

        $ip = $request->ip();
        $rateKey = 'rate_limit:otp:' . $ip;
        $blockKey = 'rate_limit:block:' . $ip;

        // Check if blocked
        if (Cache::has($blockKey)) {
            toast('You are blocked for 1 minute due to too many OTP requests.', 'error');
            return redirect()->back();
        }

        //Get request count
        $count = Cache::get($rateKey, 0);

        //If limit exceeded → block
        if ($count >= $limit) {

            Cache::put($blockKey, true, $blockTime); // block user
            Cache::forget($rateKey); // reset counter

            toast('Too many OTP requests. Blocked for 1 minute.', 'error');
            return redirect()->back();
        }

        //Increase request count
        Cache::put($rateKey, $count + 1, $window);

        //===========================OTP=====================
        $user = Auth::user();

        // Delete previous unused OTP
        otps::where('user_id', $user->id)
            ->where('is_used', false)
            ->delete();

        $plainOtp = rand(100000, 999999);

        otps::create([
            'user_id' => $user->id,
            'otp' => Hash::make($plainOtp),
            'expires_at' => Carbon::now()->addMinutes(5),
        ]);

        Mail::to($user->email)->send(new VotingOtpMail($plainOtp));

        toast('OTP sent to your email.', 'success');
        return back();
        // return redirect()->route('otp.verify.form');
    }

    //==========================Show OTP form==========================
    public function castVote()
    {
        return view('voting.vote-page');
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

        // Redirect to actual voting page
        toast('OTP verified. You can now cast your vote.', 'success');
        return redirect()->route('vote.page');
    }
}
