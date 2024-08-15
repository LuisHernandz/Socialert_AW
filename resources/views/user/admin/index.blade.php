@extends('adminlte::page')
@section('title', 'Administradores')
 
@section('content_header')
    <h1><b>USUARIOS</b></h1>

    @if (session())
        @if (session('message') == 'ok')
            <x-adminlte-card title="Rol asignado!" theme="info" icon="fas fa-lg fa-bell" removable style="font-size: .9rem" class="my-2">
            </x-adminlte-card>
        @endif
    @endif
@stop

@section('content')
    <div class="card">
        <div class="card-header">
           <a href="{{route('admins.create')}}">
                 <x-adminlte-button label="Nuevo" theme="primary" icon="fas fa-plus-circle" class="float-right" data-toggle="modal" data-target="#modalPurple"/>
           </a>
        </div>
        <div class="card-body">
            @php
            $heads = [
                'ID',
                'Apellidos',
                'Nombre',
                'Email',
                'Rol',
                ['label' => 'Acciones', 'no-export' => true, 'width' => 15],
            ];

            $btnEdit = '';
            $btnDelete = '<button type="submit" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Delete">
                            <i class="fa fa-lg fa-fw fa-trash"></i>
                        </button>';
            $btnDetails = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Details">
                            <i class="fa fa-lg fa-fw fa-info-circle"></i>
                        </button>';
            @endphp

            <x-adminlte-datatable id="table1" :heads="$heads">
                @foreach($administradores as $administrador)
                    <tr>
                        <td>{{$administrador->id}}</td>
                        <td>{{$administrador->lastname}}</td>
                        <td>{{$administrador->name}}</td>
                        <td>{{$administrador->email}}</td>
                        <td>
                            @if(!empty($administrador['roles']) && isset($administrador['roles'][0]))
                                {{ $administrador['roles'][0]['name'] }}
                            @else
                                Sin rol asignado
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit" href="{{route('admins.edit', $administrador)}}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>
                            {!! $btnDetails !!}
                            @can('Eliminar')
                                <form action="{{route('admins.destroy', $administrador)}}" method="POST" class="formEliminar d-inline">
                                    @csrf
                                    @method('delete')
                                    {!! $btnDelete !!} 
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
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

        .title-custom {
            font-size: 18px; 
        }

        .btn-default{
            border: none;
            background-color: inherit;
            box-shadow: none !important;
        }
    </style>
@stop

@section('js')
    <script>3
        // Cuando el documento termina de cargarse...
        $(document).ready(function(){
            $('.formEliminar').submit(function(e){ // Disparar funcion Anonima a partir del submit
                e.preventDefault();
                Swal.fire({
                    title: "¿Eliminar a este usuario?",
                    text: "No podras revertir esta accion!",
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