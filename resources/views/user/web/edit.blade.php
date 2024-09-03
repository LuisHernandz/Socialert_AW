@extends('adminlte::page', ['iFrameEnabled' => false])

@section('title', 'Editar Usuario Web')

@section('content_header')
    <br>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title" style="flex-grow: 1;"><b>Editar Usuario Web</b></h3>

            <div style="flex-grow: 1;" class="text-right">
                <a href="{{route('admins.index')}}">Regresar</a>   
            </div>
        </div>
        <div class="card-body">
            <div class="text-gray">
                <p><b>Usuario:</b> {{$usuario->name}}  {{$usuario->lastname}} </p>

                <h5><b>DATOS:</b></h5>
            </div>
    
            <form action="{{route('admins.update', $usuario)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm">
                            <x-adminlte-input id="name" name="name" label="Nombre" label-class="text-gray" value="{{$usuario->name}}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-user text-gray"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
    
                            <x-adminlte-input id="lastname" name="lastname" label="Apellidos" label-class="text-gray" value="{{$usuario->lastname}}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-user text-gray"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
    
                            <x-adminlte-input id="email" name="email" type="email" label="Email" placeholder="ejemplo@gmail.com" label-class="text-gray" value="{{$usuario->email}}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-envelope text-gray"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input><br>
    
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
    
                        <div class="col-sm text-gray">
                            <p><b>Asignar Rol(es)</b></p>
                            <div class="ml-4">
                                {!! Form::model($usuario, ['route' => ['admins.update', $usuario], 'method'=>'put']) !!}
                                @foreach ($roles as $role)
                                    <div>
                                        <label>
                                            {!! Form::checkbox('roles[]', $role->id, $usuario->hasAnyRole($role->id) ? : false, ['class'=>'mr-1']) !!}
                                            {{$role->name}}
                                        </label>
                                    </div>
                                @endforeach
                                {{-- {!! Form::submit('Asignar rol', ['class'=>'btn btn-primary mt-4']) !!} --}}
                                {!! Form::close() !!}
                            </div>
                        </div>
                      </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
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
    <script src="{{ asset('assets/script/logs.js') }}"></script>
@stop