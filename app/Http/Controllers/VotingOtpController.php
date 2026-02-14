<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\otps;
use App\Mail\VotingOtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class VotingOtpController extends Controller
{
    // 🔹 Step 1: Send OTP when user tries to cast vote
    public function sendOtp()
    {
        $user = Auth::user();

        // Delete previous unused OTP
        otps::where('user_id', $user->id)
            ->where('is_used', false)
            ->delete();

        // Generate 6 digit OTP
        $plainOtp = rand(100000, 999999);

        otps::create([
            'user_id' => $user->id,
            'otp' => Hash::make($plainOtp), // hash OTP
            'expires_at' => Carbon::now()->addMinutes(5),
        ]);

        // Send to logged in user's email
        Mail::to($user->email)->send(new VotingOtpMail($plainOtp));
        toast('OTP sent to your email.', 'success');
        return redirect()->route('otp.verify.form');
    }

    // 🔹 Step 2: Show OTP form
    public function showVerifyForm()
    {
        return view('voting.verify-otp');
    }

    // 🔹 Step 3: Verify OTP
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

        // Redirect to actual voting page
        toast('OTP verified. You can now cast your vote.', 'success');
        return redirect()->route('vote.page');
    }
}
