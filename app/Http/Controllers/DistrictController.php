<?php

namespace App\Http\Controllers;

use App\Models\district;
use App\Models\ward;
use App\Models\palika;
use Illuminate\Http\Request;
use App\Models\votingCenter;

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
    //==========================edit district redirect======================================================================
    public function districEdit($id) {
        $district = district::find($id);
        return view('districts.districedit', compact('district'));
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

    //==========================edit center redirect======================================================================
    public function centerEdit($id) {
        $center = votingCenter::find($id);
        return view('districts.centeredit', compact('center'));
    }
    //==========================delete district==========================================================================
    public function districtDelete($id) {
        $district = district::find($id);
        if ($district->palika()->exists()) {
            toast('Cannot delete district with existing palikas', 'error');
            return redirect()->back();
        }

        $district->delete();
        toast("$district->name District Delete successfully","success");
        return redirect()->back();
    }


    //==========================delete palika=====================================================================
    public function palikaDelete($id) {
        $palika = palika::find($id);
        if ($palika->wards()->exists()) {
            toast('Cannot delete palika with existing wards', 'error');
            return redirect()->back();
        }

        $palika->delete();
        toast("$palika->name Palika Delete successfully","success");
        return redirect()->back();
    }

    //==========================delete ward======================================================================
    public function wardDelete($id) {
        $ward = ward::find($id);
    if ($ward->votingCenters()->exists()) {
        toast('Cannot delete ward with existing voting centers', 'error');
        return redirect()->back();
    }

        $ward->delete();
        toast("$ward->name Ward Delete successfully","success");
        return redirect()->back();
    }

    //==========================delete center======================================================================
    public function centerDelete($id) {
        $center = votingCenter::find($id);
        $center->delete();
        toast("$center->name Voting Center Delete successfully","success");
        return redirect()->Route('districts.index');
    }
}
