<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rules;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::orderBy('updated_at', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->filter(request(['tag','search']))
            ->paginate(5);
        return view('clients.index',compact('clients'));
    }

    public function indexApi(){
        return response()->json(Client::all());
    }

    public function storeApi(Request $request){
        Client::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'tel' => $request->tel,
            'address' => $request->address,
        ]);
        
        return response()->json([
            'success' => 'Client enregistrer'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname'  => ['required', 'string', 'max:255']
        ];

        if($request->email){
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users'];
        }

        $data = $request->validate($rules);

        $client =  Client::create($data);

        return to_route('clients.index')->with('message',"Votre client $client->lastname $client->firstname à été créer avec succès !");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return view('clients.show',compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view('clients.edit',compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $rules = [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname'  => ['required', 'string', 'max:255']
        ];

        if($request->email){
            $rules['email'] = ['required', 'string', 'email', 'max:255'];
        }

        $data = $request->validate($rules);

        $client->update(array_merge($data,[
            'tel' => $request->tel,
            'email' => $request->email,
            'address' => $request->email,
            'firstname' => strtolower($request->email),
            'lastname' => strtolower($request->email),
        ]));

        return to_route('clients.index')->with('message',"Votre client $client->lastname $client->firstname a été mise à jour avec succès !");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        if($client->delete()){
            return to_route('clients.index')->with("message","Le client $client->firstnane $client->lastname à été supprimer avec succes !");
        }
        return back();
    }


    public function printClients(){
        $pdf = App::make('dompdf.wrapper');
        
        $clients = Client::all();

        $pdf->loadView('pdf.clients', compact(
            'clients'
        ));

        return $pdf->stream();
    }
}
