<?php

namespace App\Http\Controllers;

use App\Models\district;
use App\Models\ward;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $districts = district::with('palika')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                      ->orWhere('name_nepali', 'like', "%$search%")
                      ->orWhereHas('palika', function ($q) use ($search) {
                          $q->where('name', 'like', "%$search%");
                      });
            })
            ->get();

        // For autocomplete suggestions
        $suggestions = district::where('name', 'like', "%$search%")
            ->pluck('name');

        return view('districts.index', compact('districts', 'suggestions', 'search'));
    }

    // delete district ward
    public function wardDelete($id) {
        $ward = ward::find($id);
        $ward->delete();
        toast("ward Delete","success");
        return redirect()->back();
    }
}
