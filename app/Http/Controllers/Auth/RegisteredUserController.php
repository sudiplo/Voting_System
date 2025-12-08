<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        // $user = User::create([
        //     'name' => $request->name,
        //     'phone'=> $request->phone,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        //     'photo'=>"images/".$filename,
        // ]);

        // event(new Registered($user));
        $request->validate([
        // 'name'   => 'required',
        // 'phone'  => 'required',
        // 'email'  => 'required|email',
        // 'address'=> 'required',
        'name' => ['required', 'string', 'max:255'],
        'phone' =>['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    if (User::where('email', $request->email)->exists()) {
        toast("Email already exist","error");
        return back();
    }
    if (User::where('phone', $request->phone)->exists()) {
        toast("Phone already exist","error");
        return back();
    }

    $user = new User();
    $user->name    = $request->name;
    $user->phone   = $request->phone;
    $user->email   = $request->email;
    $user->password = Hash::make($request->password);

    $photo = $request->file('photo');
        if ($photo) {
            $filename = time().'_'.$photo->getClientOriginalName();
            $photo->move("images/",$filename);
            $user->photo = "images/".$filename;
        }

    $user->save();
    toast("Account create successfully","success");

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
