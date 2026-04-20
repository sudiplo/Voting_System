<?php
// app/Http/Controllers/EducationDegreeController.php

namespace App\Http\Controllers;

use App\Models\education_degrees;
use Illuminate\Http\Request;

class EducationDegreeController extends Controller
{
    // Show the form
    public function create()
    {
        $edu = education_degrees::all();
        return view('elections.candidats.education.index',compact('edu')); // adjust path as needed
    }

    // Save data
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

    // Update degree
    public function update(Request $request, $id)
    {
        $degree = education_degrees::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255|unique:education_degrees,name,' . $id,
            'level' => 'nullable|string|max:100',
        ]);

        $degree->update($request->only('name', 'level'));

        return redirect()->route('education.index')
                         ->with('success', 'Degree updated successfully.');
    }

    // Delete degree
    public function destroy($id)
    {
        $degree = education_degrees::findOrFail($id);
        // Optional: prevent deletion if used in candidate_educations
        // if ($degree->candidateEducations()->exists()) { ... }
        $degree->delete();

        return redirect()->route('education.index')
                         ->with('success', 'Degree deleted successfully.');
    }
}