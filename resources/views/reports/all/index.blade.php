@extends('adminlte::page')
@section('title', 'Reportes')

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
{{-- <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.11.5/sorting/datetime-moment.js"></script>


@section('content_header')
    <h1><b>REPORTES CIUDADANOS</b></h1>
@stop

@section('content')
    @switch(session('message'))
        @case('a')
            <x-adminlte-card title="Se atendió el reporte con id {{ session('reporte_id') }}, el ciudadano confirmará la ayuda." theme="info" removable>
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
                    // 'url' => 'https://cdn.datatables.net/plug-ins/2.1.5/i18n/es-MX.json'
                    'url' => 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/es-MX.json'
                ],
                'order' => [[0, 'desc']], // Orden descendente por la primera columna (ID)
                'columnDefs' => [
                    [
                        'targets' => 0, // Índice de la columna ID
                        'type' => 'num' // Especifica que se ordene como número
                    ]
                ]
            ];
                        @endphp
            
            {{-- :config="$config"  --}}
            <x-adminlte-datatable id="table" :heads="$heads" :config="$config"  class="table table-bordered table-striped">
                @if($reportes->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">Aún no se han realizado reportes.</td>
                    </tr>
                @else
                    @foreach($reportes as $reporte)
                        <tr>
                            <td>{{$reporte->id}}</td>
                            <td>
                                @if ($reporte->type)
                                {{$reporte->type}}
                                @else
                                    <small>ALERTA DE PÁNICO</small>
                                @endif
                            </td>
                            <td>{{$reporte->description}}</td>
                            <td>{{$reporte->formatted_created_at }}</td>
                            <td>
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
                                    @case('En Proceso')
                                        <span class="badge badge-info right">{{ $reporte->status }}</span>
                                        @break
                                    @default
                                        
                                @endswitch
                            </td>
                            <td class="text-center">
                                {{-- {!! $btnEdit !!} --}}
                                @can('editar reportes')
                                    <button class="btn btn-xs text-primary mx-1" 
                                        data-toggle="modal" 
                                        data-target="#modalAtender{{$reporte->id}}">
                                        <i class="fa fa-lg fa-fw fa-bell"></i>
                                    </button>
                                @endcan
                                @can('eliminar reportes')
                                    <form action="{{route('reportes.destroy', $reporte->id)}}" method="POST" class="formEliminar d-inline">
                                        @csrf
                                        @method('delete')
                                        {!! $btnDelete !!} 
                                    </form>
                                @endcan
                            </td>
                        </tr>

                        <x-adminlte-modal id="modalAtender{{$reporte->id}}" title="REPORTE CIUDADANO" theme="" size='lg' disable-animations>
                            <form action="{{ route('reportes.update', $reporte->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-head bg-gray-400">
                                    @if ($reporte->status === 'No Atendida')
                                        <p><i>El ciudadano no obtuvo el servicio.</i></p>     
                                    @endif

                                    <div class="row align-items-center justify-content-between">
                                        <div class="col-md-6">
                                            <p><b>ESTADO:</b>
                                                <span style="font-size: 1.2rem; text-transform: uppercase;">
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
                                                </span>
                                            </p>
                                            @if ($reporte->status === 'Atendida' || $reporte->status === 'No Atendida')
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
                                                            El servicio aún no ha sido calificado por el ciudadano.
                                                    @endswitch
                                                </p>
                                                
                                            @endif
                                            <p>
                                                <b>TIPO DE REPORTE:</b> 
                                                @if ($reporte->type)
                                                    {{$reporte->type}}
                                                @else
                                                    <small>ALERTA DE PÁNICO</small>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><i><b>Realizado el</b> {{$reporte->formatted_created_at }}</i></p>
                                            <p><i><b>Reportado Por:</b> {{$reporte->user_name}} {{$reporte->user_lastname}}</i></p>
                                            @if ($reporte->status === 'Atendida' || $reporte->status === 'En Proceso' || $reporte->status === 'Falsa' || $reporte->status === 'No Atendida')
                                                <p><i><b>Atendido Por:</b> {{$reporte->userAt_name}} {{$reporte->userAt_lastname}}</i></p>
                                            @endif
                                            @if ($reporte->status === 'Atendida')
                                            <p><i><b>Atendido El:</b> {{$reporte->formatted_updated_at}}</i></p>
                                        @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">     
                                    <details>
                                        <summary>MÁS INFORMACIÓN DEL REPORTE</summary>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm">
                                                <p><b>Descripción:</b> {{$reporte->description}}</p>
                                                <p><b>Realizado Desde:</b></p>

                                                <div class="text-center">
                                                    <a href="{{ route('reporte.mapa', $reporte->id) }}" class="btn btn-xs text-primary mx-1">
                                                        <i class="fa fa-lg fa-fw fa-map-marker"></i> Ver Mapa
                                                    </a>
                                                </div>

                                            <div class="col-sm">
                                                <p><b>Recursos Compartidos:</b></p>
                                                @if ($reporte->file)
                                                    {{-- <p>El archivo existe: <a href="{{ $reporte->file }}" target="_blank">Descargar archivo</a></p> --}}
                                                @else
                                                    <p>No se compartieron archivos por parte del ciudadano.</p>
                                                @endif
                                            
                                            </div>
                                            <div>
                                                <p>
                                                    <b>Comentarios/Sugerencias:</b>
                                                    @if ($reporte->citizen_gender)
                                                        <i>No se realizaron comentarios por parte del ciudadano.</i>
                                                    @else
                                                        {{$reporte->comment}}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </details>
                                    <hr>
                                    <details>
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
                                    </details>
                                    <br>
                                    @if ($reporte->status === 'Pendiente')
                                        <p><b>¿YA HAZ ENVIADO AYUDA A LA UBICACIÓN DEL REPORTE?</b></p>
                                        <p><i>Si es así, presiona el botón <b>ATENDIDO</b></i></p>
                                        <input type="hidden" name="status_id" value="2">
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                        <input type="submit" class="btn btn-primary" value="ATENDIDO">
                                    @endif

                                    @if ($reporte->status === 'En Proceso')
                                        <div class="row">
                                            <div class="col-sm">
                                                <input type="hidden" name="status_id" value="1">    
                                                <p><b>¿Cancelar la ATENCIÓN?</b></p>
                                                <input type="submit" class="btn btn-danger" value="CANCELAR">
                                            </div>
                                        </div>
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

    <script>
        $(document).ready(function() {
    $.fn.dataTable.moment('D [de] MMMM [de] YYYY [a las] H:mm [hrs]'); // Formato personalizado

    $('#reportesTable').DataTable();
});

    </script>
@stop