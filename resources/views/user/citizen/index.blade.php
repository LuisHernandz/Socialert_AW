@extends('adminlte::page')
@section('title', 'Usuarios Ciudadanos')

@section('content_header')
    <h1><b>USUARIOS CIUDADANOS</b></h1>
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
                'Nombre Completo',
                'Email',
                'CURP',
                'Teléfono',
                ['label' => 'Acciones', 'no-export' => true, 'width' => 10],
            ];

            $btnEdit = '';
            $btnDelete = '<button type="submit" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Eliminar">
                            <i class="fa fa-lg fa-fw fa-trash"></i>
                        </button>';
            $config = [
                'language' => [
                    'url' => 'https://cdn.datatables.net/plug-ins/2.1.5/i18n/es-MX.json'
                    ],
            ];
            @endphp

<x-adminlte-datatable id="table" :heads="$heads" :config="$config"  class="table table-bordered table-striped">
    @if($citizens->isEmpty())
        <tr>
            <td colspan="6" class="text-center">No hay ciudadanos disponibles.</td>
        </tr>
    @else
        @foreach($citizens as $citizen)
            <tr>
                <td>{{$citizen->id}}</td>
                <td>{{$citizen->name}} {{$citizen->lastname}}</td>
                <td>{{$citizen->email}}</td>
                <td>{{$citizen->curp}}</td>
                <td>{{$citizen->phone}}</td>
                <td class="text-center">
                    <button class="btn btn-xs text-primary mx-1" 
                        data-toggle="modal" 
                        data-target="#modalPurple{{$citizen->id}}">
                        <i class="fa fa-lg fa-fw fa-bell"></i>
                    </button>
                    @can('eliminar usuarios')
                        <form action="{{route('citizens.destroy', $citizen->citizen_id)}}" method="POST" class="formEliminar d-inline">
                            @csrf
                            @method('delete')
                            {!! $btnDelete !!} 
                        </form>
                    @endcan
                </td>
            </tr>

            {{-- Modal --}}
            <x-adminlte-modal id="modalPurple{{$citizen->id}}" title="Más Información" theme="primary" size='lg' disable-animations>
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
                                <p><b>Género:</b>
                                    @switch($citizen->gender)
                                        @case('M')
                                            Masculino
                                            @break
                                        @case('F')
                                            Femenino
                                            @break
                                            No especificado
                                        @default
                                            
                                    @endswitch
                                </p>
                                <p><b>Estado:</b> {{$citizen->status}}</p>
                                <p><b>Creación:</b> {{$citizen->created_at}}</p>
                            </div>
                        </div>
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