<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\district;
use App\Models\palika;

class viewController extends Controller
{
    //==========================welcome page view======================================================================
    public function welcome(){
        return view('welcome');
    }
    //==========================about page view======================================================================
    public function about(){
         $district = district::all();
        $palika=palika::all();
        return view('about',compact('district','palika'));
    }

    //==========================dashboard view=========================================================================
    public function dashboard(){
        return view('User.dashboard');
    }
    //
    public function Admindashboard(){
        return view('dashboard');
    }

}
