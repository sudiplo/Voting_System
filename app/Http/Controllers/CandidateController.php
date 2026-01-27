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
//<--===================================================REGISTER PAGE===========================================================-->
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



//<--===================================================REGISTRATION SECTION===========================================================-->
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
            $mayor->vote = 0;
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
            $candidate->vote = 0;
            $candidate->photo = 'images/' . $filename;

            $candidate->save();
            toast("Data saved successfully", "success");
            return redirect()->back();
        }
    }



//<--===================================================PAGE VISIT SECTION===========================================================-->
    //==========================Mayors view==============================================================================
    public function mayorView($id, $e_id){
        $e = Election::find($e_id);
        $palika = palika::find($id);
        $candidate = c_mayor::where('election',$e_id)->where('post', 'Mayor')->where('palika_id',$id)->get();
        return view('elections.candidats.mayor',compact('candidate','palika','e'));
    }


    //==========================Deputy Mayors view==============================================================================
    public function deputyMayorView($id, $e_id){
        $e = Election::find($e_id);
        $palika = palika::find($id);
        $candidate = c_mayor::where('election',$e_id)->where('post', 'Deputy Mayor')->where('palika_id',$id)->get();
        return view('elections.candidats.Depaty_mayor',compact('candidate','palika','e'));
    }


    //==========================Ward candidate Ward Chairperson view==============================================================================
    public function candidateView($id,$e_id){
        $e = Election::find($e_id);
        $ward = ward::find($id);
        $candidate = wardCandidate::where('election',$e_id)->where('post', 'Ward Chairperson')->where('ward_id',$id)->get();
        return view('elections.candidats.wardCandidate',compact('candidate','ward','e'));
    }

    //==========================ward candidate ward Member(Women) view==============================================================================
    public function candidateWomenView($id,$e_id){
        $e = Election::find($e_id);
        $ward = ward::find($id);
        $candidate = wardCandidate::where('election',$e_id)->where('post', 'Ward Member(Women)')->where('ward_id',$id)->get();
        return view('elections.candidats.candidateWomen',compact('candidate','ward','e'));
    }

    //==========================ward candidate ward Member view==============================================================================
    public function candidateMemberView($id,$e_id){
        $e = Election::find($e_id);
        $ward = ward::find($id);
        $candidate = wardCandidate::where('election',$e_id)->where('post', 'Ward Member')->where('ward_id',$id)->get();
        return view('elections.candidats.member',compact('candidate','ward','e'));
    }

    public function candidateDalitView($id,$e_id){
        $e = Election::find($e_id);
        $ward = ward::find($id);
        $candidate = wardCandidate::where('election',$e_id)->where('post', 'Ward Member(Dalit)')->where('ward_id',$id)->get();
        return view('elections.candidats.dalit',compact('candidate','ward','e'));
    }

    //==========================Candidate Profile==============================================================================
    public function candidateProfile($id,$e_id){
        $candidate = c_mayor::find($id);
        if(!$candidate){
            $candidate = wardCandidate::find($id);
            $e = $candidate->election;
            $id = $candidate->ward_id;
            return view('elections.candidats.profile',compact('candidate','id','e'));
        }
        $e = $candidate->election;
        $id = $candidate->palika_id;
        return view('elections.candidats.profile',compact('candidate','e','id'));
    }

    //==========================Edit Candidate view==============================================================================
    public function candidateEditView($id,$e_id){
        $candidate = c_mayor::find($id);
        if (!$candidate) {
            $candidate = wardCandidate::find($id);
            if ($candidate) {
                $e  = $candidate->election;
                $id = $candidate->ward_id;
                return view('elections.candidats.edit_mayor', compact('candidate', 'e', 'id'));
            }else{
                $e = $e_id;
                return view('elections.candidats.edit_mayor',compact('candidate','e'));
            }
        }
        $e  = $candidate->election;
        $id = $candidate->palika_id;
        return view('elections.candidats.edit_mayor', compact('candidate', 'e', 'id'));
    }



//<--===================================================UPDATE SECTION===========================================================-->
    //==========================Update Candidate data==============================================================================
    public function candidateUpdate(Request $request,$id){
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
                $vote = $candidate ? $candidate->vote: 0;
                $mayor = new c_mayor();
                $mayor->citizen_id = $request->citizen_id;
                $mayor->district_id = $request->district_id;
                $mayor->palika_id = $request->palika_id;
                // $mayor->ward_id = $request->ward_id;
                $mayor->election = $request->election_id;
                $mayor->post = $request->post;
                $mayor->party = $request->party;
                $mayor->goal = $request->goal;
                $mayor->vote = $vote;
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
            $vote = $mayor ? $mayor->vote: 0;
            $mayor->citizen_id = $request->citizen_id;
            $mayor->district_id = $request->district_id;
            $mayor->palika_id = $request->palika_id;
            $mayor->election = $request->election_id;
            $mayor->post = $request->post;
            $mayor->party = $request->party;
            $mayor->goal = $request->goal;
            $mayor->vote = $vote;
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
            $vote = $mayor ? $mayor->vote : 0;
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
                $candidate->vote = $vote;
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
            $vote = $candidate ? $candidate->vote: 0;
            $photo = $candidate->photo;
            $candidate->citizen_id = $request->citizen_id;
            $candidate->district_id = $request->district_id;
            $candidate->palika_id = $request->palika_id;
            $candidate->ward_id = $request->ward_id;
            $candidate->election = $request->election_id;
            $candidate->post = $request->post;
            $candidate->party = $request->party;
            $candidate->goal = $request->goal;
            $candidate->vote = $vote;
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



//<--===================================================DELETE SECTION===========================================================-->
    //==========================Candidate Delete==============================================================================
    public function candidateDelete($id){
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



//<--===================================================SEARCH SECTION===========================================================-->
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

    //==========================Ward Chairperson search==============================================================================
    public function wardChairpersonSearch(Request $request,$id,$e_id)
    {
        $e = Election::find($e_id);
        $ward = ward::find($id);
        $search = $request->get('search');

        $candidate = wardCandidate::with('citizen')
            ->where('post', 'Ward Chairperson')
            ->whereHas('citizen', function ($query) use ($search) {
                $query->where('name_english', 'like', "%{$search}%")
                    ->orWhere('name_nepali', 'like', "%{$search}%");
            })
            ->get();

        return view('elections.candidats.wardCandidate', compact('candidate', 'search','ward','e'));
    }

    //==========================Ward Member Women search==============================================================================
    public function candidateWomenSearch(Request $request,$id,$e_id)
    {
        $e = Election::find($e_id);
        $ward = ward::find($id);
        $search = $request->get('search');

        $candidate = wardCandidate::with('citizen')
            ->where('post', 'Ward Member(Women)')
            ->whereHas('citizen', function ($query) use ($search) {
                $query->where('name_english', 'like', "%{$search}%")
                    ->orWhere('name_nepali', 'like', "%{$search}%");
            })
            ->get();

        return view('elections.candidats.candidateWomen', compact('candidate', 'search','ward','e'));
    }

    //==========================Ward Member search==============================================================================
    public function candidateMemberSearch(Request $request,$id,$e_id)
    {
        $e = Election::find($e_id);
        $ward = ward::find($id);
        $search = $request->get('search');

        $candidate = wardCandidate::with('citizen')
            ->where('post', 'Ward Member')
            ->whereHas('citizen', function ($query) use ($search) {
                $query->where('name_english', 'like', "%{$search}%")
                    ->orWhere('name_nepali', 'like', "%{$search}%");
            })
            ->get();

        return view('elections.candidats.member', compact('candidate', 'search','ward','e'));
    }

    //==========================Ward Member search==============================================================================
    public function candidateDalitSearch(Request $request,$id,$e_id)
    {
        $e = Election::find($e_id);
        $ward = ward::find($id);
        $search = $request->get('search');

        $candidate = wardCandidate::with('citizen')
            ->where('post', 'Ward Member(Dalit)')
            ->whereHas('citizen', function ($query) use ($search) {
                $query->where('name_english', 'like', "%{$search}%")
                    ->orWhere('name_nepali', 'like', "%{$search}%");
            })
            ->get();

        return view('elections.candidats.dalit', compact('candidate', 'search','ward','e'));
    }

//-----------------------------------------------------------------------------------------------------------------------------------------------------
//================================>USER SIDE<===================================================================================================
    //======================mayor view===================================================
    public function UserMayor($id, $e_id){
        $e = Election::find($e_id);
        $palika = palika::find($id);
        $candidate = c_mayor::where('election',$e_id)->where('post', 'Mayor')->where('palika_id',$id)->get();
        return view('User.candidate.mayor',compact('candidate','palika','e'));
    }

    //==========================Deputy Mayors view==============================================================================
    public function UserDeputyMayor($id, $e_id){
        $e = Election::find($e_id);
        $palika = palika::find($id);
        $candidate = c_mayor::where('election',$e_id)->where('post', 'Deputy Mayor')->where('palika_id',$id)->get();
        return view('User.candidate.deputy_mayor',compact('candidate','palika','e'));
    }

    //==========================Ward Chairperson view==============================================================================
    public function UserChairperson($id,$e_id){
        $e = Election::find($e_id);
        $ward = ward::find($id);
        $candidate = wardCandidate::where('election',$e_id)->where('post', 'Ward Chairperson')->where('ward_id',$id)->get();
        return view('User.candidate.chairperson',compact('candidate','ward','e'));
    }

    //==========================ward Member view==============================================================================
    public function UserMember($id,$e_id){
        $e = Election::find($e_id);
        $ward = ward::find($id);
        $candidate = wardCandidate::where('election',$e_id)->where('post', 'Ward Member')->where('ward_id',$id)->get();
        return view('User.candidate.member',compact('candidate','ward','e'));
    }

    //========================== ward Member(Women) view==============================================================================
    public function UserWomenView($id,$e_id){
        $e = Election::find($e_id);
        $ward = ward::find($id);
        $candidate = wardCandidate::where('election',$e_id)->where('post', 'Ward Member(Women)')->where('ward_id',$id)->get();
        return view('User.candidate.women',compact('candidate','ward','e'));
    }

        //==========================Candidate Profile==============================================================================
    public function UserCandidateProfile($id,$e_id){
        $candidate = c_mayor::find($id);
        if(!$candidate){
            $candidate = wardCandidate::find($id);
            $e = $candidate->election;
            $id = $candidate->ward_id;
            return view('User.candidate.profile',compact('candidate','id','e'));
        }
        $e = $candidate->election;
        $id = $candidate->palika_id;
        return view('User.candidate.profile',compact('candidate','e','id'));
    }


    //=======================mayor search=====================
    public function UserMayorSearch(Request $request,$id,$e_id)
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

        return view('User.candidate.mayor', compact('candidate', 'search','palika','e'));
    }

    //==========================Depaty Mayors search==============================================================================
    public function UserDepatyMayorSearch(Request $request,$id,$e_id)
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

        return view('User.candidate.deputy_mayor', compact('candidate', 'search','palika','e'));
    }

    //==========================Ward Chairperson search==============================================================================
    public function UserChairpersonSearch(Request $request,$id,$e_id)
    {
        $e = Election::find($e_id);
        $ward = ward::find($id);
        $search = $request->get('search');

        $candidate = wardCandidate::with('citizen')
            ->where('post', 'Ward Chairperson')
            ->whereHas('citizen', function ($query) use ($search) {
                $query->where('name_english', 'like', "%{$search}%")
                    ->orWhere('name_nepali', 'like', "%{$search}%");
            })
            ->get();

        return view('User.candidate.chairperson', compact('candidate', 'search','ward','e'));
    }

    //==========================Ward Member search==============================================================================
    public function UserMemberSearch(Request $request,$id,$e_id)
    {
        $e = Election::find($e_id);
        $ward = ward::find($id);
        $search = $request->get('search');

        $candidate = wardCandidate::with('citizen')
            ->where('post', 'Ward Member')
            ->whereHas('citizen', function ($query) use ($search) {
                $query->where('name_english', 'like', "%{$search}%")
                    ->orWhere('name_nepali', 'like', "%{$search}%");
            })
            ->get();

        return view('User.candidate.member', compact('candidate', 'search','ward','e'));
    }

    //==========================Ward Member Women search==============================================================================
    public function UserWomenSearch(Request $request,$id,$e_id)
    {
        $e = Election::find($e_id);
        $ward = ward::find($id);
        $search = $request->get('search');

        $candidate = wardCandidate::with('citizen')
            ->where('post', 'Ward Member(Women)')
            ->whereHas('citizen', function ($query) use ($search) {
                $query->where('name_english', 'like', "%{$search}%")
                    ->orWhere('name_nepali', 'like', "%{$search}%");
            })
            ->get();

        return view('User.candidate.women', compact('candidate', 'search','ward','e'));
    }
}
