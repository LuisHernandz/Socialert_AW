<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Citizen;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiProfileController extends Controller
{
    public function show(){
        try{
            $user = Auth::user();
            $citizen = Citizen::where('user_id', $user -> id) -> first();

            if(!$citizen){
                return response() -> json([
                    'status' => 0,
                    'message' => 'Ciudadano no encontrado.'
                ], 404);
            }

            $userInfo = [
                $user -> name,
                $user -> lastname,
                $user -> email,
                $citizen -> phone,
                $citizen -> gender,
                $citizen -> curp,
            ];


            $data = [
                'status' => 1,
                'message' => "Consulta del perfil exitoso.",
                'contacts' => $userInfo
            ];

            return response() -> json($data, 200);

        } catch(\Exception $e){
            return response() -> json([
                'status' => 0,
                'message' => 'Error al obtener los datos del usuario.',
                'error' => $e -> getMessage()
            ], 500);
        }
    }

    public function update(Request $request){
        $validator = Validator::make($request -> all(),[
            'email' => 'nullable|email|unique:users,email',
            'password' => 'nullable|min:8',
            'name' => 'nullable|string|max:100',
            'lastname' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:15',
            'gender' => 'nullable',
            'curp' => 'nullable|string|max:18|unique:citizens,curp'
        ]);

        if($validator -> fails()){
            $data = [
                'status' => 0,
                'message' => $validator -> errors()
            ];

            return response() -> json($data, 422);
        }

        $user = Auth::user();
        $citizen = Citizen::where('user_id', $user -> id) -> first();

        if(!$citizen){
            $data = [
                'status' => 0,
                'message' => 'Ciudadano no encontrado.'
            ];

            return response() -> json($data, 404);
        }

        DB::beginTransaction();

        try{

            $user -> name = $request -> name ?? $user -> name;
            $user -> lastname = $request -> lastname ?? $user -> lastname;
            $user -> email = $request -> email ?? $user -> email;
            if ($request->filled('password')) {
                $user->password = $request->password;
            }
            $user -> save();
            $citizen -> phone = $request -> phone ?? $citizen -> phone;
            $citizen -> gender = $request -> gender ?? $citizen -> gender;
            $citizen -> curp = $request -> curp ?? $citizen -> curp;
            $citizen -> save();

            DB::commit();

            return response()->json([
                'status' => 1,
                'message' => 'Perfil actualizado correctamente.'
            ], 200);


        }catch(\Exception $e){
            DB::rollback();

            Log::error('Error al actualizar el perfil: ' . $e -> getMessage());

            return response()->json([
                'status' => 0,
                'message' => 'Error al actualizar el reporte.',
            ], 500);
        }

    }

    public function destroy(){
        $user = Auth::user();
        $citizen = Citizen::where('user_id', $user -> id) -> first();

        if (!$citizen) {
            return response()->json([
                'status' => 0,
                'message' => 'Ciudadano no encontrado.'
            ], 404);
        }

        DB::beginTransaction();
        try{
            User::destroy($user -> id);
            DB::commit();

            return response() -> json([
                'status' => 1,
                'message' => "Cuenta eliminada"
            ], 200);

        } catch(\Exception $e){
            DB::rollback();
            Log::error('Error al eliminar la cuenta: ' . $e->getMessage());
            return response() -> json([
                'status' => 0,
                'message' => "Error en la eliminación de la cuenta."
            ], 500);
        }
    }
}
