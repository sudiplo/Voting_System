<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\district;
use App\Models\palika;

class viewController extends Controller
{
    //
    public function welcome(){
        return view('/');
    }
    //about page view
    public function about(){
         $district = district::all();
        $palika=palika::all();
        return view('about',compact('district','palika'));
    }

    // dashboard view
    public function dashboard(){
        return view('dashboard');
    }
}
