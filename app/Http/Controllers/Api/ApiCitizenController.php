<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Citizen;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ApiCitizenController extends Controller
{

    public function store(Request $request){

        $validator = Validator::make($request -> all(),[
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'name' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'phone' => 'required|string|max:15',
            'gender' => 'required',
            'curp' => 'required|string|max:18|unique:citizens,curp'
        ]);

        if($validator -> fails()){
            $data = [
                'status' => 0,
                'message' => $validator -> errors()
            ];

            return response() -> json($data, 422);
        }

        DB::beginTransaction();

        try{

            $newUser = User::create([
                'name' => $request -> name,
                'lastname' => $request -> lastname,
                'email' => $request -> email,
                'password' => $request -> password,
                'status' => 'activo'
            ]);

            $newCitizen = Citizen::create([
                'phone' => $request -> phone,
                'gender' => $request -> gender,
                'curp' => $request -> curp,
                'user_id' => $newUser -> id
            ]);

            DB::commit();

            $data = [
                'status' => 1,
                'message' => 'Usuario creado exitosamente.'
            ];

            return response() -> json($data, 201);

        } catch(Exception $e){

            DB::rollback();

            $data = [
                'status' => 0,
                'message' => 'Error en el registro.'
            ];

            return response() -> json([$data, $e], 500);

        }
    }

    public function login_citizen(Request $request){

        $validator = Validator::make($request -> all(),[
            'email' => 'required|email',
            'password' => 'required'
        ],[
            'email.required' => 'El campo email es obligatorio.',
            'email.email' => 'El formato del email es inválido.',
            'password.required' => 'El campo password es obligatorio.'
        ]);

        if($validator -> fails()){
            return response() -> json([
                'message' => 'Error en la validación',
                'errors' => $validator -> errors()
            ], 422);
        }

        $credentials = $request -> only('email', 'password');
        if(!Auth::attempt($credentials)){
            return response() -> json([
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        $user = Auth::user();

        $token = $user -> createToken('auth_token') -> plainTextToken;

        $citizen = Citizen::where('user_id', $user -> id) -> firstOrFail();

        return response() -> json([
            'message' => 'login exitoso',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
            'user_id' => $user->id,
            'citizen_id' => $citizen -> id,
            'name' => $user->name,
            'lastname' => $user -> lastname,
            'phoneNumber' => $citizen -> phoneNumber,
            'curp' => $citizen -> curp,
            'email'  => $user->email,
            'género' => $citizen -> gender
            ],
        ]);
    }

    public function logout_citizen(Request $request){

        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Sesión no válida'], 401);
        }

        $token = $user->currentAccessToken();

        if ($token) {
            $token->delete();
            return response()->json(['message' => 'Cierre de sesión exitoso'], 200);
        } else {
            return response()->json(['message' => 'Token inválido'], 401);
        }
    }

}
