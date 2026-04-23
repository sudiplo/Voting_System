<?php
// app/Http/Controllers/EducationDegreeController.php

namespace App\Http\Controllers;

use App\Models\education_degrees;
use Illuminate\Http\Request;

class EducationDegreeController extends Controller
{
    //===============================Show the form=================================================================
    public function create()
    {
        $edu = education_degrees::all();
        return view('elections.candidats.education.index',compact('edu')); // adjust path as needed
    }

    //===============================Save data====================================================================================
    public function store(Request $request)
    {
        $request->validate([
            'level' => 'nullable|string|max:255',
        ]);

        if($request->level) {
            $existing = education_degrees::where('level', $request->level)->first();
            if ($existing) {
                toast('Education degree already exists.', 'error');
                return back();
            }
        }
        $level = new education_degrees;
        $level->level = $request->level;
        $level->save();

        toast('Education degree saved successfully.', 'success');

        return back();
    }

    //=======================================Show edit form===================================================================
    public function edit($id)
    {
        $edu = education_degrees::findOrFail($id);
        return view('elections.candidats.education.update', compact('edu'));
    }

    //=========================================Update degree=================================================================
    public function update(Request $request, $id)
    {
        $request->validate([
            'level' => 'nullable|string|max:255',
        ]);
        if($request->level) {
            $existing = education_degrees::where('level', $request->level)->first();
            if ($existing && $existing->id != $id) {
                toast('Education degree already exists.', 'error');
                return back();
            }
        }
        $degree = education_degrees::find($id);
        $degree->level = $request->level;
        $degree->save();

        toast('Education degree updated successfully.', 'success');
        return back();
    }

    //==========================================Search degree=================================================================
    public function search(Request $request)
    {
        $search = $request->get('search');

        $edu = collect();

        if ($search) {
            $edu = education_degrees::where('level', 'like', "%{$search}%")
                ->latest()
                ->get();
        }

        return view('elections.candidats.education.index', compact('edu', 'search'));
    }

    //=============================================Delete degree===============================================================
    public function destroy($id)
    {
        $degree = education_degrees::findOrFail($id);
        $degree->delete();
        toast('Education degree deleted successfully.', 'success');
        return back();
    }
}
