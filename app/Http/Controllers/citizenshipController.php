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
        $districts = district::with('palika.wards')->get();
        return view('citizenship.register',compact('districts'));
    }

    // to register new citizenship data
    public function create(Request $request){
        // event(new Registered($user));
        $request->validate([
            'nepaliName' => ['required', 'string', 'max:255'],
            'nameEnglish' => ['required', 'string', 'max:255'],
            'citizenshipNumber' => ['required', 'string', 'max:255'],
            'fatherName' => ['required', 'string', 'max:255'],
            'motherName' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date'],
            'gender' => ['required', 'string', 'max:255'],
            'cardType' => ['required', 'string', 'max:255'],
            // 'district' => ['required', 'string', 'max:255'],
            // 'palika' => ['required', 'string', 'max:255'],
            // 'ward' => ['required', 'string', 'max:255'],
            'district' => ['required', 'integer'],
            'palika' => ['required', 'integer'],
            'ward' => ['required', 'integer'],

            // 'partner' => ['string', 'max:255'],
            'partner' => ['nullable', 'string', 'max:255'],

            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

         if (citizenship::where('citizenship_number', $request->citizenshipNumber)->exists()) {
            toast("Citizenship Number already exist","error");
            return back();
        }

        //
        $photo = $request->file('photo');
        $filename = time().'_'.$photo->getClientOriginalName();
        $photo->move("images/",$filename);

        $citizen = New citizenship();
        $citizen->name_nepali = $request->nepaliName;
        $citizen->name_english = $request->nameEnglish;
        $citizen->citizenship_number = $request->citizenshipNumber;
        $citizen->father = $request->fatherName;
        $citizen->mother = $request->motherName;
        $citizen->dob = $request->dob;
        $citizen->gender = $request->gender;
        $citizen->type = $request->cardType;
        $citizen->district = $request->district;
        $citizen->palika = $request->palika;
        $citizen->ward = $request->ward;
        $citizen->partner = $request->partner;
        $citizen->photo = "images/".$filename;
        // save the data
        $citizen->save();
        toast("Data Save successfully","success");

        return redirect()->back();
    }
}
