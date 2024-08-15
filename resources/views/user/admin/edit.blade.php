@extends('adminlte::page', ['iFrameEnabled' => false])
{{-- @extends('adminlte::page', ['iFrameEnabled' => true]) --}}

@section('title', 'Dashboard')

@section('content_header')
    <h1>Asignar Rol</h1> 
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <p>{{$administrador->nombre}}</p>
        </div>
        <div class="card-body">
            <h5>Lista de permisos</h5>
            {!! Form::model($administrador, ['route' => ['admins.update', $administrador], 'method'=>'put']) !!}
            @foreach ($roles as $role)
                <div>
                    <label>
                        {!! Form::checkbox('roles[]', $role->id, $administrador->hasAnyRole($role->id) ? : false, ['class'=>'mr-1']) !!}
                        {{$role->name}}
                    </label>
                </div>
            @endforeach
            {!! Form::submit('Asignar rol', ['class'=>'btn btn-primary mt-4']) !!}
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