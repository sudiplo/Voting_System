<?php

namespace App\Http\Controllers;

use App\Models\c_mayor;
use Illuminate\Http\Request;
use App\Models\district;
use App\Models\palika;
use App\Models\Election;
use Illuminate\Support\Facades\Auth;


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
        $election = Election::where('status','process')->orderBy('election_date', 'asc')->first();
        if ($election) {
            $candidates = c_mayor::where('palika_id', Auth::user()->citizen->palika_id)->where('election', $election->id)->get();
            return view('User.dashboard', compact('candidates','election'));
        }
        else {
            return view('User.dashboard',compact('election'));
        }
    }
    //
    public function Admindashboard(){
        return view('dashboard');
    }

}
