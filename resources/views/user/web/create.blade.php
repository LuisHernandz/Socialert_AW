@extends('adminlte::page')
@section('title', 'Nuevo Usuario Web')

@section('content_header')
    <br>
@stop

@section('content')
    @if (session())
        @if (session('message') == 'ok')
            <x-adminlte-card title="Registrado correctamente!" theme="info" removable>
            </x-adminlte-card>
        @endif
    @endif

    <div class="card card-primary">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title" style="flex-grow: 1;"><b>Nuevo Usuario Web</b></h3>

            <div style="flex-grow: 1;" class="text-right">
                <a href="{{route('admins.index')}}">Regresar</a>   
            </div>
        </div>
        
        <form action="{{route('admins.store')}}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-sm">
                        <x-adminlte-input id="name" name="name" label="Nombre" label-class="text-gray" value="{{old('name')}}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-user text-gray"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>

                        <x-adminlte-input id="lastname" name="lastname" label="Apellidos" label-class="text-gray" value="{{old('lastname')}}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-user text-gray"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>

                        <x-adminlte-input id="email" name="email" type="email" label="Email" placeholder="ejemplo@gmail.com" label-class="text-gray" value="{{old('email')}}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-envelope text-gray"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input><br>

                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>

                    <div class="col-sm">
                        <x-adminlte-input id="passwordone" name="password" type="password" label="Contraseña" enable-old-support label-class="text-gray" value="{{old('password')}}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-lock text-gray"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
    
                        <x-adminlte-input id="passwordtwo" name="password_confirmation" type="password"  label="Confirmar Contraseña" enable-old-support label-class="text-gray" value="{{old('password_confirmation')}}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-lock text-gray"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>

                        <p>La contraseña debe contener:</p>
                        <ul>
                            <li>Mínimo de 8 caracteres.</li>
                            <li>Una combinación de letras y mayúsculas.</li>
                            <li>Al menos un número (0-9)..</li>
                            <li>Carácteres especiales.</li>
                        </ul>

                        <input type="hidden" name="status" value="activo">
                    </div>
                  </div>
            </div>
            
            {{-- <div class="card-footer">
                <button type="submit" class="btn btn-primary">Registrar</button>
            </div> --}}
        </form>
    </div>
@stop

@section('css')
    <style>
        aside{
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