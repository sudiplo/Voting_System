<?php

namespace App\Http\Controllers;

use App\Models\c_mayor;
use App\Models\citizenship;
use Illuminate\Http\Request;
use App\Models\district;
use App\Models\palika;
use App\Models\Election;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class viewController extends Controller
{
    //==========================welcome page view======================================================================
    public function welcome(){
        return view('welcome');
    }
    //==========================about page view======================================================================
    // public function about(){
    //      $district = district::all();
    //     $palika=palika::all();
    //     return view('about',compact('district','palika'));
    // }



public function about(Request $request)
{
    $limit = 5;
    $window = 60;   // 1 minute
    $blockTime = 60; // block for 1 minute

    $ip = $request->ip();

    $rateKey = 'rate_limit:about:' . $ip;
    $blockKey = 'rate_limit:block:' . $ip;

    // 🔴 Step 1: Check if user is blocked
    if (Cache::has($blockKey)) {
        return redirect()->back()
            ->with('error', 'You are blocked for 1 minute due to too many requests.');
    }

    // 🔵 Step 2: Get current count
    $count = Cache::get($rateKey, 0);

    // 🔵 Step 3: If limit exceeded → block user
    if ($count >= $limit) {
        Cache::put($blockKey, true, $blockTime); // block for 1 minute
        Cache::forget($rateKey); // reset counter
        toast('Too many requests. You are blocked for 1 minute.', 'error');
        return redirect()->back();
            // ->with('error', 'Too many requests. You are blocked for 1 minute.');
    }

    // 🟢 Step 4: Increase request count
    Cache::put($rateKey, $count + 1, $window);

    // Your original logic
    $district = district::all();
    $palika = palika::all();

    return view('about', compact('district', 'palika'));
}

    //==========================dashboard view=========================================================================
    public function dashboard(){
        $election = Election::where('status','process')->orderBy('election_date', 'asc')->first();
        if ($election) {
            $candidates = c_mayor::where('palika_id', Auth::user()->citizen->palika_id)->where('election', $election->id)->get();
            return view('User.dashboard', compact('candidates','election'));
        }
        else {
            return view('User.dashboard',compact('election'));
        }
    }
    //
    public function Admindashboard(){
        $elections = Election::where('status','process')->orderBy('election_date', 'asc')->get();
        $totalElections = Election::count();
        $ActiveElections = Election::where('status','process')->count();
        $totalUsers = User::where('usertype','user')->count();
        $totalCitizens = citizenship::count();
        return view('dashboard',compact('elections','totalUsers','totalElections','ActiveElections','totalCitizens'));
    }

}
