@extends('adminlte::page')
@section('title', 'Roles')

@section('content_header')
    <h1><b>ROLES</b></h1> 

    @if (session())
        @if (session('message') == 'ok')
            <x-adminlte-card title="Permisos asignados!" theme="info" icon="fas fa-lg fa-bell" removable style="font-size: .9rem" class="my-2">
            </x-adminlte-card>
        @endif
    @endif

    @if(session('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            @can('crear roles')
                <x-adminlte-button label="Nuevo" theme="primary" icon="fas fa-plus-circle" class="float-right" data-toggle="modal" data-target="#modalPurple"  />
            @endcan
           
        </div>
        <div class="card-body">
            @php
            $heads = [
                'ID',
                'Nombre',
                ['label' => 'Acciones', 'no-export' => true, 'width' => 20],
            ];

            $btnEdit = '';
            $btnDelete = '<button type="submit" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Delete">
                            <i class="fa fa-lg fa-fw fa-trash"></i>
                        </button>';
            $btnDetails = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Details">
                            <i class="fa fa-lg fa-fw fa-info-circl"></i>
                        </button>';
            @endphp

            <x-adminlte-datatable id="table1" :heads="$heads">
                @foreach($roles as $rol)
                    <tr>
                        <td>{{$rol->id}}</td>
                        <td>{{$rol->name}}</td>
                        <td>
                            @can('editar roles')
                                <a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit" href="{{route('roles.edit', $rol)}}">
                                    <i class="fa fa-lg fa-fw fa-pen"></i>
                                </a>
                            @endcan
                            
                            @can('eliminar roles')
                                <form action="{{route('roles.destroy', $rol)}}" method="POST" class="formEliminar d-inline">
                                    @csrf
                                    @method('delete')
                                    {!! $btnDelete !!} 
                                </form>
                            @endcan

                            {!! $btnDetails !!}
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>

    {{-- Themed --}}
    <x-adminlte-modal id="modalPurple" title="Nuevo Rol" theme="primary" icon="fas fa-plus-circle" size='lg' disable-animations>
        <form action="{{route('roles.store')}}" method="POST">
            @csrf
            <div class="card-body">
                <x-adminlte-input name="nombre" label="Nombre" label-class="text-gray" value="{{old('nombre')}}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-user text-gray"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Registrar</button>
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
                    title: "Deseas eliminar este registro?",
                    text: "No podras revertir esta accion!",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "Cancelar",
                    confirmButtonText: "Confirmar"
  
                }).then((result) => {
                if (result.isConfirmed) {
                        this.submit();
                    }
                 });
            })
        })
    </script>
@stop