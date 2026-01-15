<?php

namespace App\Http\Controllers;
use App\Models\c_mayor;
use App\Models\Election;
use App\Models\district;
use App\Models\citizenship;
use App\Models\wardCandidate;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ElectionController extends Controller
{
    //==========================index view==============================================================================
    public function index(Request $request){
        $search = $request->get('search');
        $elections = Election::where('title','like',"%$search%")->get();
        return view('elections.index', compact('elections'));
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
        ]);

        // if (Election::where('title', $request->name)->exists()) {
        //     toast("Election Title already Register","error");
        //     return redirect()->back();
        // }
        // if (Election::whereDate('election_date', $request->date)->exists()) {
        //     toast('Election schedule is full for this date. Please choose another date.', 'error');
        //     return redirect()->back()->withInput();
        // }
        if (Carbon::parse($request->date)->lessThanOrEqualTo(Carbon::today())) {
            toast("Election date must be a future date", "error");
            return redirect()->back();
        }

        $election = Election::find($id);
        $election->title = $request->input('name');
        $election->election_date = $request->input('date');

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
        return view('elections.register',compact('districts','election'));
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
        $mayor = c_mayor::where('election',$election->id)->get();
        $candidate = wardCandidate::where('election',$election->id)->get();

        return view('User.vote', compact('today', 'election','mayor','candidate'));
    }
}
