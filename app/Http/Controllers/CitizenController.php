<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CitizenController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:eliminar ciudadanos')->only('destroy');
    }
    
    public function index()
    {
        $citizens = DB::table('citizens')
        ->leftJoin('users', 'citizens.user_id', '=', 'users.id')
        ->select(
            'citizens.id as citizen_id',
            'citizens.phone',
            'citizens.gender',
            'citizens.curp',
            'users.id',
            'users.name',
            'users.lastname',
            'users.email',
            'users.status',
            'users.created_at'
        )->get();

        // return response()->json($citizens);
        return view('user.citizen.index', compact('citizens'));
    }

    public function destroy($id)
    {
        try {
            $citizen = Citizen::findOrFail($id);
            $citizen->delete();
            
            return redirect()->route('citizens.index')->with('message', 'del');
        } catch (\Exception $e) {
            // Manejar cualquier excepción y redirigir con un mensaje de error
            return redirect()->route('citizens.index')->with('error', 'Failed to delete citizen.');
        }
        $citizen->delete();
    }
}
