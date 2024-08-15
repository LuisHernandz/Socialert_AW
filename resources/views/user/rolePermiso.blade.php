@extends('adminlte::page', ['iFrameEnabled' => false])
{{-- @extends('adminlte::page', ['iFrameEnabled' => true]) --}}

@section('title', 'Dashboard')

@section('content_header')
    <h1>Roles & Permisos</h1> 
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <p>{{$role->name}}</p>
        </div>
        <div class="card-body">
            <h5>Lista de permisos</h5>
            {!! Form::model($role, ['route' => ['roles.update', $role], 'method'=>'put']) !!}
            @foreach ($permisos as $permiso)
                <div>
                    <label>
                        {!! Form::checkbox('permisos[]', $permiso->id, $role->hasPermissionTo($permiso->id) ? : false, ['class'=>'mr-1']) !!}
                        {{$permiso->name}}
                    </label>
                </div>
            @endforeach
            {!! Form::submit('Asignar permisos', ['class'=>'btn btn-primary mt-4']) !!}
            {!! Form::close() !!}
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