<?php

namespace App\Http\Controllers;
use App\Models\c_mayor;
use App\Models\Election;
use App\Models\district;
use App\Models\palika;
use App\Models\citizenship;
use App\Models\ward;
use App\Models\wardCandidate;
use App\View\Components\candidates;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ElectionController extends Controller
{
//================================================>Admin Side<========================================================================================
    //==========================index view==============================================================================
    public function index(Request $request){
        $search = $request->get('search');
        $elections = Election::where('title','like',"%$search%")->get();
        return view('elections.index', compact('elections'));
    }

    //==========================Election Register View==============================================================================
    public function electionRegisterView(){
        $totalElections = Election::count();
        $ActiveElections = Election::where('status','process')->count();
        return view('elections.election_register', compact('ActiveElections', 'totalElections'));
    }

    //==========================Register new Election==============================================================================
    public function create(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        if (Election::where('title', $request->name)->exists()) {
            toast("Election Title already Register","error");
            return back();
        }
        if (Election::whereDate('election_date', $request->date)->exists()) {
            toast('Election schedule is full for this date. Please choose another date.', 'error');
            return redirect()->back()->withInput();
        }
        if (Carbon::parse($request->date)->lessThanOrEqualTo(Carbon::today())) {
            toast("Election date must be a future date", "error");
            return redirect()->back();
        }

        $election = new Election();
        $election->title = $request->input('name');
        $election->election_date = $request->input('date');

        $election->save();
        toast("Election created successfully","success");
        return back();

    }


    //==========================Election edit View==============================================================================
    public function electionEdit($id){
        $election = Election::find($id);
        return view('elections.electionEdit', compact('election'));
    }

    //==========================Election Update==============================================================================
    public function electionUpdate(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'status' => 'required|in:process,end',
        ]);

        // if (Election::where('title', $request->name)->exists()) {
        //     toast("Election Title already Register","error");
        //     return redirect()->back();
        // }
        // if (Election::whereDate('election_date', $request->date)->exists()) {
        //     toast('Election schedule is full for this date. Please choose another date.', 'error');
        //     return redirect()->back()->withInput();
        // }
        if($request->date != Election::find($id)->election_date){
                    if (Election::whereDate('election_date', $request->date)->exists()) {
            toast('Election schedule is full for this date. Please choose another date.', 'error');
            return redirect()->back()->withInput();
        }
        }
        if($request->status=='process'){
            if (Carbon::parse($request->date)->lessThanOrEqualTo(Carbon::today())) {
                toast("Election date must be a future date", "error");
                return redirect()->back();
            }
        }


        $election = Election::find($id);
        $election->title = $request->input('name');
        $election->election_date = $request->input('date');
        $election->status = $request->input('status');

        $election->save();
        toast("Election update successfully","success");
        return redirect()->back();
    }

    //==========================Election Delete==============================================================================
    public function electionDelete($id){
        $election = Election::find($id);
        $election->delete();
        toast("Election Record Delete successfully","success");
        return redirect()->back();
    }

    //==========================Election view==============================================================================
    public function view($id){
        $election = Election::find($id);
        $districts = district::with('palika.wards')->get();
        return view('elections.regions',compact('districts','election'));
    }

    //==========================search districh inside Election==============================================================================
    public function district(Request $request,$id){
        $election = Election::find($id);
        $districts = district::with('palika.wards')->get();
        $search = $request->get('search');

        $districts = district::with('palika')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                      ->orWhere('name_nepali', 'like', "%$search%")
                      ->orWhereHas('palika', function ($q) use ($search) {
                          $q->where('name', 'like', "%$search%");
                      });
            })
            ->get();

        // For autocomplete suggestions
        $suggestions = district::where('name', 'like', "%$search%")
            ->pluck('name');

        return view('elections.register', compact('districts', 'suggestions', 'search','districts','election'));
    }



//=======================================>User Side<=====================================================================================================================
    //==========================View vote page==============================================================================
    // public function vote(){
    //     $today = Carbon::today()->toDateString();
    //     $election = Election::orderBy('election_date', 'asc')->first();
    //     $mayor = c_mayor::where('election',$election->id)->get();
    //     $candidate = wardCandidate::where('election',$election->id)->get();

    //     return view('elections.voting', compact('today', 'election','mayor','candidate'));
    // }

    public function vote(){
        $today = Carbon::today()->toDateString();
        $election = Election::where('status','process')->orderBy('election_date', 'asc')->first();
        return view('User.vote', compact('today', 'election'));
    }

    //=========================view the election index page==============================================
        public function ElectionDistrict(){
        $election = Election::where('status','process')->orderBy('election_date', 'asc')->first();
        $districts = district::with('palika.wards')->get();
        return view('User.candidate.index',compact('districts','election'));
    }

    //==========================Elections list to view result user side==============================================================================
    public function result(){
        $election = Election::where('status','end')->orderBy('election_date', 'desc')->get();
        return view('User.result.index',compact('election'));
    }

    //==========================View result of election user side==============================================================================
    public function viewResult($e){
        $mayor = wardCandidate::where('election',$e)->where('post','Mayor')->get();
        $deputyMayor = wardCandidate::where('election',$e)->where('post','Deputy Mayor')->get();
        $wardChairperson = wardCandidate::where('election',$e)->where('post','Ward Chairperson')->get();
        $wardMember = wardCandidate::where('election',$e)->where('post','Ward Member')->get();
        $wardMember = wardCandidate::where('election',$e)->where('post','Ward Member')->get();
        $wardMemberWomen = wardCandidate::where('election',$e)->where('post','Ward Member(Women)')->get();
        $wardMemberDalit = wardCandidate::where('election',$e)->where('post','Ward Member(Dalit)')->get();
        $election = Election::find($e);
        $districts = district::with('palika.wards')->get();
        return view('User.result.result',compact('election','mayor','deputyMayor','wardChairperson','wardMember','wardMemberWomen','wardMemberDalit','districts'));
    }
    //==========================search election inside Election==============================================================================
    public function userElectionSearch(Request $request){
        $search = $request->get('search');
        $election = Election::where('title','like',"%$search%")->where('status','end')->get();
        return view('User.result.index', compact('election'));
    }

    //==========================search districh inside Election==============================================================================
    public function districtSearch(Request $request,$id){
        $election = Election::find($id);
        $districts = district::with('palika.wards')->get();
        $search = $request->get('search');

        $districts = district::with('palika')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                      ->orWhere('name_nepali', 'like', "%$search%")
                      ->orWhereHas('palika', function ($q) use ($search) {
                          $q->where('name', 'like', "%$search%");
                      });
            })
            ->get();

        // For autocomplete suggestions
        $suggestions = district::where('name', 'like', "%$search%")
            ->pluck('name');

        return view('User.candidate.index', compact('districts', 'suggestions', 'search','districts','election'));
    }

    //==========================search districh inside Election==============================================================================
    public function districtSearchresult(Request $request,$id){
        $election = Election::find($id);
        $districts = district::with('palika.wards')->get();
        $search = $request->get('search');

        $districts = district::with('palika')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                      ->orWhere('name_nepali', 'like', "%$search%")
                      ->orWhereHas('palika', function ($q) use ($search) {
                          $q->where('name', 'like', "%$search%");
                      });
            })
            ->get();

        // For autocomplete suggestions
        $suggestions = district::where('name', 'like', "%$search%")
            ->pluck('name');

        return view('User.result.result', compact('districts', 'suggestions', 'search','districts','election'));
    }

    //==================================Winner============================
    public function winner($id){
        $e = election::find($id);
        $w = Auth::user()->citizen->ward_id;

        $districts = district::with('palika.wards')->get();
        $d = district::find(Auth::user()->citizen->district_id);
        $p = palika::find(Auth::user()->citizen->palika_id);
        $wa = ward::find($w);

        $mayor = wardCandidate::where('election',$id)->where('post','Mayor')->where('ward_id',$w)->orderBy('vote','asc')->first();
        $deputyMayor = wardCandidate::where('election',$id)->where('post','Deputy Mayor')->where('ward_id',$w)->orderBy('vote','asc')->first();
        $wardChairperson = wardCandidate::where('election',$id)->where('post','Ward Chairperson')->where('ward_id',$w)->orderBy('vote','asc')->first();
        $wardMember = wardCandidate::where('election',$id)->where('post','Ward Member')->where('ward_id',$w)->orderBy('vote','asc')->first();
        $wardMember = wardCandidate::where('election',$id)->where('post','Ward Member')->where('ward_id',$w)->orderBy('vote','asc')->first();
        $wardMemberWomen = wardCandidate::where('election',$id)->where('post','Ward Member(Women)')->where('ward_id',$w)->orderBy('vote','asc')->first();
        $wardMemberDalit = wardCandidate::where('election',$id)->where('post','Ward Member(Dalit)')->where('ward_id',$w)->orderBy('vote','asc')->first();
        return view('User.result.winner',compact('e','districts','mayor','deputyMayor','wardChairperson','wardMember','wardMemberWomen','wardMemberDalit','d','p','wa'));
    }

    //========================================winner search=====================
    public function winnerSearch(Request $request,$id){
        $e = election::find($id);
        $w = $request->ward_id;

        $d = district::find($request->district_id);
        $p = palika::find($request->palika_id);
        $wa = ward::find($w);
        $districts = district::with('palika.wards')->get();

        $mayor = wardCandidate::where('election',$id)->
            where('post','Mayor')->
            where('ward_id', $w)->orderBy('vote','asc')->first();

        $deputyMayor = wardCandidate::where('election',$id)->where('post','Deputy Mayor')->where('ward_id',$w)->orderBy('vote','asc')->first();
        $wardChairperson = wardCandidate::where('election',$id)->where('post','Ward Chairperson')->where('ward_id',$w)->orderBy('vote','asc')->first();
        $wardMember = wardCandidate::where('election',$id)->where('post','Ward Member')->where('ward_id',$w)->orderBy('vote','asc')->first();
        $wardMember = wardCandidate::where('election',$id)->where('post','Ward Member')->where('ward_id',$w)->orderBy('vote','asc')->first();
        $wardMemberWomen = wardCandidate::where('election',$id)->where('post','Ward Member(Women)')->where('ward_id',$w)->orderBy('vote','asc')->first();
        $wardMemberDalit = wardCandidate::where('election',$id)->where('post','Ward Member(Dalit)')->where('ward_id',$w)->orderBy('vote','asc')->first();
        return view('User.result.winner',compact('e','districts','mayor','deputyMayor','wardChairperson','wardMember','wardMemberWomen','wardMemberDalit','d','p','wa'));
    }
}
