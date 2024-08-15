@extends('adminlte::page', ['iFrameEnabled' => false])
{{-- @extends('adminlte::page', ['iFrameEnabled' => true]) --}}

@section('title', 'Asignar rol')

@section('content_header')
    {{-- <h1><b>ASIGNAR ROL</b></h1>  --}}
    <br>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title" style="flex-grow: 1;"><b>Asignar Rol</b></h3>

            <div style="flex-grow: 1;" class="text-right">
                <a href="{{route('admins.index')}}">Regresar</a>   
            </div>
        </div>
        <div class="card-body">
            <div>
                <p><b>Usuario:</b> {{$administrador->name}}  {{$administrador->lastname}} </p>
            </div>
            <h5><b>ROLES</b></h5>
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