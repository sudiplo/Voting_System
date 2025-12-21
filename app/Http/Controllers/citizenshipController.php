<?php

namespace App\Http\Controllers;

use App\Models\citizenship;
use Illuminate\Http\Request;
use App\Models\district;
use App\Models\palika;
use App\Models\ward;


class citizenshipController extends Controller
{
    //
    public function view(){
        $citizenships = citizenship::all();
        return view('citizenship.index',compact('citizenships'));
    }

    // to show registration form
    public function registerView(){
        $districts = district::with('palika.wards')->get();
        return view('citizenship.register',compact('districts'));
    }

    // to register new citizenship data
    public function create(Request $request)
    {
        $request->validate([
            'nepaliName' => ['required', 'string', 'max:255'],
            'nameEnglish' => ['required', 'string', 'max:255'],
            'citizenshipNumber' => ['required', 'string', 'max:255', 'unique:citizenships,citizenship_number'],
            'fatherName' => ['required', 'string', 'max:255'],
            'motherName' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date'],
            'gender' => ['required', 'string', 'max:255'],
            'cardType' => ['required', 'string', 'max:255'],
            'district_id' => ['required', 'integer', 'exists:districts,id'],
            'palika_id' => ['required', 'integer', 'exists:palikas,id'],
            'ward_id' => ['required', 'integer', 'exists:wards,id'],
            'partner' => ['nullable', 'string', 'max:255'],
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle the uploaded photo file
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photo = $request->file('photo');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('images'), $filename);
        } else {
            return back()->withErrors(['photo' => 'Photo upload failed or is invalid']);
        }

        // Create new citizen record
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

    // Citizen search view
    public function index(Request $request)
    {
        $search = $request->get('search');

        $citizenships = collect(); // empty by default

        if ($search) {
            $citizenships = Citizenship::where('name_english', 'like', "%{$search}%")
                ->orWhere('name_nepali', 'like', "%{$search}%")
                ->orWhere('citizenship_number', 'like', "%{$search}%")
                ->latest()
                ->get();
        }

        return view('citizenship.index', compact('citizenships', 'search'));
    }

    // citizen profile view
    public function profile($id){
        $citizen = citizenship::find($id);
        return view('citizenship.view',compact('citizen'));
    }

    // citizen edit view
    public function edit($id){
        $citizen = citizenship::find($id);
        $districts = district::with('palika.wards')->get();
        return view('citizenship.edit',compact('citizen','districts'));
    }

    // citizen update
    public function citizenUpdate(Request $request, $id){


    }


}
