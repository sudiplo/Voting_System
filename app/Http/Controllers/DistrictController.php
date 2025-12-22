<?php

namespace App\Http\Controllers;

use App\Models\district;
use App\Models\ward;
use App\Models\palika;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    //==========================district view page======================================================================
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

    //==========================edit ward redirect======================================================================
    public function wardEdit($id) {
        $ward = ward::find($id);
        return view('districts.wardedit', compact('ward'));
    }

    //==========================edit palika redirect======================================================================
    public function palikaEdit($id) {
        $districts= district::all();
        $palika = palika::find($id);
        return view('districts.palikaedit', compact('palika', 'districts'));
    }

    //==========================delete district==========================================================================
    public function districtDelete($id) {
        $district = district::find($id);
        $district->delete();
        toast("$district->name District Delete successfully","success");
        return redirect()->back();
    }

    //==========================delete district palika=====================================================================
    public function palikaDelete($id) {
        $palika = palika::find($id);
        $palika->delete();
        toast("$palika->name Palika Delete successfully","success");
        return redirect()->back();
    }

    //==========================delete district ward======================================================================
    public function wardDelete($id) {
        $ward = ward::find($id);
        $ward->delete();
        toast("$ward->name Ward Delete successfully","success");
        return redirect()->back();
    }
}
