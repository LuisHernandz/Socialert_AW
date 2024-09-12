<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdministradorController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:crear usuarios web')->only('create');
        $this->middleware('can:editar usuarios web')->only('edit');
        $this->middleware('can:eliminar usuarios web')->only('delete');
    }
    public function index()
    {
        $usuarios = User::with('roles')
        ->whereDoesntHave('citizen')
        ->get();
        return view('user.web.index', compact('usuarios'));
    }

    public function create() 
    {
        $roles = Role::all();
        return view('user.web.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validacion = $request->validate([
            'name' => 'required|string|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', 
            'lastname' => 'required|string|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
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

        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->lastname = $request->lastname;
        $usuario->email = $request->email;
        $usuario->password = $request->password;
        $usuario->status = $request->status;
        $usuario->save();

        return back()->with('message', 'ok');
    }

    public function edit(string $id)
    {
        $usuario = User::find($id);
        $roles = Role::all();
        return view('user.web.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, string $id)
    {
        $validacion = $request->validate([
            'name' => 'required|string|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', 
            'lastname' => 'required|string|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'email' => 'required|string|email|max:50',
        ]); 

        $usuario = User::find($id);
        $usuario->name = $request->name;
        $usuario->lastname = $request->lastname;
        $usuario->email = $request->email;
        
        $usuario->roles()->sync($request->roles);
        $usuario->save();

        return redirect()->route('admins.index', $usuario)->with('message', 'ok');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('admins.index', $usuario)->with('message', 'del');
    }
}
