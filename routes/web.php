<?php

use App\Http\Controllers\AddController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\citizenshipController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\viewController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\CandidateController;
use Illuminate\Support\Facades\Route;
use App\Models\palika;
use App\Http\Controllers\DistrictController;

Route::get('/', [viewController::class,'welcome'])->name('welcome');

// only registered user can route this route's
Route::middleware('auth')->group(function () {
    //==========================ProfileController======================================================================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //==========================viewController======================================================================
    Route::get('/about',[viewController::class,'about'])->name('about');
    Route::get('/dashboard', [viewController::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

    Route::post("/distric",[AddController::class,'distric'])->name('distric.add');
    Route::post("/palika",[AddController::class,"palika"])->name('palika.add');
    Route::post("/ward",[AddController::class,'ward'])->name('ward.add');
    Route::post('/center', [AddController::class,'center'])->name('center.add');

    //==========================DistrictController======================================================================
    Route::get('/districts', [DistrictController::class, 'index'])->name('districts.index');
    // delete
    Route::delete('/district{id}',[DistrictController::class,'districtDelete'])->name('districts.Delete');
    Route::delete('/ward{id}', [DistrictController::class, 'wardDelete'])->name('districts.wardDelete');
    Route::delete('/palika{id}', [DistrictController::class, 'palikaDelete'])->name('districts.palikaDelete');
    Route::delete('/center{id}', [DistrictController::class, 'centerDelete'])->name('districts.centerDelete');
    // edit page view
    Route::get('/districedit{id}', [DistrictController::class, 'districEdit'])->name('districts.editView');
    Route::get('/wardedit{id}', [DistrictController::class, 'wardEdit'])->name('districts.wardEdit');
    Route::get('/palikaedit{id}', [DistrictController::class, 'palikaEdit'])->name('districts.palikaEdit');
    Route::get('/centeredit{id}', [DistrictController::class, 'centerEdit'])->name('districts.centerEdit');
    // update
    Route::patch('/districtupdate{id}',[AddController::class,'districtUpdate'])->name('district.update');
    Route::patch('/wardupdate{id}', [AddController::class, 'wardUpdate'])->name('ward.update');
    Route::patch('/palikaupdate{id}', [AddController::class, 'palikaUpdate'])->name('palika.update');
    Route::patch('/centerupdate{id}', [AddController::class, 'centerUpdate'])->name('center.update');

    //==========================citizenshipController======================================================================
    Route::get('/citizenship',[citizenshipController::class,'view'])->name('citizen.view');
    Route::get('/citizenship/register',[citizenshipController::class,'registerView'])->name('citizen.registerView');
    Route::post('citizenship',[citizenshipController::class,'create'])->name('citizen.create');
    Route::get('/citizens', [citizenshipController::class, 'index'])->name('citizens.index');
    Route::get('/citizen_profile{id}', [citizenshipController::class, 'profile'])->name('citizen.profile');
    Route::get('/citizen_edit{id}', [citizenshipController::class, 'edit'])->name('citizen.edit');
    Route::patch('/citizen_update{id}', [citizenshipController::class, 'citizenUpdate'])->name('citizen.update');
    Route::delete('/citizen_delete{id}', [citizenshipController::class, 'citizenDelete'])->name('citizen.delete');

    // ==========================ElectionController======================================================================
    // Route::resource('elections', ElectionController::class);
    Route::get('/elections', [ElectionController::class, 'index'])->name('elections.index');
    Route::post('/elections/create', [ElectionController::class, 'create'])->name('elections.create');
    Route::get('/election_edit{id}',[ElectionController::class,'electionEdit'])->name('election.editView');
    Route::patch('election_update{id}',[ElectionController::class,'electionUpdate'])->name('election.update');
    Route::delete('/election_delete{id}',[ElectionController::class,'electionDelete'])->name('election.delete');
    Route::get('/elections_view_{id}',[ElectionController::class,'view'])->name('elections.view');

    // ==========================CandidateController======================================================================
    Route::get('/register_mayor{id}',[CandidateController::class,'registerMayorView'])->name('register_mayor.index');
    Route::post('/register_mayor',[CandidateController::class,'mayorRegister'])->name('mayor.register');
    Route::get('/mayor_view{id}',[CandidateController::class,'mayorView'])->name('mayor.view');
    Route::get('/Deputy_mayor_view{id}',[CandidateController::class,'deputyMayorView'])->name('Deputy_mayor.view');
    Route::get('/mayor_profile{id}',[CandidateController::class,'mayorProfile'])->name('mayorProfile');

});


require __DIR__.'/auth.php';
