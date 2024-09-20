@extends('adminlte::page')
@section('title', 'Reportes')

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

@section('content_header')
    <h1><b>REPORTES CIUDADANOS</b></h1>
@stop

@section('content')
    @switch(session('message'))
        @case('at')
            <x-adminlte-card title="Se atendió el reporte con id {{ session('reporte_id') }}, el ciudadano confirmará la ayuda." theme="info" removable>
            </x-adminlte-card>
            @break
        @case('ca')
            <x-adminlte-card title="Se a cancelado el reporte con id {{ session('reporte_id') }}." theme="info" removable>
            </x-adminlte-card>
            @break
        @default
            
    @endswitch

    <div class="card">
        <div class="card-body">
            @php
            $heads = [
                'ID',
                'Tipo',
                'Descripción',
                'Realizado El',
                'Estatus',
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
                @if($reportes->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">Aún no se han realizado reportes.</td>
                    </tr>
                @else
                    @foreach($reportes as $reporte)
                        <tr>
                            <td>{{$reporte->id}}</td>
                            <td>{{$reporte->type}}</td>
                            <td>{{$reporte->description}}</td>
                            <td>{{$reporte->created_at}}</td>
                            <td>
                                @if ($reporte->status === "Pendiente")
                                    <span class="badge badge-warning right">{{$reporte->status}}</span>
                                @else
                                    @if ($reporte->status === "Atendida")
                                        <span class="badge badge-success right">{{$reporte->status}}</span>  
                                    @else
                                        <span class="badge badge-info right">{{$reporte->status}}</span>
                                    @endif
                                @endif
                            </td>
                            <td class="text-center">
                                {{-- {!! $btnEdit !!} --}}
                                <button class="btn btn-xs text-primary mx-1" 
                                    data-toggle="modal" 
                                    data-target="#modalAtender{{$reporte->id}}">
                                    <i class="fa fa-lg fa-fw fa-bell"></i>
                                </button>
                                {!! $btnDelete !!} 
                            </td>
                        </tr>

                        <x-adminlte-modal id="modalAtender{{$reporte->id}}" title="REPORTE CIUDADANO" theme="" size='lg' disable-animations>
                            <form action="{{ route('reportes.update', $reporte->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-head bg-gray-400">
                                    <div class="row align-items-center justify-content-between">
                                        <div class="col-md-6">
                                            <p><b>ESTADO:</b>
                                                <span style="font-size: 1.2rem; text-transform: uppercase;">
                                                    @if ($reporte->status === 'Pendiente')
                                                    <span class="badge badge-warning right">Pendiente</span>
                                                    @elseif ($reporte->status === 'Atendida')
                                                        <span class="badge badge-success right">Atendida</span>
                                                    @else
                                                        <span class="badge badge-info right">En Proceso</span>
                                                    @endif
                                                </span>
                                            </p>
                                            @if ($reporte->status === 'Atendida')
                                            <p>
                                                <b>CALIFICACIÓN:</b>
                                                @switch($reporte->calification)
                                                    @case(1)
                                                        ⭐
                                                        @break
                                                    @case(2)
                                                        ⭐⭐
                                                        @break
                                                    @case(3)
                                                        ⭐⭐⭐
                                                        @break
                                                    @case(4)
                                                        ⭐⭐⭐⭐
                                                        @break
                                                    @case(5)
                                                        ⭐⭐⭐⭐⭐
                                                        @break
                                                    @default
                                                        <p>No calificación</p>
                                                @endswitch

                                            </p>
                                            
                                            @endif
                                            <p><b>TIPO DE REPORTE:</b> {{$reporte->type}}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><i><b>Realizado el</b> {{$reporte->formatted_created_at }}</i></p>
                                            <p><i><b>Reportado Por:</b> {{$reporte->user_name}} {{$reporte->user_lastname}}</i></p>
                                            @if ($reporte->status === 'Atendida')
                                                <p><i><b>Atendido Por:</b> {{$reporte->user_name}} {{$reporte->user_lastname}} (Teniente)</i></p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">     
                                    <details>
                                        <summary>MÁS DETALLES</summary>
                                        <div class="row">
                                            <div class="col-sm">
                                                <p><b>Descripción:</b> {{$reporte->description}}</p>
                                                <p><b>Realizado Desde:</b></p>
                                                <div>
                                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3817.5960722249692!2d-92.06984862585313!3d16.89586451678076!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85f2c1f8b5276b53%3A0x978aebe8eb252468!2sUniversidad%20Tecnol%C3%B3gica%20De%20La%20Selva!5e0!3m2!1ses!2smx!4v1725863903541!5m2!1ses!2smx" 
                                                        style="border:0;" allowfullscreen="" loading="lazy">
                                                    </iframe>
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <p><b>Teléfono:</b> {{$reporte->citizen_phone}}</p>
                                                <p><b>Recursos Compartidos:</b></p>
                                            </div>
                                        </div>
                                    </details>

                                    <br>

                                    @if ($reporte->status === 'Pendiente')
                                        <p><b>¿YA HAZ ENVIADO AYUDA A LA UBICACIÓN DEL REPORTE?</b></p>
                                        <p><i>Si es así, presiona el botón <b>ATENDIDO</b></i></p>
                                        <input type="hidden" name="status_id" value="2">
                                        <input type="submit" class="btn btn-primary" value="ATENDIDO">
                                    @endif

                                    @if ($reporte->status === 'En Proceso')
                                        <p><b>¿Cancelar la ATENCIÓN?</b></p>
                                        <input type="hidden" name="status_id" value="1">
                                        <input type="submit" class="btn btn-danger" value="CANCELAR">
                                    @endif
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

@stop