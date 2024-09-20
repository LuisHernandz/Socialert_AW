@extends('adminlte::page')
@section('title', 'Alertas')

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

@section('content_header')
    <h1><b>ALERTAS DE PÁNICO</b></h1>
@stop

@section('content')
    @switch(session('message'))
        @case('a')
            <x-adminlte-card title="Alerta atendida, consulta el reporte con id {{ session('reporte_id') }}." theme="info" removable>
            </x-adminlte-card>
            @break
        @case('c')
            <x-adminlte-card title="Se a cancelado el reporte con id {{ session('reporte_id') }}." theme="info" removable>
            </x-adminlte-card>
            @break
        @case('f')
            <x-adminlte-card title="El reporte con id {{ session('reporte_id') }} se a marcado como FALSA." theme="info" removable>
            </x-adminlte-card>
            @break
        @case('del')
            <x-adminlte-card title="Se eliminó el reporte con id {{ session('reporte_id') }}." theme="info" removable>
            </x-adminlte-card>
            @break
        @default     
    @endswitch

    <div class="card">
        <div class="card-body">
            @php
            $heads = [
                'ID',
                'Realizado El',
                'Realizado Por',
                ['label' => 'Acciones', 'no-export' => true, 'width' => 15],
            ];

            $btnEdit = '<button type="submit" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Atender" data-toggle="modal" data-target="#atender">
                            <i class="fa fa-lg fa-fw fa-bell"></i>
                        </button>';
            $btnDelete = '<button type="submit" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Eliminar">
                            <i class="fa fa-lg fa-fw fa-trash"></i>
                        </button>';
            $btnDetails = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Ver más" data-toggle="modal" data-target="#modalPurple">
                            <i class="fa fa-lg fa-fw fa-info-circle"></i>
                        </button>';
            $config = [
                'language' => [
                    'url' => 'https://cdn.datatables.net/plug-ins/2.1.5/i18n/es-MX.json'
                    ],
            ];
            @endphp

            <x-adminlte-datatable id="table" :heads="$heads" :config="$config"  class="table table-bordered table-striped">
                @if($alertas->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">Aún no se han realizado alertas de pánico.</td>
                    </tr>
                @else
                    @foreach($alertas as $alerta)
                        <tr>
                            <td>{{$alerta->id}}</td>
                            <td>{{$alerta->formatted_created_at }}</td>
                            <td>{{$alerta->citizen->user->name}} {{$alerta->citizen->user->lastname}}</td>
                            {{-- <td>
                                @switch($reporte->status)
                                    @case('Pendiente')
                                        <span class="badge badge-warning right">{{ $reporte->status }}</span>
                                        @break
                                    @case('Atendida')
                                        <span class="badge badge-success right">{{ $reporte->status }}</span>
                                        @break
                                    @case('Falsa')
                                        <span class="badge badge-danger right">{{ $reporte->status }}</span>
                                        @break
                                    @case('No Atendida')
                                        <span class="badge badge-secondary right">{{ $reporte->status }}</span>
                                        @break
                                    @default
                                        <span class="badge badge-info right">{{ $reporte->status }}</span>
                                @endswitch
                            </td> --}}
                            <td class="text-center">
                                @can('editar reportes')
                                    <button class="btn btn-xs text-primary mx-1" 
                                        data-toggle="modal" 
                                        data-target="#modalAtender{{$alerta->id}}">
                                        <i class="fa fa-lg fa-fw fa-bell"></i>
                                    </button>
                                @endcan
                                {{-- @can('eliminar reportes')
                                    <form action="{{route('reportes.destroy', $reporte->id)}}" method="POST" class="formEliminar d-inline">
                                        @csrf
                                        @method('delete')
                                        {!! $btnDelete !!} 
                                    </form>
                                @endcan --}}
                            </td>
                        </tr>

                        <x-adminlte-modal id="modalAtender{{$alerta->id}}" title="ALERTA DE PÁNICO" theme="" size='lg' disable-animations>
                            <form action="{{ route('alertas.store', $alerta->id) }}" method="POST">
                                @csrf
                                <div class="card-head bg-gray-400">

                                    <div class="row align-items-center justify-content-between">
                                        <div class="col-md-6">
                                            <p><i><b>Realizado el</b> {{ $alerta->formatted_created_at }}</i></p>
                                            <p><i><b>Reportado Por:</b> {{$alerta->citizen->user->name}} {{$alerta->citizen->user->lastname}} </i></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">     
                                    <hr>
                                    {{-- <details>
                                        <summary>MÁS INFORMACIÓN DEL CIUDADANO</summary>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm">
                                                <p><b>CURP:</b> {{$reporte->citizen_curp}}</p>
                                                <p><b>Número de teléfono:</b> {{$reporte->citizen_phone}}</p>
                                                <p><b>Género: </b>
                                                    @switch($reporte->citizen_gender)
                                                        @case("M")
                                                            Masculino
                                                            @break
                                                        @case("F")
                                                            Femenino
                                                            @break
                                                        @default
                                                            No especificado.
                                                    @endswitch
                                                </p>
                                            </div>
                                            <div class="col-sm">
                                                <p><b>Nombre completo:</b> {{$reporte->user_name}} {{$reporte->user_lastname}}</p>
                                                <p><b>Correo Electrónico:</b> {{$reporte->user_email}}</p>                
                                                <p><b>Se registró el:</b> {{$reporte->formatted_user_created_at}}</p>                
                                            </div>
                                        </div>
                                    </details> --}}
                                    <br>

                                    @if ($alerta->reports_id)
                                    ESTA ALERTA YA HA SIDO ATENDIDA. CONSULTA EL REPORTE CON ID {{$alerta->reports_id}}
                                    @else
                                        <p><b>¿YA HAZ ENVIADO AYUDA A LA UBICACIÓN DE LA ALERTA?</b></p>
                                        <p><i>Si es así, presiona el botón <b>CREAR REPORTE</b> para convertir la alerta a un reporte y mejorar su seguimiento.</i></p>
                                        <input type="hidden" name="alert_id" value="{{$alerta->id}}">
                                        <input type="hidden" name="citizen_id" value="{{$alerta->citizen_id}}">
                                        {{-- <input type="hidden" name="user_id" value="{{ auth()->user()->id }}"> --}}
                                        <input type="submit" class="btn btn-primary" value="CREAR REPORTE">
                                    @endif

   


                                        {{-- <div class="row">
                                            <div class="col-sm">
                                                <input type="hidden" name="status_id" value="1">    
                                                <p><b>¿Cancelar la ATENCIÓN?</b></p>
                                                <input type="submit" class="btn btn-danger" value="CANCELAR">
                                            </div>
                                        </div> --}}
                                </div>
                            </form>
                        </x-adminlte-modal>
                    @endforeach
                @endif
            </x-adminlte-datatable>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <style>
        aside{
            /* background-color: #00162C !important; */
            background-color: #08233d !important;
        }

        .layout-navbar-fixed .wrapper .sidebar-dark-primary .brand-link:not([class*="navbar"]){
            background-color: transparent !important;
        }

        .btn-default{
            border: none;
            background-color: inherit;
            box-shadow: none !important;
        }

        .card-body{
            overflow-y: scroll;
        }

        .btn-tool{
            margin: 0
        } 
    </style>
@stop

@section('js')
    <script>
        Pusher.logToConsole = true;
        var pusher = new Pusher('77e443e085266d4f2f06', {
            cluster: 'us2'
        });
        var channel = pusher.subscribe('my-channel');
        channel.bind('form-submitted', function(data) {
            if (data && data.report && data.report.author && data.report.title) {
            toastr.success('NUEVO REPORTE CIUDADANO', 'Tipo: ' + data.report.title + '<br>Descripción: ' + data.report.author, {
                timeOut: 0,  
                extendedTimeOut: 0,  
            });
            } else {
            console.error('Invalid data structure received:', data);
            }
        });
    </script>

    <script>
        // Cuando el documento termina de cargarse...
        $(document).ready(function(){
            $('.formEliminar').submit(function(e){ // Disparar funcion Anonima a partir del submit
                e.preventDefault();
                Swal.fire({
                    title: "¿Eliminar este reporte?",
                    text: "No podrás revertir esta acción.",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "Cancelar",
                    confirmButtonText: "Confirmar",
                    customClass: {
                        title: 'title-custom' // Clase personalizada
                    }

                }).then((result) => {
                if (result.isConfirmed) {
                        this.submit();
                    }
                });
            })
        })
    </script>
@stop