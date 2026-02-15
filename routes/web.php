<?php

use App\Http\Controllers\AddController;
use App\Http\Controllers\citizenshipController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\viewController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\CandidateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\VotingOtpController;

Route::get('/', [viewController::class,'welcome'])->name('welcome');

// only registered user can route this route's
Route::middleware('auth')->group(function () {
//==========================ProfileController======================================================================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        //===============================USER SIDE===============================================================
        Route::get('/user-profile', [ProfileController::class, 'userProfile'])->name('user.profile');
        Route::get('/user-profile-edit', [ProfileController::class, 'userEdit'])->name('user.profile.edit');

//==========================viewController======================================================================
    Route::get('/about',[viewController::class,'about'])->name('about');
    Route::get('/dashboard', [viewController::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/admin-dashboard', [viewController::class,'Admindashboard'])->middleware(['auth', 'verified'])->name('Admin.dashboard');

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
    Route::get('/citizenship-register',[citizenshipController::class,'registerView'])->name('citizen.registerView');
    Route::post('citizenship',[citizenshipController::class,'create'])->name('citizen.create');
    Route::get('/citizens', [citizenshipController::class, 'index'])->name('citizens.index');
    Route::get('/citizen-profile{id}', [citizenshipController::class, 'profile'])->name('citizen.profile');
    Route::get('/citizen-edit{id}', [citizenshipController::class, 'edit'])->name('citizen.edit');
    Route::patch('/citizen-update{id}', [citizenshipController::class, 'citizenUpdate'])->name('citizen.update');
    Route::delete('/citizen-delete{id}', [citizenshipController::class, 'citizenDelete'])->name('citizen.delete');

// ==========================ElectionController======================================================================
    // Route::resource('elections', ElectionController::class);
    Route::get('/elections', [ElectionController::class, 'index'])->name('elections.index');
    Route::get('/election-register', [ElectionController::class, 'electionRegisterView'])->name('election.register');
    Route::post('/elections/create', [ElectionController::class, 'create'])->name('elections.create');
    Route::get('/election-edit{id}',[ElectionController::class,'electionEdit'])->name('election.editView');
    Route::patch('election-update{id}',[ElectionController::class,'electionUpdate'])->name('election.update');
    Route::delete('/election-delete{id}',[ElectionController::class,'electionDelete'])->name('election.delete');
    Route::get('/elections-view-{id}',[ElectionController::class,'view'])->name('elections.view');
    Route::get('/district-search{id}',[ElectionController::class,'district'])->name('elections.district');
    Route::get('/voting-page',[ElectionController::class,'vote'])->name('elections.vote');
        // =====================user side=========================
    Route::get('/userElections-view',[ElectionController::class,'ElectionDistrict'])->name('elections.userIndex');
    Route::get('/userElection-district-search{id}',[ElectionController::class,'districtSearch'])->name('elections.userDistrict'); //search district


// ==========================CandidateController======================================================================
    Route::get('/new-candidates',[CandidateController::class,'index'])->name('candidates.index');
    Route::get('/register-new-candidate',[CandidateController::class,'registerCandidateView'])->name('register_candidate.index');
    Route::post('/register-candidate',[CandidateController::class,'candidateRegister'])->name('candidate.register');
    Route::get('/mayor-view{id}{e_id}',[CandidateController::class,'mayorView'])->name('mayor.view');
    Route::get('/deputy-mayor-view{id}{e_id}',[CandidateController::class,'deputyMayorView'])->name('Deputy_mayor.view');
    Route::get('/candidate-view{id}{e_id}',[CandidateController::class,'candidateView'])->name('candidate.view');
    Route::get('/candidate-Women-view{id}{e_id}',[CandidateController::class,'candidateWomenView'])->name('candidateWomen.view');
    Route::get('/candidate-Member-view{id}{e_id}',[CandidateController::class,'candidateMemberView'])->name('candidateMember.view');
    Route::get('/candidate-Dalit-view{id}{e_id}',[CandidateController::class,'candidateDalitView'])->name('candidateDalit.view');
    Route::get('/candidate-profile{id}{e_id}',[CandidateController::class,'candidateProfile'])->name('candidateProfile');
    Route::get('/edit-candidate{id}{e_id}',[CandidateController::class,'candidateEditView'])->name('edit_candidate');

    Route::patch('/candidate-update{id}',[CandidateController::class,'candidateUpdate'])->name('candidate.update');
    Route::delete('/delete-candidate{id}',[CandidateController::class,'candidateDelete'])->name('delete_candidate');

    Route::get('/mayor-search{id}{e_id}',[CandidateController::class,'mayorSearch'])->name('mayor_search');
    Route::get('/depaty-mayor-search{id}{e_id}',[CandidateController::class,'depatyMayorSearch'])->name('depatymayor_search');
    Route::get('/chairperson-search{id}{e_id}',[CandidateController::class,'wardChairpersonSearch'])->name('chairperson_search');
    Route::get('/candidate-Women-search{id}{e_id}',[CandidateController::class,'candidateWomenSearch'])->name('candidateWomen_search');
    Route::get('/candidate-Member-search{id}{e_id}',[CandidateController::class,'candidateMemberSearch'])->name('candidateMember_search');
    Route::get('/candidate-Dalit-search{id}{e_id}',[CandidateController::class,'candidateDalitSearch'])->name('candidateDalit_search');
        // ================================user side=====================================
        Route::get('/user-mayor-view{id}{e_id}',[CandidateController::class,'UserMayor'])->name('Usermayor.view');
        Route::get('/user-deputy-mayor-view{id}{e_id}',[CandidateController::class,'UserDeputyMayor'])->name('UserDeputymayor.view');
        Route::get('/user-chairperson-view{id}{e_id}',[CandidateController::class,'UserChairperson'])->name('UserChairperson.view');
        Route::get('/user-ward-member-view{id}{e_id}',[CandidateController::class,'UserMember'])->name('UserMember.view');
        Route::get('/user-candidate-Women-view{id}{e_id}',[CandidateController::class,'UserWomenView'])->name('UserWomen.view');
        Route::get('/user-candidate-Dalit-view{id}{e_id}',[CandidateController::class,'UserDalitView'])->name('UserDalit.view');

        Route::get('/user-mayor-search{id}{e_id}',[CandidateController::class,'UserMayorSearch'])->name('UserMayor_search');
        Route::get('/user-depatyMayor-search{id}{e_id}',[CandidateController::class,'UserDepatyMayorSearch'])->name('UserDepatymayor_search');
        Route::get('/user-chairperson-search{id}{e_id}',[CandidateController::class,'UserChairpersonSearch'])->name('UserChairperson_search');
        Route::get('/user-Member-search{id}{e_id}',[CandidateController::class,'UserMemberSearch'])->name('UserMember_search');
        Route::get('/user-candidate-Women-search{id}{e_id}',[CandidateController::class,'UserWomenSearch'])->name('UserWomen_search');
        Route::get('/user-candidate-Dalit-search{id}{e_id}',[CandidateController::class,'UserDalitSearch'])->name('UsercandidateDalit_search');
        Route::get('/user-candidate-profile{id}{e_id}',[CandidateController::class,'UserCandidateProfile'])->name('UsercandidateProfile');

        // ===============================Voting OTP=====================================
        // User clicks "Cast Vote"
        Route::get('/cast-vote', [VotingOtpController::class, 'sendOtp'])
            ->name('vote.request');

        // Show OTP form
        Route::get('/verify-otp', [VotingOtpController::class, 'showVerifyForm'])
            ->name('otp.verify.form');

        // Verify OTP
        Route::post('/verify-otp', [VotingOtpController::class, 'verifyOtp'])
            ->name('otp.verify');

        // Actual voting page
        Route::get('/vote',[VotingOtpController::class, 'castVote'])
            ->middleware('otp.verified')->name('vote.page');

});


require __DIR__.'/auth.php';
