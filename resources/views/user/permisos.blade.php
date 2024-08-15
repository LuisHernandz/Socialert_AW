@extends('adminlte::page')
@section('title', 'Permisos')

@section('content_header')
    <h1>PERMISOS</h1> 
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <x-adminlte-button label="Nuevo" theme="primary" icon="fas fa-key" class="float-right" data-toggle="modal" data-target="#modalPurple"  />
        </div>
        <div class="card-body">
            @php
            $heads = [
                'ID',
                'Nombre',
                ['label' => 'Acciones', 'no-export' => true, 'width' => 20],
            ];

            $btnEdit = '';
            $btnDelete = '<button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                            <i class="fa fa-lg fa-fw fa-trash"></i>
                        </button>';
            $btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                            <i class="fa fa-lg fa-fw fa-eye"></i>
                        </button>';
            @endphp

            <x-adminlte-datatable id="table1" :heads="$heads">
                @foreach($permisos as $permiso)
                    <tr>
                        <td>{{$permiso->id}}</td>
                        <td>{{$permiso->name}}</td>
                        <td>
                            <a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit" href="{{route('permisos.edit', $permiso)}}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>
                            <form action="{{route('permisos.destroy', $permiso)}}" method="POST" class="formEliminar d-inline">
                                @csrf
                                @method('delete')
                                {!! $btnDelete !!} 
                            </form>
                            {!! $btnDetails !!}
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>

    {{-- Themed --}}
    <x-adminlte-modal id="modalPurple" title="Nuevo Permiso" theme="primary" icon="fas fa-bolt" size='lg' disable-animations>
        <form action="{{route('permisos.store')}}" method="POST">
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