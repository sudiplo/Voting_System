<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\c_mayor;
use App\Models\citizenship;
use App\Models\Election;
use App\Models\palika;
use App\Models\wardCandidate;
use App\Models\ward;

class CandidateController extends Controller
{
    //

    //==========================Register Mayor/Depaty Mayor view==============================================================================
    public function registerCandidateView(Request $request,$id)
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
        return view('elections.register_candidate', compact('citizen', 'citizenships', 'search','election'));
    }

//==========================Register Candidate==============================================================================
    public function candidateRegister(Request $request){
        $request->validate([
            'citizen_id' => ['required', 'string', 'max:255'],
            'district_id' => ['required', 'string', 'max:255'],
            'palika_id' => ['required', 'string', 'max:255'],
            'ward_id' => ['required', 'string', 'max:255'],
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

        if (c_mayor::where('citizen_id', $request->citizen_id)->where('election',$request->election_id)->exists()) {
            toast("Candidates already Register.","error");
            return redirect()-> back();
        }
        if (wardCandidate::where('citizen_id', $request->citizen_id)->where('election',$request->election_id)->exists()) {
            toast("Candidates already Register.","error");
            return redirect()-> back();
        }

        // if candidate is deputy mayor or mayor
        if ($request->post == 'Deputy Mayor' || $request->post == 'Mayor') {
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
        }else{
            $candidate = new wardCandidate();
            $candidate->citizen_id = $request->citizen_id;
            $candidate->district_id = $request->district_id;
            $candidate->palika_id = $request->palika_id;
            $candidate->ward_id = $request->ward_id;
            $candidate->election = $request->election_id;
            $candidate->post = $request->post;
            $candidate->party = $request->party;
            $candidate->goal = $request->goal;
            $candidate->photo = 'images/' . $filename;

            $candidate->save();
            toast("Data saved successfully", "success");
            return redirect()->back();
        }
    }

//==========================Register Mayors view==============================================================================
    public function mayorView($id, $e_id){
        $e = Election::find($e_id);
        $palika = palika::find($id);
        $candidate = c_mayor::where('election',$e_id)->where('post', 'Mayor')->where('palika_id',$id)->get();
        return view('elections.candidats.mayor',compact('candidate','palika','e'));
    }


//==========================Register Deputy Mayors view==============================================================================
    public function deputyMayorView($id, $e_id){
        $e = Election::find($e_id);
        $palika = palika::find($id);
        $candidate = c_mayor::where('election',$e_id)->where('post', 'Deputy Mayor')->where('palika_id',$id)->get();
        return view('elections.candidats.Depaty_mayor',compact('candidate','palika','e'));
    }


//==========================Register ward candidate view==============================================================================
    public function candidateView($id,$e_id){
        $e = Election::find($e_id);
        $ward = ward::find($id);
        $candidate = wardCandidate::where('election',$e_id)->where('post', 'Ward Chairperson')->where('ward_id',$id)->get();
        return view('elections.candidats.wardCandidate',compact('candidate','ward','e'));
    }
//==========================Register Mayor Profile==============================================================================
    public function mayorProfile($id){
        $mayor = c_mayor::find($id);
        if(!$mayor){
            $mayor = wardCandidate::find($id);
            return view('elections.candidats.profile',compact('mayor'));
        }

        return view('elections.candidats.profile',compact('mayor'));
    }

//==========================Edit Mayors view==============================================================================
    public function mayorEditView($id){
        $mayor = c_mayor::find($id);
        if (!$mayor) {
            $mayor = wardCandidate::find($id);
            return view('elections.candidats.edit_mayor',compact('mayor'));
        }
        return view('elections.candidats.edit_mayor',compact('mayor'));
    }

//==========================Update Mayors data==============================================================================
    public function mayorUpdate(Request $request,$id){
        $request->validate([
            'citizen_id' => ['required', 'string', 'max:255'],
            'district_id' => ['required', 'string', 'max:255'],
            'palika_id' => ['required', 'string', 'max:255'],
            'ward_id' => ['required', 'string', 'max:255'],
            'election_id' => ['required', 'string', 'max:255'],
            'post' => ['required', 'string', 'max:255'],
            'party' => ['required', 'string', 'max:255'],
            'goal' => ['required', 'string', 'max:10000'],
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:6144',
        ]);

        if (c_mayor::where('citizen_id', $request->citizen_id)->
        where('election',$request->election_id)->where('goal',$request->goal)->exists()) {
            toast("Candidates already Register.","error");
            return redirect()-> back();
        }
        if (wardCandidate::where('citizen_id', $request->citizen_id)->
        where('election',$request->election_id)->where('goal',$request->goal)->exists()) {
            toast("Candidates already Register.","error");
            return redirect()-> back();
        }

        // if candidate is deputy mayor or mayor
        if ($request->post == 'Deputy Mayor' || $request->post == 'Mayor') {
            $candidate = wardCandidate::find($id);
            //if data is not come from the c_mayor table
            if ($candidate) {
                $oldPhoto = $candidate ? $candidate->photo : null;
                $mayor = new c_mayor();
                $mayor->citizen_id = $request->citizen_id;
                $mayor->district_id = $request->district_id;
                $mayor->palika_id = $request->palika_id;
                // $mayor->ward_id = $request->ward_id;
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
                    $mayor->photo = $oldPhoto ?? 'images/default.png';
                }
                $candidate->delete();
                $mayor->save();
                toast("Data saved successfully", "success");
                return redirect()->back();
            }
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
            }else {
                $oldPhoto = $mayor ? $mayor->photo : null;
                $mayor->photo = $oldPhoto ?? 'images/default.png';
            }

            $mayor->save();
            toast("Data saved successfully", "success");
            return redirect()->back();
        }
        else  // if candidate is  not deputy mayor or mayor
            {
            $mayor = c_mayor::find($id);
            //if data come from the c_mayor table
            if ($mayor) {
                $mayor->delete();
                $oldPhoto = $mayor ? $mayor->photo : null;
                $candidate = new wardCandidate();
                $candidate->citizen_id = $request->citizen_id;
                $candidate->district_id = $request->district_id;
                $candidate->palika_id = $request->palika_id;
                $candidate->ward_id = $request->ward_id;
                $candidate->election = $request->election_id;
                $candidate->post = $request->post;
                $candidate->party = $request->party;
                $candidate->goal = $request->goal;
                // $mayor->photo = 'images/' . $filename;
                if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                    $photo = $request->file('photo');
                    $filename = time() . '_' . $photo->getClientOriginalName();
                    $photo->move(public_path('images'), $filename);
                    $candidate->photo = 'images/' . $filename;
                } else {
                    $candidate->photo = $oldPhoto ?? 'images/default.png';
                }
                $mayor->delete();
                $candidate->save();
                toast("Data saved successfully", "success");
                return redirect()->back();
            }
            $oldPhoto = $mayor ? $mayor->photo : null;
            $candidate = wardCandidate::find($id);
            $photo = $candidate->photo;
            $candidate->citizen_id = $request->citizen_id;
            $candidate->district_id = $request->district_id;
            $candidate->palika_id = $request->palika_id;
            $candidate->ward_id = $request->ward_id;
            $candidate->election = $request->election_id;
            $candidate->post = $request->post;
            $candidate->party = $request->party;
            $candidate->goal = $request->goal;
            // $mayor->photo = 'images/' . $filename;
            if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                $photo = $request->file('photo');
                $filename = time() . '_' . $photo->getClientOriginalName();
                $photo->move(public_path('images'), $filename);
                $candidate->photo = 'images/' . $filename;
            } else {

                $candidate->photo = $photo ?? 'images/default.png';
            }
            $candidate->save();
            toast("Data saved successfully", "success");
            return redirect()->back();
        }
    }
//==========================Mayors Delete==============================================================================
    public function mayorDelete($id){
        $candidate = c_mayor::find($id);
        if(!$candidate){
            $candidate = wardCandidate::find($id);
            $candidate->delete();
            toast("Candidate Data Delete successfully","success");
            return redirect()->Route('elections.index');
        }
        $candidate->delete();
        toast("Candidate Data Delete successfully","success");
        return redirect()->Route('elections.index');
    }
//==========================Mayors search==============================================================================
    public function mayorSearch(Request $request,$id,$e_id)
    {
        $e = Election::find($e_id);
        $palika = palika::find($id);
        $search = $request->get('search');

        $candidate = c_mayor::with('citizen')
            ->where('post', 'Mayor')
            ->whereHas('citizen', function ($query) use ($search) {
                $query->where('name_english', 'like', "%{$search}%")
                    ->orWhere('name_nepali', 'like', "%{$search}%");
            })
            ->get();

        return view('elections.candidats.mayor', compact('candidate', 'search','palika','e'));
    }
//==========================Depaty Mayors search==============================================================================
    public function depatyMayorSearch(Request $request,$id,$e_id)
    {
        $e = Election::find($e_id);
        $palika = palika::find($id);
        $search = $request->get('search');

        $candidate = c_mayor::with('citizen')
            ->where('post', 'Deputy Mayor')
            ->whereHas('citizen', function ($query) use ($search) {
                $query->where('name_english', 'like', "%{$search}%")
                    ->orWhere('name_nepali', 'like', "%{$search}%");
            })
            ->get();

        return view('elections.candidats.Depaty_mayor', compact('candidate', 'search','palika','e'));
    }
}
