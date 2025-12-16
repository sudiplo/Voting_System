<?php

namespace App\Http\Controllers;

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
}
