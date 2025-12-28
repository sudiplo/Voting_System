<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\c_mayor;
use App\Models\citizenship;
use App\Models\Election;
use App\Models\palika;

class CandidateController extends Controller
{
    //

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
            'goal' => ['required', 'string', 'max:10000'],
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:6144',
        ]);
        //==========================Handle the uploaded photo file=====================================================================
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photo = $request->file('photo');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('images'), $filename);
        } else {
            toast("Photo size should be less than 6MB","error");
            return back();
        }

        if (c_mayor::where('citizen_id', $request->citizen_id)->exists()) {
            toast("Candidates already Register.","error");
            return redirect()-> back();
        }

        $mayor = new c_mayor();
        $mayor->citizen_id = $request->citizen_id;
        $mayor->district_id = $request->district_id;
        $mayor->palika_id = $request->palika_id;
        $mayor->election = $request->election_id;
        $mayor->post = $request->post;
        $mayor->party = $request->party;
        $mayor->goal = $request->goal;
        $mayor->photo = 'images/' . $filename;

        $mayor->save();
        toast("Data saved successfully", "success");
        return redirect()->back();
    }

//==========================Register Mayors view==============================================================================
    public function mayorView($id){
        $palika = palika::find($id);
        $mayor = c_mayor::where('palika_id',$id)->where('post', 'Mayor')->get();
        return view('elections.candidats.mayor',compact('mayor','palika'));
    }

//==========================Register Deputy Mayors view==============================================================================
    public function deputyMayorView($id){
        $palika = palika::find($id);
        $mayor = c_mayor::where('palika_id',$id)->where('post', 'Deputy Mayor')->get();
        return view('elections.candidats.Depaty_mayor',compact('mayor','palika'));
    }

//==========================Register Mayor Profile==============================================================================
    public function mayorProfile($id){
        $mayor = c_mayor::find($id);
        return view('elections.candidats.profile',compact('mayor'));
    }

//==========================Edit Mayors view==============================================================================
    public function mayorEditView($id){
        $mayor = c_mayor::find($id);
        return view('elections.candidats.edit_mayor',compact('mayor'));
    }

//==========================Update Mayors data==============================================================================
    public function mayorUpdate(Request $request,$id){
        $request->validate([
            'citizen_id' => ['required', 'string', 'max:255'],
            'district_id' => ['required', 'string', 'max:255'],
            'palika_id' => ['required', 'string', 'max:255'],
            'election_id' => ['required', 'string', 'max:255'],
            'post' => ['required', 'string', 'max:255'],
            'party' => ['required', 'string', 'max:255'],
            'goal' => ['required', 'string', 'max:10000'],
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:6144',
        ]);

        $mayor = c_mayor::find($id);
        $mayor->citizen_id = $request->citizen_id;
        $mayor->district_id = $request->district_id;
        $mayor->palika_id = $request->palika_id;
        $mayor->election = $request->election_id;
        $mayor->post = $request->post;
        $mayor->party = $request->party;
        $mayor->goal = $request->goal;
        // $mayor->photo = 'images/' . $filename;
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photo = $request->file('photo');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('images'), $filename);
            $mayor->photo = 'images/' . $filename;
        } else {
            $mayor->photo = $mayor->photo;
        }


        $mayor->save();
        toast("Data saved successfully", "success");
        return redirect()->back();
    }
}
