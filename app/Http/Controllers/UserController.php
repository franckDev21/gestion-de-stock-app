<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('id','!=', auth()->user()->id)
            ->orderBy('updated_at', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->filter(request(['tag','search']))
            ->paginate(5);
        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

        return to_route('users.index')->with('message',"Votre utilisateur $user->lastname $user->firstname àété créer avec succès !");
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname'  => ['required', 'string', 'max:255'],
            'tel'       => ['required', 'numeric'],
            'email'     => ['required', 'string', 'email', 'max:255'],
        ]);

        $active = $request->active ? true : false;

        $user->update(array_merge($request->all(),['active'=>$active]));

        return to_route('users.show',$user->id)->with('message',"Les informations de l'utilisateur on été bien mise à jour !");
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->delete()){
            back()->with("message","L'utilisateur $user->firstnane $user->lastname à été supprimer avec succes !");
        }
        return back();
    }

    public function toggleActive(User $user){
        if($user->active){
            $user->update([
                'active' => false
            ]);
            return back()->with("message","L'utilisateur $user->firstnane $user->lastname à été désactiver avec succes !");
        }else{
            $user->update([
                'active' => true
            ]);
            return back()->with("message","L'utilisateur $user->firstnane $user->lastname à été activer avec succes !");
        }
    }

    public function printUsers(){
        $pdf = App::make('dompdf.wrapper');
        
        $users = User::all();

        $pdf->loadView('pdf.users', compact(
            'users'
        ));

        return $pdf->stream();
    }
}
