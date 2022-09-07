<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        dd($request->all());
        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname'  => ['required', 'string', 'max:255'],
            'tel'       => ['required', 'numeric'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        
        $active = $request->active ? true : false;

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname'  => $request->lastname,
            'tel'       => $request->tel,
            'active'    => $active,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        // event(new Registered($user));

        // Auth::login($user);

        return to_route('users.index')->with('message',"Votre utilisateur $user->lastname $user->firstname àété créer avec succès !");
    }
}
