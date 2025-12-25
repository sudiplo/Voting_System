<?php

namespace App\Http\Controllers;
use App\Models\Election;
use Illuminate\Http\Request;

class ElectionController extends Controller
{
    //index function
    public function index(){
        $elections = Election::all();
        return view('elections.index', compact('elections'));
    }
    //create function
    public function create(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        if (Election::where('title', $request->name)->exists()) {
            toast("Election Title already exist","error");
            return back();
        }

        $election = new Election();
        $election->title = $request->input('name');
        $election->election_date = $request->input('date');

        $election->save();
        toast("Election created successfully","success");
        return back();

    }

}
