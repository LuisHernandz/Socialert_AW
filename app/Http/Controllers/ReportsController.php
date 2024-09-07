<?php

namespace App\Http\Controllers;

use App\Models\Reports;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        $reportes = Reports::all();
        return view('reports.index', compact('reportes'));
    }
}