<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\district;
use App\Models\palika;
use Illuminate\Http\RedirectResponse;

class AddController extends Controller
{
    //
    
    // district register-------------------------------------------------------------------------------------------------
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

    // palika register save---------------------------------------------------------------
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

}
