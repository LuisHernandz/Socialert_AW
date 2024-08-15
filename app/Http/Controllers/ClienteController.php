<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

use function Ramsey\Uuid\v1;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource. 
     */
    public function index()
    {
        $clientes = Client::all();
        return view('admin.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validacion = $request->validate([
            'curp' => 'required|min:18',
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email|unique:clients,email',
            'telefono' => 'required|min:9',
            'direccion' => 'required',
        ]);

        $cliente = new Client();
        $cliente->curp = $request->curp;
        $cliente->nombre = $request->nombre;
        $cliente->apellido = $request->apellido;
        $cliente->email = $request->email;
        $cliente->telefono = $request->telefono;
        $cliente->direccion = $request->direccion;
        $cliente->save();

        return back()->with('message', 'ok');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cliente = Client::find($id);
        return view('admin.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $validacion = $request->validate([
        //     'curp' => 'required|min:18',
        //     'nombre' => 'required',
        //     'apellido' => 'required',
        //     'email' => 'required|email|unique:clients,email',
        //     'telefono' => 'required|min:9',
        //     'direccion' => 'required',
        // ]);

        $cliente = Client::find($id);

        $cliente->curp = $request->curp;
        $cliente->nombre = $request->nombre;
        $cliente->apellido = $request->apellido;
        $cliente->email = $request->email;
        $cliente->telefono = $request->telefono;
        $cliente->direccion = $request->direccion;
        $cliente->save();

        return back()->with('message', 'Actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cliente = Client::find($id);
        $cliente->delete();
        return back();
    }
}
