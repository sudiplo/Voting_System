<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\district;
use App\Models\palika;
use App\Models\votingCenter;
use App\Models\ward;
use Illuminate\Http\RedirectResponse;

class AddController extends Controller
{
    //

    //==========================district register-------------------------------------------------------------------------------------------------
    public function distric(Request $request): RedirectResponse
    {
        $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'name_nepali' => ['required','string','max:255'],
        ]);

        if (district::where('name_nepali', $request->name_nepali)->exists()) {
            toast("Nepali Name already exist","error");
            return back();
        }
        if (district::where('name', $request->name)->exists()) {
            toast("Name already exist","error");
            return back();
        }

        $district = new district();
        $district->name_nepali = $request->name_nepali;
        $district->name = $request->name;

        $district->save();
        toast("Add successfully","success");
        return redirect()->back();
    }

    //==========================district update
    public function districtUpdate(Request $request, $id){
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'name_nepali' => ['required','string','max:255'],
        ]);

        $district = district::find($id);
        $district->name_nepali = $request->name_nepali;
        $district->name = $request->name;

        $district->save();
        toast("District updated successfully","success");
        return redirect()->route('districts.index');
    }

    //==========================palika register save---------------------------------------------------------------
    public function palika(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'district_id'=>['required', 'string', 'max:255'],
        ]);


        if (palika::where('name', $request->name)->exists()) {
            toast("Name already exist","error");
            return back();
        }

        $palika = new palika();
        $palika->name = $request->name;
        $palika->district_id= $request->district_id;

        $palika->save();
        toast("new palika add successfully","success");

        return redirect()->back();
    }

    //==========================palika update
    public function palikaUpdate(Request $request, $id){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'district_id'=>['required', 'string', 'max:255'],
        ]);

        if (palika::where('name', $request->name)->exists()) {
            toast("Name already exist","error");
            return back();
        }
        $palika = palika::find($id);
        $palika->name = $request->name;
        $palika->district_id= $request->district_id;
        $palika->save();
        toast("Palika updated successfully","success");
        return redirect()->route('districts.index');
    }



    //==========================ward register save---------------------------------------------------------------
    public function ward(Request $request){
        $request->validate([
            'number'=>['required','numeric','min:1'],
            'name' => ['required', 'string', 'max:255'],
            'palika_id'=>['required', 'string', 'max:255'],
        ]);


        if (ward::where('name', $request->name)->exists()) {
            toast("Name already exist","error");
            return back();
        }

        $ward = new ward();
        $ward ->number = $request->number;
        $ward->name = $request->name;
        $ward->palika_id= $request->palika_id;

        $ward->save();
        toast("new ward add successfully","success");

        return redirect()->back();
    }
    //==========================ward update
    public function wardUpdate(Request $request, $id){
        $request->validate([
            'number'=>['required','numeric','min:1'],
            'name' => ['required', 'string', 'max:255'],
            'palika_id'=>['required', 'string', 'max:255'],
        ]);

        $ward = ward::find($id);
        $ward ->number = $request->number;
        $ward->name = $request->name;
        $ward->palika_id= $request->palika_id;
        $ward->save();
        toast("Ward updated successfully","success");
        return redirect()->route('districts.index');
    }

    //==========================voting center register-----------------------------------------------------------------
    public function center(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'ward_id'=>['required', 'string', 'max:255'],
        ]);

        $center = new votingCenter();
        $center->name = $request->name;
        $center->ward_id= $request->ward_id;
        $center->save();
        toast("voting center add successfully","success");
        return redirect()->back();
    }

}
