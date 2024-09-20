<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:crear roles')->only('create');
        $this->middleware('can:editar roles')->only('edit');
        $this->middleware('can:eliminar roles')->only('delete');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('user.roles', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        // $role = Role::create(['name' => $request->nombre]);
        // $role = Role::create([
        //     'name' => $request->nombre,
        // ]);

        $nombre = $request->nombre;

        if (preg_match('/^[a-záéíóúñ0-9 ]+$/i', $nombre)) {
            $rol = new Role();
            $rol->name = $nombre;
            $rol->save();
            return back()->with('success', 'Rol creado correctamente.');
        } else {
            return back()->with('error', 'El nombre del rol solo puede contener letras, acentos y números.');
        }
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
        $role = Role::find($id);
        $permisos = Permission::all();
        return view('user.rolePermiso', compact('role', 'permisos')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::find($id);
        $role->permissions()->sync($request->permisos); // Sincronizar permiso al rol
        return redirect()->route('roles.index', $role)->with('message', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::find($id);

        if ($role) {
            if ($role->users()->count() > 0) {
                return redirect()->route('roles.index')->with('error', 'No se puede eliminar el rol porque está asociado a uno o más usuarios.');
            }
            $role->delete();
            return redirect()->route('roles.index')->with('message', 'Rol eliminado con éxito.');
        }
        return redirect()->route('roles.index')->with('error', 'Rol no encontrado.');
    }
}
