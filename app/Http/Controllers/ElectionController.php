<?php

namespace App\Http\Controllers;
use App\Models\c_mayor;
use App\Models\Election;
use App\Models\district;
use App\Models\citizenship;
use Illuminate\Http\Request;

class ElectionController extends Controller
{
    //==========================index view==============================================================================
    public function index(){
        $elections = Election::all();
        return view('elections.index', compact('elections'));
    }


    //==========================Register new Election==============================================================================
    public function create(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        if (Election::where('title', $request->name)->exists()) {
            toast("Election Title already exist","error");
            return back();
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

        if (Election::where('title', $request->name)->exists()) {
            toast("Election Title already exist","error");
            return redirect()->back();
        }

        $election = Election::find($id);
        $election->title = $request->input('name');
        $election->election_date = $request->input('date');

        $election->save();
        toast("Election created successfully","success");
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
        $mayor = c_mayor::all();
        return view('elections.register',compact('mayor','districts','election'));
    }

    //==========================Register Mayor/Depaty Mayor view==============================================================================
    public function registerMayorView(Request $request,$id)
    {

        $search = $request->get('search');

        $citizenships = collect();
        $citizen = null;
        if ($search) {
            $citizenships = Citizenship::where('citizenship_number', 'like', "%{$search}%")
                ->latest()
                ->get();
            $citizen = Citizenship::where('citizenship_number', $search)->first();

            if (!$citizen) {
                toast('Citizenship number not found', 'error');
                return back();
            }
        }

        $election = Election::find($id);
        return view('elections.register_mayor', compact('citizen', 'citizenships', 'search','election'));
    }

//==========================Register Mayor/Depaty Mayor==============================================================================
    public function mayorRegister(Request $request){
        $request->validate([
            'citizen_id' => ['required', 'string', 'max:255'],
            'district_id' => ['required', 'string', 'max:255'],
            'palika_id' => ['required', 'string', 'max:255'],
            'election_id' => ['required', 'string', 'max:255'],
            'post' => ['required', 'string', 'max:255'],
            'party' => ['required', 'string', 'max:255'],
            'goal' => ['required', 'string', 'max:255'],

        ]);

        $mayor = new c_mayor();
        $mayor->citizen_id = $request->citizen_id;
        $mayor->district_id = $request->district_id;
        $mayor->palika_id = $request->palika_id;
        $mayor->election = $request->election_id;
        $mayor->post = $request->post;
        $mayor->party = $request->party;
        $mayor->goal = $request->goal;

        $mayor->save();
        toast("Data saved successfully", "success");
        return redirect()->back();
    }

}
