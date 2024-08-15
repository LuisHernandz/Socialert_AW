@extends('adminlte::page', ['iFrameEnabled' => false])
{{-- @extends('adminlte::page', ['iFrameEnabled' => true]) --}}

@section('title', 'Asignar permisos')

@section('content_header')
    {{-- <h1>Roles & Permisos</h1>  --}}
    <br>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title" style="flex-grow: 1;"><b>Asignar Permisos a Rol</b></h3>

            <div style="flex-grow: 1;" class="text-right">
                <a href="{{route('roles.index')}}">Regresar</a>   
            </div>
        </div>
        <div class="card-body">
            <div>
                <p><b>Rol:</b> {{$role->name}}</p>
            </div>
            <h5><b>PERMISOS:</b></h5>
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