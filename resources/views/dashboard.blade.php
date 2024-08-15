@extends('adminlte::page', ['iFrameEnabled' => false])
{{-- @extends('adminlte::page', ['iFrameEnabled' => true]) --}}

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1> 
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>

    <x-adminlte-info-box title="528" text="User Registrations" icon="fas fa-lg fa-user-plus text-primary"
    theme="gradient-primary" icon-theme="white"/>
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