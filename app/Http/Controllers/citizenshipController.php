<?php

namespace App\Http\Controllers;

use App\Models\citizenship;
use Illuminate\Http\Request;
use App\Models\district;
use App\Models\palika;
use App\Models\ward;
use App\Models\user;


class citizenshipController extends Controller
{
    //
    public function view(){
        $citizenships = citizenship::all();
        return view('citizenship.index',compact('citizenships'));
    }


    //==========================to show registration form==============================================================================
    public function registerView(){
        $districts = district::with('palika.wards')->get();
        return view('citizenship.register',compact('districts'));
    }

    //==========================to register new citizenship data=========================================================================
    public function create(Request $request)
    {
        $request->validate([
            'nepaliName' => ['required', 'string', 'max:255'],
            'nameEnglish' => ['required', 'string', 'max:255'],
            'citizenshipNumber' => ['required', 'string', 'max:255'],
            'fatherName' => ['required', 'string', 'max:255'],
            'motherName' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date'],
            'gender' => ['required', 'string', 'max:255'],
            'cardType' => ['required', 'string', 'max:255'],
            'district_id' => ['required', 'integer', 'exists:districts,id'],
            'palika_id' => ['required', 'integer', 'exists:palikas,id'],
            'ward_id' => ['required', 'integer', 'exists:wards,id'],
            'partner' => ['nullable', 'string', 'max:255'],
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:6144',
        ]);
        if (citizenship::where('citizenship_number', $request->citizenshipNumber)->exists()) {
            toast("The Citizenship Number already Register.","error");
            return redirect()-> back();
        }

        //==========================Handle the uploaded photo file=====================================================================
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photo = $request->file('photo');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('images'), $filename);
        } else {
            toast("Photo size should be less than 6MB","error");
            return back();
        }

        //==========================Create new citizen record==============================================================================
        $citizen = new Citizenship();
        $citizen->name_nepali = $request->nepaliName;
        $citizen->name_english = $request->nameEnglish;
        $citizen->citizenship_number = $request->citizenshipNumber;
        $citizen->father = $request->fatherName;
        $citizen->mother = $request->motherName;
        $citizen->dob = $request->dob;
        $citizen->gender = $request->gender;
        $citizen->type = $request->cardType;
        $citizen->district_id = $request->district_id;
        $citizen->palika_id = $request->palika_id;
        $citizen->ward_id = $request->ward_id;
        $citizen->partner = $request->partner;
        $citizen->photo = 'images/' . $filename;

        $citizen->save();

        toast("Data saved successfully", "success");
        return redirect()->back();
    }

    //==========================Citizen search view==============================================================================
    public function index(Request $request)
    {
        $search = $request->get('search');

        $citizenships = collect();

        if ($search) {
            $citizenships = Citizenship::where('name_english', 'like', "%{$search}%")
                ->orWhere('name_nepali', 'like', "%{$search}%")
                ->orWhere('citizenship_number', 'like', "%{$search}%")
                ->latest()
                ->get();
        }

        return view('citizenship.index', compact('citizenships', 'search'));
    }

    //==========================citizen profile view==============================================================================
    public function profile($id){
        $citizen = citizenship::find($id);
        return view('citizenship.view',compact('citizen'));
    }

    //==========================citizen edit view==================================================================================
    public function edit($id){
        $citizen = citizenship::find($id);
        $districts = district::with('palika.wards')->get();
        return view('citizenship.edit',compact('citizen','districts'));
    }

    //==========================citizen update========================================================================================
    public function citizenUpdate(Request $request, $id)
    {
        $request->validate([
            'nepaliName' => ['required', 'string', 'max:255'],
            'nameEnglish' => ['required', 'string', 'max:255'],
            'citizenshipNumber' => ['required', 'string', 'max:255', 'unique:citizenships,citizenship_number,' . $id],
            'fatherName' => ['required', 'string', 'max:255'],
            'motherName' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date'],
            'gender' => ['required', 'string', 'max:255'],
            'cardType' => ['required', 'string', 'max:255'],
            'district_id' => ['required', 'integer', 'exists:districts,id'],
            'palika_id' => ['required', 'integer', 'exists:palikas,id'],
            'ward_id' => ['required', 'integer', 'exists:wards,id'],
            'partner' => ['nullable', 'string', 'max:255'],
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:6144',
        ]);

        // if($request->hasFile('photo') && $request->file('photo')->getSize() > 2048 * 1024){
        //     toast("Photo size should be less than 6MB","error");
        //     return back();
        // }

        $citizen = citizenship::find($id);
        $photo = $citizen->photo;
        $citizen->name_nepali = $request->nepaliName;
        $citizen->name_english = $request->nameEnglish;
        $citizen->citizenship_number = $request->citizenshipNumber;
        $citizen->father = $request->fatherName;
        $citizen->mother = $request->motherName;
        $citizen->dob = $request->dob;
        $citizen->gender = $request->gender;
        $citizen->type = $request->cardType;
        $citizen->district_id = $request->district_id;
        $citizen->palika_id = $request->palika_id;
        $citizen->ward_id = $request->ward_id;
        $citizen->partner = $request->partner;

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photo = $request->file('photo');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('images'), $filename);
            $citizen->photo = 'images/' . $filename;
        } else {
            $citizen->photo = $photo ?? 'images/default.png';
        }


        $citizen->save();

        toast("Profile updated successfully", type: "success");
        return redirect()->back();
    }


    //==========================delete citizen record====================================================================================
    public function citizenDelete($id) {
        $citizen = citizenship::find($id);
        $citizen->delete();
        toast("$citizen->name Record Delete successfully","success");
        return redirect()->back();
    }

    //==========================voter view====================================================================================
    public function voterView(){
        $districts = district::with('palika.wards')->get();
        $voter = user::where('usertype','user')->get();
        return view('citizenship.voter',compact('voter','districts'));
    }

    // ==========================voter profile view==============================================================================
    public function voterSearch(Request $request){
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
        return view('citizenship.voter',compact('voter','districts','d','p','w'));
    }


}
