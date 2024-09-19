<?php

namespace App\Http\Controllers\Api;

use App\Events\ReportCreated;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reports;
use App\Models\Citizen;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class ApiReportsController extends Controller {

    public function index(){
        try {
            $reportsColumns = DB::getSchemaBuilder()->getColumnListing('reports');
            $reportsColumns = array_diff($reportsColumns, ['citizen_id']);
            $reportsColumns = array_map(function($column){
                return 'reports.' . $column;
            }, $reportsColumns);

            $allReports = DB::table('reports')
            -> leftJoin('status', 'reports.status_id', '=', 'status.id')
            -> leftJoin('types', 'reports.type_id', '=', 'types.id')
            -> select(
                array_merge($reportsColumns, ['status.name as status_name', 'types.name as type_name'])
            )
            -> get();


            if($allReports -> isEmpty()){
                $data = [
                    'status' => 1,
                    'message' => "No existen reportes aún."
                ];

                return response() -> json($data, 404);
            }

            $data = [
                'status' => 1,
                'message' => "Consulta de todos los reportes exitosa.",
                'reports' => $allReports
            ];

            return response() -> json($data, 200);
        } catch(\Exception $e){
            return response() -> json([
                'status' => 0,
                'message' => 'Error al obtener los reportes.',
                'error' => $e -> getMessage()
            ], 500);
        }
    }

    public function show(){
        try {
            $user = Auth::user();
            $citizen = Citizen::where('user_id', $user -> id) -> first();


            if(!$citizen){
                return response() -> json([
                    'status' => 0,
                    'message' => 'Ciudadano no encontrado.'
                ], 404);
            }

            $citizenReports = Reports::where('citizen_id', $citizen -> id) -> get();

            if($citizenReports -> isEmpty()){
                $data = [
                    'status' => 1,
                    'message' => "No existen reportes de este usuario."
                ];
                return response() -> json($data, 404);
            }

            $data = [
                'status' => 1,
                'message' => "Consulta de reportes exitosa.",
                'reports' => $citizenReports
            ];

            return response() -> json($data, 200);

        } catch(\Exception $e){
            return response() -> json([
                'status' => 0,
                'message' => 'Error al obtener los reportes.',
                'error' => $e -> getMessage()
            ], 500);
        }
    }

    // public function store(Request $request){

    //     $validator = Validator::make($request -> all(),[
    //         'description' => 'nullable',
    //         'file' => 'nullable|file|mimes:jpeg,png,jpg,mp4,mov,avi',
    //         'type_id' => 'required|exists:types,id'
    //     ]);

    //     if($validator -> fails()){

    //         $data = [
    //             'status' => 0,
    //             'message' => $validator -> errors()
    //         ];

    //         return response() -> json($data, 422);
    //     }

    //     // $user = Auth::user();
    //     $citizen = Citizen::where('user_id', 2) -> get();

    //     if(!$citizen){
    //         $data = [
    //             'status' => 0,
    //             'message' => 'Ciudadano no encontrado.'
    //         ];

    //         return response() -> json($data, 404);
    //     }

    //     DB::beginTransaction();

    //     try{

    //         $filePath = null;
    //         if ($request->hasFile('file')) {
    //             $filePath = $request->file('file')->store('uploads', 'public');
    //             $fileUrl = asset('storage/' . $filePath);
    //         }

    //         $newReport = Reports::create([
    //             'description' => $request -> description,
    //             'file' => $fileUrl,
    //             'type_id' => $request -> type_id,
    //             'status_id' => 1,
    //             'citizen_id' => $citizen -> id
    //         ]);

    //         // Crear los datos del evento para Pusher
    //         $data = [
    //             'title' => $newReport->description,
    //             'author' => $citizen->name,
    //         ];

    //         // Disparar el evento para Pusher
    //         event(new ReportCreated($data));

    //         DB::commit();

    //         $data = [
    //             'status' => 1,
    //             'message' => 'Reporte enviado correctamente.',
    //             'data' => $newReport,
    //         ];

    //         return response() -> json($data, 201);

    //     }catch(\Exception $e){

    //         DB::rollback();

    //         Log::error("Error al enviar reporte: " . $e -> getMessage());

    //         $data = [
    //             'status' => 0,
    //             'message' => 'Error en el envío del reporte.'
    //         ];

    //         return response() -> json([$data], 500);
    //     }
    // }

  

    public function store(Request $request)
{

    $validator = Validator::make($request->all(), [
        'description' => 'nullable',
        'file' => 'nullable|file|mimes:jpeg,png,jpg,mp4,mov,avi',
        'type_id' => 'required|exists:types,id'
    ]);

    if ($validator->fails()) {
        $data = [
            'status' => 0,
            'message' => $validator->errors()
        ];
        return response()->json($data, 422);
    }
    
    $user = Auth::user();
    $citizen = Citizen::where('user_id', $user -> id) -> first();

    if (!$citizen) {
        // Devolver un error si no se encuentra el ciudadano
        $data = [
            'status' => 0,
            'message' => 'Ciudadano no encontrado.'
        ];
        return response()->json($data, 404);
    }

    DB::beginTransaction();

    try {
        $filePath = null;
        $fileUrl = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads', 'public');
            $fileUrl = asset('storage/' . $filePath);
        }

        $newReport = Reports::create([
            'description' => $request->description,
            'file' => $fileUrl,
            'type_id' => $request->type_id,
            'status_id' => 1,
            'citizen_id' => $citizen->id
        ]);

        // Crear los datos del evento para Pusher
        $data = [
            'title' => $newReport->type_id,
            'author' => $newReport->description,
        ];

        // Disparar el evento para Pusher
        event(new ReportCreated($data));

        DB::commit();

        $data = [
            'status' => 1,
            'message' => 'Reporte enviado correctamente.',
            'data' => $newReport,
        ];

        return response()->json($data, 201);

    } catch (\Exception $e) {
        DB::rollback();
        Log::error("Error al enviar reporte: " . $e->getMessage());

        $data = [
            'status' => 0,
            'message' => 'Error en el envío del reporte.'
        ];

        return response()->json([$data], 500);
    }
}


    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'description' => 'nullable|string|max:500',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,mp4,mov,avi|max:10240',
            'type_id' => 'required|exists:types,id',
            'report_id' => 'required|exists:reports,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()
            ], 422);
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

        $report = Reports::where('id', $request -> report_id)
            ->where('citizen_id', $citizen -> id)
            ->first();

        if (!$report) {
            return response()->json([
                'status' => 0,
                'message' => 'Reporte no encontrado.'
            ], 404);
        }

        DB::beginTransaction();

        try {

            if ($request->hasFile('file')) {

                $oldFilePath = str_replace(asset('storage/') . '/', '', $report->file);

                if (Storage::disk('public')->exists($oldFilePath)) {
                    Storage::disk('public')->delete($oldFilePath);
                }
                $filePath = $request->file('file')->store('uploads', 'public');
                $fileUrl = asset('storage/' . $filePath);
                $report -> file = $fileUrl;
            }

            $report -> description = $request -> description ?? $report -> description;
            $report -> type_id = $request -> type_id;
            $report -> save();

            DB::commit();

            return response()->json([
                'status' => 1,
                'message' => 'Reporte actualizado correctamente.',
                'report' => $report
            ], 200);

        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Error al actualizar reporte: ' . $e -> getMessage());

            return response()->json([
                'status' => 0,
                'message' => 'Error al actualizar el reporte.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Request $request){

        $validator = Validator::make($request -> all(),[
            'report_id' => 'required|exists:reports,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        $citizen = Citizen::where('user_id', $user -> id) -> first();

        if (!$citizen) {
            return response()->json([
                'status' => 0,
                'message' => 'Ciudadano no encontrado.'
            ], 404);
        }

        $report = Reports::where('id', $request->report_id)
            ->where('citizen_id', $citizen->id)
            ->first();

        if (!$report) {
            return response()->json([
                'status' => 0,
                'message' => 'Reporte no encontrado o no pertenece al usuario actual.'
            ], 404);
        }

        DB::beginTransaction();

        try {

            $filePath = str_replace(asset('storage/') . '/', '', $report->file);

            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            $report->delete();

            DB::commit();

            return response()->json([
                'status' => 1,
                'message' => 'Reporte eliminado correctamente.'
            ], 200);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error al eliminar reporte: ' . $e->getMessage());

            return response()->json([
                'status' => 0,
                'message' => 'Error al eliminar el reporte.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
