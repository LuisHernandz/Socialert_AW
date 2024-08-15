@extends('adminlte::page')
@section('title', 'Administrador')

@section('content_header')
    <h1>ADMINISTRADORES</h1> 
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @php
            $heads = [
                'ID',
                'Apellidos',
                'Nombre',
                'Email',
                'Rol',
                // ['label' => 'Phone', 'width' => 20],
                ['label' => 'Acciones', 'no-export' => true, 'width' => 20],
            ];

            $btnEdit = '';
            $btnDelete = '<button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                            <i class="fa fa-lg fa-fw fa-trash"></i>
                        </button>';
            $btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                            <i class="fa fa-lg fa-fw fa-eye"></i>
                        </button>';
            // $config = [
            //     'language' => [
            //         'url' => '//cdn.datatables.net/plug-ins/2.1.3/i18n/es-MX.json',
            //     ]
            // ]
            @endphp

            {{-- Minimal example / fill data using the component slot --}}
            <x-adminlte-datatable id="table1" :heads="$heads">
                @foreach($clientes as $cliente)
                    <tr>
                        <td>{{$cliente->id}}</td>
                        <td>{{$cliente->lastname}}</td>
                        <td>{{$cliente->name}}</td>
                        <td>{{$cliente->email}}</td>
                        <td></td>
                        <td>
                            <a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit" href="{{route('administradores.edit', $cliente)}}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>
                            <form action="{{route('administradores.destroy', $cliente)}}" method="POST" class="formEliminar d-inline">
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