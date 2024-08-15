@extends('adminlte::page')
@section('title', 'Administrador')

@section('content_header')
    {{-- <h1>Administrador</h1>  --}}
    <br>
@stop

@section('content')
{{-- @if (session())
    @if (session('message') == 'ok')
    <x-adminlte-card title="Registrado!" theme="info" icon="fas fa-lg fa-bell" removable>
    </x-adminlte-card>
    @endif
@endif --}}

      <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Editar Administrador</h3>
        </div>
        
        
        <form action="{{route('administradores.update', $cliente)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-sm">
                        <x-adminlte-input name="curp" label="CURP" label-class="text-gray" value="{{$cliente->curp}}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-file text-gray"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>

                        <x-adminlte-input name="nombre" label="Nombre" label-class="text-gray" value="{{$cliente->nombre}}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-user text-gray"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
          
                        <x-adminlte-input name="apellido" label="Apellidos" label-class="text-gray" value="{{$cliente->apellido}}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-user text-gray"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </div>
                    <div class="col-sm">
                        <x-adminlte-input name="email" type="email" label="Email" placeholder="ejemplo@gmail.com" label-class="text-gray" value="{{$cliente->email}}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-envelope text-gray"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
    
                        <x-adminlte-input name="telefono" label="Número telefónico" type="tel" igroup-size="sm" label-class="text-gray" value="{{$cliente->telefono}}">
                            <x-slot name="appendSlot">
                                <div class="input-group-text bg-dark">
                                    <i class="fas fa-hashtag text-white"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
    
                        <x-adminlte-input name="direccion" label="Dirección" enable-old-support label-class="text-gray" value="{{$cliente->direccion}}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-map-marked-alt text-gray"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </div>
                  </div>
            </div>
            
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
        </form>
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
    @if (session("message"))
        <script>
            $(document).ready(function(){
                let mensaje = "{{ session('message') }}";
                Swal.fire({
                    'title': 'Resultado',
                    'text': mensaje,
                    'icon': 'success',
                })
            })
        </script>
    @endif
@stop