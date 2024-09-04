@extends('adminlte::page')
@section('title', 'Usuarios Web')
 
@section('content_header')
    <h1><b>USUARIOS WEB</b></h1>
@stop

@section('content')

    @if (session('message') == 'ok')
        {{-- <x-adminlte-card title="Rol asignado!" theme="info" icon="fas fa-lg fa-bell" removable class="my-2"> --}}
        <x-adminlte-card title="Usuario actualizado!" theme="info" removable>
        </x-adminlte-card>
    @endif
    @if (session('message') == 'del')
        <x-adminlte-card title="Usuario eliminado!" theme="info" removable>
        </x-adminlte-card>
    @endif

    <div class="card">
        <div class="card-header">
            @can('crear usuarios')
                <a href="{{route('admins.create')}}">
                    <x-adminlte-button label="Nuevo" theme="primary" icon="fas fa-plus-circle" class="float-right"/>
                </a>
            @endcan

        </div>
        <div class="card-body">
            @php
            $heads = [
                'ID',
                'Apellidos',
                'Nombre',
                'Email',
                'Rol',
                ['label' => 'Acciones', 'no-export' => true, 'width' => 20],
            ];

            $btnEdit = '';
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

            <x-adminlte-datatable id="table1" :heads="$heads" :config="$config"  class="table table-bordered table-striped">
                @foreach($usuarios as $usuario)
                    <tr>
                        <td>{{$usuario->id}}</td>
                        <td>{{$usuario->lastname}}</td>
                        <td>{{$usuario->name}}</td>
                        <td>{{$usuario->email}}</td>
                        <td>
                            @if(!empty($usuario['roles']) && isset($usuario['roles'][0]))
                                {{ $usuario['roles'][0]['name'] }}
                            @else
                                Ninguno
                            @endif
                        </td>
                        <td>
                            @if (auth()->user()->id === $usuario->id)
                                <i>Edita, Elimina y Accede a tu cuenta desde el apartado de <b>Perfil</b>.</i>
                            @else
                                @can('editar usuarios')
                                    <a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Editar" href="{{route('admins.edit', $usuario)}}">
                                        <i class="fa fa-lg fa-fw fa-pen"></i>
                                    </a>
                                @endcan
                                {!! $btnDetails !!}
                                @can('eliminar usuarios')
                                    <form action="{{route('admins.destroy', $usuario)}}" method="POST" class="formEliminar d-inline">
                                        @csrf
                                        @method('delete')
                                        {!! $btnDelete !!} 
                                    </form>
                                @endcan
                            @endif
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>

    {{-- Modal --}}
    <x-adminlte-modal id="modalPurple" title="Más Información" theme="primary" size='sm' disable-animations>
        <form action="{{route('roles.store')}}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row text-gray">
                    <p><b>Nombre:</b> {{$usuario->name}}</p>
                    <p><b>Apellidos:</b> {{$usuario->lastname}}</p>
                    <p><b>Email:</b> {{$usuario->email}}</p>
                    <p><b>Estado:</b> {{$usuario->status}}</p>
                    <p><b>Creado En:</b> {{$usuario->created_at}}</p>
                </div>
            </div>
        </form>
    </x-adminlte-modal>
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
                    title: "¿Eliminar a este usuario?",
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