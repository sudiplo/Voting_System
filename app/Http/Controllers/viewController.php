<?php

namespace App\Http\Controllers;

use App\Models\c_mayor;
use App\Models\citizenship;
use Illuminate\Http\Request;
use App\Models\district;
use App\Models\palika;
use App\Models\Election;
use App\Models\User;
use App\Models\wardCandidate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\ward;

class viewController extends Controller
{
    //==========================welcome page view======================================================================
    public function welcome(){
        $totalElections = Election::count();
        $ActiveElections = Election::where('status','process')->count();
        $totalUsers = User::where('usertype','user')->count();
        $election = Election::where('status','process')->orderBy('election_date', 'asc')->first();
        if ($election) {
            $candidates = wardCandidate::where('election', $election->id)->get();
            return view('welcome', compact('candidates','election','totalElections','ActiveElections','totalUsers'));
        }
        return view('welcome',compact('election','totalElections','ActiveElections','totalUsers'));
    }
    //==========================about page view======================================================================
    public function about(Request $request)
    {
        return view('about');
    }

    //==========================dashboard view=========================================================================
    public function dashboard(){
        $election = Election::where('status','process')->orderBy('election_date', 'asc')->first();
        if ($election) {
            $candidates = wardCandidate::where('palika_id', Auth::user()->citizen->palika_id)->where('election', $election->id)->get();
            return view('User.dashboard', compact('candidates','election'));
        }
        else {
            return view('User.dashboard',compact('election'));
        }
    }

    //=
    public function Admindashboard(){
        $elections = Election::where('status','process')->orderBy('election_date', 'asc')->get();
        $totalElections = Election::count();
        $ActiveElections = Election::where('status','process')->count();
        $totalUsers = User::where('usertype','user')->count();
        $totalCitizens = citizenship::count();
        return view('dashboard',compact('elections','totalUsers','totalElections','ActiveElections','totalCitizens'));
    }

    // ==========================voter view for guest======================================================================
    public function guestVoterView(){
        $districts = district::with('palika.wards')->get();
        $voter = user::where('usertype','user')->get();
        return view('Guest.voter',compact('voter','districts'));
    }

    // ==========================voter search for guest======================================================================
    public function guestVoterSearch(Request $request){
        $districts = district::with('palika.wards')->get();
        $districtId = $request->district_id;
        $palikaId = $request->palika_id;
        $wardId = $request->ward_id;
        $d = district::find($districtId);
        $p = palika::find($palikaId);
        $w = ward::find($wardId);
        $citizens = citizenship::where('district_id', $districtId)
            ->where('palika_id', $palikaId)
            ->where('ward_id', $wardId)
            ->get();

        $ids = $citizens->pluck('id');

        $voter = user::whereIn('citizen_id', $ids)->get();
        return view('Guest.voter',compact('voter','districts','d','p','w'));
    }


}
