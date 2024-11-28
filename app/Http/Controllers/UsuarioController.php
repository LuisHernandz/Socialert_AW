<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function show()
    {
        return view('aviso.privacidad');
    }
    public function term()
    {
        return view('aviso.terminos');
    }

    public function avisodeprivacidadmovil()
    {
        return view('aviso.avisodeprivacidadmovil');
    }

    public function profile(){
        return view('profile');
    }
}
