<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Reports;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('can:crear reportes')->only('create');
        $this->middleware('can:editar reportes')->only('store');
        $this->middleware('can:eliminar reportes')->only('destroy');
    }

    public function index()
    {
        $alertas = Alert::with(['citizen.user'])->get();

        // return $alertas;

        foreach ($alertas as $alerta) {
            $alerta->formatted_created_at = Carbon::parse($alerta->created_at)->translatedFormat('d \d\e F \d\e Y \a \l\a\s H:i \h\r\s');
        }
        
        return view('reports.alerts.index', compact('alertas'));
        
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
        $reporte = new Reports();
        $reporte->description = "Alerta emitida mediante botón de pánico.";
        $reporte->citizen_id = $request->citizen_id;
        $reporte->save();

        // return $reporte;
    }

    /**
     * Display the specified resource.
     */
    public function show(Alert $alert)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alert $alert)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alert $alert)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alert $alert)
    {
        //
    }
}
