<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Citizen;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiCitizenController extends Controller
{

    public function index(){
        return Citizen::all();
    }

    public function show($id){
        try {
            $showUser = User::find($id);
            $showCitizen = Citizen::where('user_id', $id)->first();

            if (!$showUser || !$showCitizen) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Usuario o ciudadano no encontrado.'
                ], 404);
            }

            $data = [
                'Información de usuario' => $showUser,
                'Información de ciudadano' => $showCitizen
            ];
            return response()->json($data, 200);

        } catch (Exception $e) {

            return response()->json([
                'status' => 0,
                'message' => 'Error al mostrar la información.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

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

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'phone' => 'required|string|max:15',
            'gender' => 'required',
            'curp' => 'required|string|max:18|unique:citizens,curp'
        ]);

        if ($validator->fails()) {
            $data = [
                'status' => 0,
                'message' => $validator->errors()
            ];

            return response()->json($data, 422);
        }

        DB::beginTransaction();

        try {

            $updateUser = User::find($id);
            $updateCitizen = Citizen::where('user_id', $id)->first();


            if (!$updateUser || !$updateCitizen) {
                DB::rollback();
                return response()->json([
                    'status' => 0,
                    'message' => 'Usuario o ciudadano no encontrado.'
                ], 404);
            }


            $updateUser->name = $request->name;
            $updateUser->lastname = $request->lastname;
            $updateUser->email = $request->email;
            $updateUser->save();

            $updateCitizen->phone = $request->phone;
            $updateCitizen->gender = $request->gender;
            $updateCitizen->curp = $request->curp;
            $updateCitizen->save();

            DB::commit();

            $data = [
                'status' => 1,
                'message' => 'Información actualizada exitosamente.'
            ];

            return response()->json($data, 200);

        } catch (Exception $e) {
            DB::rollback();

            $data = [
                'status' => 0,
                'message' => 'Error en la actualización.',
                'error' => $e->getMessage() // Proporcionar detalles del error
            ];

            return response()->json($data, 500);
        }
    }

    public function destroy($id){

        DB::beginTransaction();

        try {

            $user = User::find($id);
            $citizen = Citizen::where('user_id', $id)->first();


            if (!$user || !$citizen) {
                DB::rollback();
                return response()->json([
                    'status' => 0,
                    'message' => 'Usuario o ciudadano no encontrado.'
                ], 404);
            }


            $citizen -> delete();
            $user -> delete();

            DB::commit();

            $data = [
                'status' => 1,
                'message' => 'Usuario eliminado'
            ];

            return response()->json($data, 200);

        } catch (Exception $e) {
            DB::rollback();

            $data = [
                'status' => 0,
                'message' => 'Error en la eliminacións',
                'error' => $e->getMessage()
            ];

            return response()->json($data, 500);
        }

    }

}
