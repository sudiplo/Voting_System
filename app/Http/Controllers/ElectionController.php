<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ElectionController extends Controller
{
    //index function
    public function index(){
        return view('elections.index');
    }
}
