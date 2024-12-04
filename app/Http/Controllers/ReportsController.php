<?php

namespace App\Http\Controllers;

use App\Models\Reports;
use App\Models\User;
use App\Models\Citizen;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\FcmService;

class ReportsController extends Controller
{

    protected $fcmService;

    public function __construct(FcmService $fcmService)
    {
        $this->fcmService = $fcmService;

        // Middleware para permisos
        $this->middleware('can:crear reportes')->only('create');
        $this->middleware('can:editar reportes')->only('update');
        $this->middleware('can:eliminar reportes')->only('destroy');
    }

    public function index()
    {
        $reportes = DB::table('reports')
        ->select(
            'reports.id',
            'reports.description',
            'reports.file',
            'reports.calification',
            'reports.comment',
            'reports.created_at',
            'reports.updated_at',

            'types.name as type',
            'status.name as status',

            'citizens.phone as citizen_phone',
            'citizens.curp as citizen_curp',
            'citizens.gender as citizen_gender',

            'users.name as user_name',
            'users.lastname as user_lastname',
            'users.email as user_email',
            'users.created_at as user_created_at',

            'userAt.name as userAt_name',
            'userAt.lastname as userAt_lastname',
            'userAt.email as userAt_email'
        )
        ->leftJoin('types', 'reports.type_id', '=', 'types.id')
        ->leftJoin('status', 'reports.status_id', '=', 'status.id')
        ->leftJoin('citizens', 'reports.citizen_id', '=', 'citizens.id')
        ->leftJoin('users', 'citizens.user_id', '=', 'users.id')  // Unión para citizens.user_id
        ->leftJoin('users as userAt', 'reports.userAt_id', '=', 'userAt.id')  // Unión para reports.userAt_id
        ->orderBy('reports.created_at', 'asc')
        ->get();


        foreach ($reportes as $reporte) {
            $reporte->formatted_created_at = Carbon::parse($reporte->created_at)
                ->translatedFormat('d \d\e F \d\e Y \a \l\a\s H:i \h\r\s');
            $reporte->formatted_updated_at = Carbon::parse($reporte->updated_at)
                ->translatedFormat('d \d\e F \d\e Y \a \l\a\s H:i \h\r\s');
            $reporte->formatted_user_created_at = Carbon::parse($reporte->user_created_at)
                ->translatedFormat('d \d\e F \d\e Y \a \l\a\s H:i \h\r\s');
        }

        // return $reportes;
        return view('reports.all.index', compact('reportes'));
    }

    public function update(Request $request, string $id)
    {
        // return $request;

        $reporte = Reports::find($id);
        $reporte->status_id = $request->status_id;
        $reporte->userAt_id = $request->user_id;
        $reporte->save();

        $citizen = Citizen::find($reporte -> citizen_id);
        $citizen_fcm_token = $citizen -> fcm_token;

        $status = Status::find($reporte -> status_id);
        $status_name = $status -> name;

        $this->fcmService->sendNotification(
            $citizen_fcm_token,
            'Estado del reporte actualizado',
            'El estado de tu reporte ha cambiado a: ' . $status_name,
            ['report_id' => 'nada']
        );

        switch ($reporte->status_id) {
            case 2:
                return redirect()->route('reportes.index')->with([
                    'message' => 'a',
                    'reporte_id' => $reporte->id
                ]);
            case 5:
                return redirect()->route('reportes.index')->with([
                    'message' => 'f',
                    'reporte_id' => $reporte->id
                ]);
            default:
                return redirect()->route('reportes.index')->with([
                    'message' => 'c',
                    'reporte_id' => $reporte->id
                ]);
        }
    }

    public function destroy(Reports $reporte)
    {
        $reporte->delete();
        return redirect()->route('reportes.index')->with(['message' => 'del', 'reporte_id' => $reporte->id]);
    }
}
