<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdministradorController extends Controller
{
    public function __construct()
    {
        // $this->middleware('can:gestionar_usuarios')->only('index');
        // $this->middleware('can:gestionar_usuarios')->only('create');
    }
    public function index()
    {
        // $administradores = User::all();
        $administradores = User::with('roles')->get();
        return view('user.admin.index', compact('administradores'));
    }

    public function create()
    {
        return view('user.admin.create');
    }

    public function store(Request $request)
    {
        $validacion = $request->validate([
            'name' => 'required|string|max:50', 
            'lastname' => 'required|string|max:50',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',            // Mínimo 8 caracteres
                'confirmed',        // Debe coincidir con un campo llamado password_confirmation
                'regex:/[a-z]/',    // Debe contener al menos una letra minúscula
                'regex:/[A-Z]/',    // Debe contener al menos una letra mayúscula
                'regex:/[0-9]/',    // Debe contener al menos un número
                'regex:/[@$!%*?&]/' // Debe contener al menos un carácter especial
            ],
        ]); 

        $administrador = new User();
        $administrador->name = $request->name;
        $administrador->lastname = $request->lastname;
        $administrador->email = $request->email;
        $administrador->password = $request->password;
        $administrador->save();

        return back()->with('message', 'ok');
    }

    public function edit(string $id)
    {
        $administrador = User::find($id);
        $roles = Role::all();
        return view('user.admin.edit', compact('administrador', 'roles'));
    }

    public function update(Request $request, string $id)
    {
        $administrador = User::find($id);
        $administrador->roles()->sync($request->roles);
        return redirect()->route('admins.index', $administrador)->with('message', 'ok');
    }

    public function destroy(string $id)
    {
        //
    }
}
