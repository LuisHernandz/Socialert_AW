<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Citizen;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiContactsController extends Controller
{
    public function index(){

        $user = Auth::user();
        $citizen = Citizen::where('user_id', $user -> id) -> first();

        if(!$citizen){
            $data = [
                'status' => 0,
                'message' => 'Ciudadano no encontrado.'
            ];

            return response() -> json($data, 404);
        }

        try{

            $allContacts = DB::table('citizen_contact as cc')
            -> leftJoin('citizens', 'cc.citizen_id', '=', 'citizens.id')
            -> leftJoin('contacts', 'cc.contact_id', '=', 'contacts.id')
            -> select('cc.relationship','contacts.phone_number','contacts.id as contact_id')
            -> where('citizens.id', '=', $citizen -> id)
            -> get();

            if($allContacts -> isEmpty()){
                $data = [
                    'status' => 1,
                    'message' => "No existen contactos aún."
                ];

                return response() -> json($data, 404);
            }

            $data = [
                'status' => 1,
                'message' => "Consulta de contactos exitosa",
                'reports' => $allContacts
            ];

            return response() -> json($data, 200);

        } catch(\Exception $e){
            return response() -> json([
                'status' => 0,
                'message' => 'Error al obtener los contactos.',
                'error' => $e -> getMessage()
            ], 500);
        }
    }

    public function store(Request $request){

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

            $newContact = Contact::create([
                'phone_number' => $request -> phone_number
            ]);

            DB::table('citizen_contact')->insert([
                'citizen_id' => $citizen->id,
                'contact_id' => $newContact -> id,
                'relationship' => $request->relationship
            ]);

            DB::commit();

            $data = [
                'status' => 1,
                'message' => 'Contacto creado exitosamente.'
            ];

            return response() -> json($data, 201);

        } catch(\Exception $e){

            DB::rollback();

            return response()->json([
                'status' => 0,
                'message' => 'Error en el registro.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request){

        // return $request;

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
        try {
        // Buscar el contacto en la tabla "contacts"
        $contact = Contact::find($request -> contact_id);

        if (!$contact) {
            return response()->json([
                'status' => 0,
                'message' => 'Contacto no encontrado.'
            ], 404);
        }

        // Verificar la relación entre el ciudadano y el contacto en "citizen_contact"
        $citizenContact = DB::table('citizen_contact')
            ->where('citizen_id', $citizen->id)
            ->where('contact_id', $request -> contact_id)
            ->first();

        if (!$citizenContact) {
            return response()->json([
                'status' => 0,
                'message' => 'El contacto no está asociado a este ciudadano.'
            ], 404);
        }

        // Actualizar los datos en ambas tablas
        $contact->update([
            'phone_number' => $request->phone_number
        ]);

        DB::table('citizen_contact')
            ->where('citizen_id', $citizen->id)
            ->where('contact_id', $request -> contact_id)
            ->update([
                'relationship' => $request->relationship
            ]);

        DB::commit();

        return response()->json([
            'status' => 1,
            'message' => 'Contacto actualizado exitosamente.'
        ], 200);
    }catch(\Exception $e){

            DB::rollback();

            return response()->json([
                'status' => 0,
                'message' => 'Error en la actualización.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request){

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

        try {
            $contact = Contact::find($request -> contact_id);

            if (!$contact) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Contacto no encontrado.'
                ], 404);
            }

            Contact::destroy($request -> contact_id);

            DB::commit();

            return response()->json([
                'status' => 1,
                'message' => 'Contacto eliminado exitosamente.'
            ], 200);

        }catch(\Exception $e){

            DB::rollback();

            return response()->json([
                'status' => 0,
                'message' => 'Error en la eliminación.',
                'error' => $e->getMessage()
            ], 500);
        }

    }
}
