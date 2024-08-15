@extends('adminlte::page', ['iFrameEnabled' => false])
{{-- @extends('adminlte::page', ['iFrameEnabled' => true]) --}}

@section('title', 'Dashboard')

@section('content_header')
    <h1><b>Dashboard</b></h1> 
@stop

@section('content')
    <p>Bienvenido al panel del Administrador.</p>



    <div class="row">
        <div class="col-lg-4 col-6">
            <x-adminlte-info-box title="528" text="Usuarios Registrados" icon="fas fa-lg fa-user-plus text-primary"
            theme="gradient-primary" icon-theme="white"/>
        </div>
        <div class="col-lg-4 col-6">
            <x-adminlte-info-box title="528" text="Alertas rápidas emitidas" icon="fas fa-location-arrow text-danger"
            theme="danger" icon-theme="white"/>
        </div>
        <div class="col-lg-4 col-6">
            <x-adminlte-info-box title="528" text="Descargas de la aplicación móvil" icon="fas fa-lg fa-download text-purple"
            theme="purple" icon-theme="white"/>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-6">
            <x-adminlte-info-box title="56/60" text="Reportes Atendidos" icon="far fa-check-circle text-success"
            theme="success" icon-theme="white" progress=60 progress-theme="teal"
            description="56% reportes atendidos correctamente"/>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <style>
        aside{
            /* background-color: #00162C !important; */
            background-color: #08233d !important;
        }

        .layout-navbar-fixed .wrapper .sidebar-dark-primary .brand-link:not([class*="navbar"]){
            background-color: transparent !important;
        }
    </style>
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop