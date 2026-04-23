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
use App\Models\Winner;

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

    // ==========================candidate view for guest======================================================================
    public function guestCandidateindex($id){
        $election = Election::find($id);
        $districts = district::with('palika.wards')->get();
        $candidates = wardCandidate::where('election', $id)->get();
        return view('Guest.candidates.index',compact('candidates','election','districts'));
    }

    // ==========================candidate search for guest======================================================================
    public function guestCandidateSearch(Request $request,$id){
        $election = Election::find($id);
        $districts = district::with('palika.wards')->get();
        $districtId = $request->district_id;
        $palikaId = $request->palika_id;
        $wardId = $request->ward_id;
        $d = district::find($districtId);
        $p = palika::find($palikaId);
        $w = ward::find($wardId);
        $candidates = wardCandidate::where('election', $id)
            ->where('district_id', $districtId)
            ->where('palika_id', $palikaId)
            ->where('ward_id', $wardId)
            ->get();
       return view('Guest.candidates.index',compact('candidates','election','districts'));
    }

    // ==========================winner view for guest======================================================================
    public function guestWinnerIndex(){
       $election = Election::where('status','end')->orderBy('election_date', 'desc')->get();
        return view('Guest.result.index',compact('election')); 
    }

    // ==========================winner search for guest======================================================================
    public function guestWinnerSearch(Request $request){
        $search = $request->get('search');
        $election = Election::where('title','like',"%$search%")->where('status','end')->get();
        return view('Guest.result.index', compact('election'));

    }
    // ==========================result view for guest======================================================================
      public function guestElectionResult($id){
        $e = election::find($id);
        $districts = district::with('palika.wards')->get();

        return view('Guest.result.select',compact('e','districts'));
    }

    // ==========================result search for guest======================================================================
      public function guestElectionResultSearch(Request $request, $id)
    {
        $e = Election::find($id);
        $districtId = $request->district_id;
        $palikaId = $request->palika_id;
        $wardId = $request->ward_id;

        $d = District::find($districtId);
        $p = Palika::find($palikaId);
        $wa = Ward::find($wardId);
        $districts = District::with('palika.wards')->get();

        // Mayor & Deputy Mayor – municipality level (palika_id)
        $mayor = Winner::with('candidate.citizen')
            ->where('election_id', $id)
            ->where('post', 'Mayor')
            ->where('palika_id', $palikaId)
            ->first();

        $deputyMayor = Winner::with('candidate.citizen')
            ->where('election_id', $id)
            ->where('post', 'Deputy Mayor')
            ->where('palika_id', $palikaId)
            ->first();

        // Ward‑level posts – filter by ward_id
        $wardChairperson = Winner::with('candidate.citizen')
            ->where('election_id', $id)
            ->where('post', 'Ward Chairperson')
            ->where('ward_id', $wardId)
            ->first();

        $wardMember = Winner::with('candidate.citizen')
            ->where('election_id', $id)
            ->where('post', 'Ward Member')
            ->where('ward_id', $wardId)
            ->first();

        $wardMemberWomen = Winner::with('candidate.citizen')
            ->where('election_id', $id)
            ->where('post', 'Ward Member(Women)')
            ->where('ward_id', $wardId)
            ->first();

        $wardMemberDalit = Winner::with('candidate.citizen')
            ->where('election_id', $id)
            ->where('post', 'Ward Member(Dalit)')
            ->where('ward_id', $wardId)
            ->first();

        return view('Guest.result.winner', compact(
            'e', 'districts', 'd', 'p', 'wa',
            'mayor', 'deputyMayor', 'wardChairperson',
            'wardMember', 'wardMemberWomen', 'wardMemberDalit'
        ));
    }
}
