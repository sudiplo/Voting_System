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
use App\Models\Winner;
use Illuminate\Support\Facades\Crypt;


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
    public function electionUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'status' => 'required|in:process,end',
        ]);

        // Check unique title (excluding current election)
        if (Election::where('title', $request->name)->exists() && $request->name != Election::find($id)->title) {
            toast("Election Title already Register", "error");
            return redirect()->back();
        }

        // Check unique date if changed
        if ($request->date != Election::find($id)->election_date) {
            if (Election::whereDate('election_date', $request->date)->exists()) {
                toast('Election schedule is full for this date. Please choose another date.', 'error');
                return redirect()->back()->withInput();
            }
        }

        // Future date validation for 'process' status
        if ($request->status == 'process') {
            if (Carbon::parse($request->date)->lessThanOrEqualTo(Carbon::today())) {
                toast("Election date must be a future date", "error");
                return redirect()->back();
            }
        }

        $election = Election::find($id);

        // ==================== SAVE WINNERS WHEN ELECTION ENDS ====================
        if ($request->status == 'end' && $election->status != 'end') {
            // 1. Get all candidates for this election
            $candidates = wardCandidate::where('election', $election->id)->get();

            // 2. Group candidates by post and location
            $groups = $candidates->groupBy(function ($candidate) {
                if (in_array($candidate->post, ['Mayor', 'Deputy Mayor'])) {
                    return $candidate->post . '|palika|' . $candidate->palika_id;
                }
                return $candidate->post . '|ward|' . $candidate->ward_id;
            });

            // 3. Process each group
            foreach ($groups as $group) {
                $first = $group->first();
                $post = $first->post;

                // Decrypt vote values (if encrypted)
                $votes = $group->map(function ($candidate) {
                    try {
                        return (int) Crypt::decryptString($candidate->vote);
                    } catch (\Exception $e) {
                        return (int) $candidate->vote;
                    }
                });

                $maxVote = $votes->max();
                $winners = $group->filter(function ($candidate, $index) use ($votes, $maxVote) {
                    return $votes[$index] == $maxVote;
                });

                $palikaId = in_array($post, ['Mayor', 'Deputy Mayor']) ? $first->palika_id : null;
                $wardId = !in_array($post, ['Mayor', 'Deputy Mayor']) ? $first->ward_id : null;

                foreach ($winners as $winner) {
                    Winner::updateOrCreate(
                        [
                            'election_id' => $election->id,
                            'post' => $post,
                            'palika_id' => $palikaId,
                            'ward_id' => $wardId,
                        ],
                        [
                            'candidate_id' => $winner->id,
                            'vote_count' => $maxVote,
                            'is_tie' => ($winners->count() > 1),
                        ]
                    );
                }
            }
        }
        // =========================================================================

        // Update election details
        $election->title = $request->input('name');
        $election->election_date = $request->input('date');
        $election->status = $request->input('status');
        $election->save();

        toast("Election updated successfully", "success");
        return redirect()->back();
    }

    //==========================Election Delete==============================================================================
    public function electionDelete($id){
        $election = Election::find($id);
        $candidates = wardCandidate::where('election', $id)->get();
        foreach ($candidates as $candidate) {
            $candidate->delete();
        }
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

    // ==========================search election inside Election==============================================================================
    public function electionResult(){
        $election = Election::where('status','end')->orderBy('election_date', 'desc')->get();
        return view('result.index',compact('election'));
    }

    // ==========================search election inside Election==============================================================================
    public function electionSearch(Request $request){
        $search = $request->get('search');
        $election = Election::where('title','like',"%$search%")->where('status','end')->get();
        return view('result.index', compact('election'));

    }

    // ==========================view result of election==============================================================================
    public function ElectionResultView($id){
        $e = election::find($id);
        $districts = district::with('palika.wards')->get();

        return view('result.select',compact('e','districts'));
    }

    // ==========================search districh inside Election==============================================================================
   public function ElectionResultSearch(Request $request, $id)
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

        return view('result.winner', compact(
            'e', 'districts', 'd', 'p', 'wa',
            'mayor', 'deputyMayor', 'wardChairperson',
            'wardMember', 'wardMemberWomen', 'wardMemberDalit'
        ));
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
    public function winner($id)
{
    $e = Election::find($id);
    $citizen = Auth::user()->citizen;
    $wardId = $citizen->ward_id;
    $palikaId = $citizen->palika_id;
    $districtId = $citizen->district_id;

    $districts = District::with('palika.wards')->get();
    $d = District::find($districtId);
    $p = Palika::find($palikaId);
    $wa = Ward::find($wardId);

    // Mayor & Deputy Mayor – palika level
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

    // Ward-level posts
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

    return view('User.result.winner', compact(
        'e', 'districts', 'd', 'p', 'wa',
        'mayor', 'deputyMayor', 'wardChairperson',
        'wardMember', 'wardMemberWomen', 'wardMemberDalit'
    ));
}

    //========================================winner search=====================
   public function winnerSearch(Request $request, $id)
{
    $e = Election::find($id);
    $districtId = $request->district_id;
    $palikaId = $request->palika_id;
    $wardId = $request->ward_id;

    $d = District::find($districtId);
    $p = Palika::find($palikaId);
    $wa = Ward::find($wardId);
    $districts = District::with('palika.wards')->get();

    // Get winners from winners table
    $mayor = Winner::where('election_id', $id)
        ->where('post', 'Mayor')
        ->where('palika_id', $palikaId)
        ->first();

    $deputyMayor = Winner::where('election_id', $id)
        ->where('post', 'Deputy Mayor')
        ->where('palika_id', $palikaId)
        ->first();

    $wardChairperson = Winner::where('election_id', $id)
        ->where('post', 'Ward Chairperson')
        ->where('ward_id', $wardId)
        ->first();

    $wardMember = Winner::where('election_id', $id)
        ->where('post', 'Ward Member')
        ->where('ward_id', $wardId)
        ->first();

    $wardMemberWomen = Winner::where('election_id', $id)
        ->where('post', 'Ward Member(Women)')
        ->where('ward_id', $wardId)
        ->first();

    $wardMemberDalit = Winner::where('election_id', $id)
        ->where('post', 'Ward Member(Dalit)')
        ->where('ward_id', $wardId)
        ->first();

    return view('User.result.winner', compact('e', 'districts', 'mayor', 'deputyMayor', 'wardChairperson', 'wardMember', 'wardMemberWomen', 'wardMemberDalit', 'd', 'p', 'wa'));
}
}
