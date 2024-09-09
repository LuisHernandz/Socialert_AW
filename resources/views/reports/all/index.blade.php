@extends('adminlte::page')
@section('title', 'Reportes')

@section('content_header')
    <h1><b>REPORTES CIUDADANOS</b></h1>
@stop

@section('content')
    @if (session('message') == 'del')
        <x-adminlte-card title="Ciudano eliminado!" theme="info" removable>
        </x-adminlte-card>
    @endif

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

            $btnEdit = '<button type="submit" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Atender">
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
                                {!! $btnEdit !!}
                                {!! $btnDetails !!}
                                {!! $btnDelete !!} 

                                {{-- @can('eliminar usuarios')
                                    <form action="{{route('citizens.destroy', $citizen->citizen_id)}}" method="POST" class="formEliminar d-inline">
                                        @csrf
                                        @method('delete')
                                        {!! $btnDelete !!} 
                                    </form>
                                @endcan --}}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </x-adminlte-datatable>
        </div>
    </div>

    {{-- @if($citizens->isEmpty())
    @else --}}
    {{-- Modal --}}
    {{-- <x-adminlte-modal id="modalPurple" title="Más Información" theme="primary" size='lg' disable-animations>
        <form action="{{route('roles.store')}}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row text-gray">
                    <div class="col-sm">
                        <p><b>Nombre Completo:</b> {{$citizen->name}} {{$citizen->lastname}}</p>
                        <p><b>Email:</b> {{$citizen->email}}</p>
                        <p><b>CURP:</b> {{$citizen->curp}}</p>
                        <p><b>Teléfono:</b> {{$citizen->phone}}</p>
                    </div>
                    <div class="col-sm">
                        <p><b>Sexo:</b> {{$citizen->sex}}</p>
                        <p><b>Estado:</b> {{$citizen->status}}</p>
                        <p><b>Creado En:</b> {{$citizen->created_at}}</p>
                    </div>
                </div>
            </div>
        </form>
    </x-adminlte-modal> --}}
    {{-- @endif --}}
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

        .btn-default{
            border: none;
            background-color: inherit;
            box-shadow: none !important;
        }
    </style>
@stop

@section('js')
    <script>
        // Cuando el documento termina de cargarse...
        $(document).ready(function(){
            $('.formEliminar').submit(function(e){ // Disparar funcion Anonima a partir del submit
                e.preventDefault();
                Swal.fire({
                    title: "¿Eliminar a este ciudadano?",
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