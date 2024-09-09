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

                        <x-adminlte-modal id="modalAtender{{$reporte->id}}" title="REPORTE {{$reporte->id}}" theme="" size='lg' disable-animations>
                            <form action="{{ route('roles.store') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <p><b>Estado:</b>
                                        @if ($reporte->status === 'Pendiente')
                                            <span class="badge badge-warning right">Pendiente</span>
                                        @elseif ($reporte->status === 'Atendida')
                                            <span class="badge badge-success right">Atendida</span>
                                        @else
                                            <span class="badge badge-info right">En Proceso</span>
                                        @endif
                                    </p>
                                    <p><b>Fecha:</b> {{$reporte->created_at}}</p>
                                    <div class="row text-black">
                                        <div class="col-sm">
                                            <p><b>Tipo:</b> {{$reporte->type}}</p>
                                            <p><b>Descripción:</b> {{$reporte->description}}</p>
                                            <p><b>Realizado Desde:</b></p>
                                            <div>
                                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3817.5960722249692!2d-92.06984862585313!3d16.89586451678076!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85f2c1f8b5276b53%3A0x978aebe8eb252468!2sUniversidad%20Tecnol%C3%B3gica%20De%20La%20Selva!5e0!3m2!1ses!2smx!4v1725863903541!5m2!1ses!2smx" 
                                                    style="border:0;" allowfullscreen="" loading="lazy">
                                                </iframe>
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <p><b>Reportado Por:</b> {{$reporte->user_name}} {{$reporte->user_lastname}}</p>
                                            <p><b>CURP:</b> {{$reporte->citizen_curp}}</p>
                                            <p><b>Teléfono:</b> {{$reporte->citizen_phone}}</p>
                                            <p><b>Recursos Compartidos:</b></p>
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

    {{-- @if($citizens->isEmpty())
    @else --}}
    {{-- Modal --}}
    {{-- <x-adminlte-modal id="atender" title="REPORTE" theme="sucess" size='lg' disable-animations>
        <form action="{{route('roles.store')}}" method="POST">
            @csrf
            <div class="card-body">
                <p>
                    <b>Estado:</b>
                    @if ($reporte->status === 'Pendiente')
                        <span class="badge badge-warning right">Pendiente</span>
                    @else
                        @if ($reporte->status === 'Atendida')
                            <span class="badge badge-success right">Atendida</span>
                        @else
                            <span class="badge badge-info right">En Proceso</span>
                        @endif                        
                    @endif
                    
                </p>
                <p><b>Fecha:</b> {{$reporte->created_at}}</p>
                <div class="row text-black">
                    <div class="col-sm">
                        <p><b>Tipo:</b> {{$reporte->type}}</p>
                        <p><b>Descripción:</b> {{$reporte->description}}</p>
                        <p><b>Realizado Desde:</b></p>
                        <div>
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3817.5960722249692!2d-92.06984862585313!3d16.89586451678076!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85f2c1f8b5276b53%3A0x978aebe8eb252468!2sUniversidad%20Tecnol%C3%B3gica%20De%20La%20Selva!5e0!3m2!1ses!2smx!4v1725863903541!5m2!1ses!2smx" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                    <div class="col-sm">
                        <p><b>Reportado Por:</b> {{$reporte->user_name}} {{$reporte->user_lastname}}</p>
                        <p><b>CURP:</b> {{$reporte->citizen_curp}}</p>
                        <p><b>Telefono:</b> {{$reporte->citizen_phone}}</p>
                        <p><b>Recursos Compartidos:</b></p>
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
        function fetchReportes() {
            $.ajax({
                url: '{{ route("reportes.show") }}',
                method: 'GET',
                success: function(response) {
                    let tableBody = '';
                    
                    // Recorrer los datos recibidos y actualizar la tabla
                    response.forEach(function(reporte) {
                        tableBody += `
                            <tr>
                                <td>${reporte.id}</td>
                                <td>${reporte.type}</td>
                                <td>${reporte.description}</td>
                                <td>${reporte.created_at}</td>
                                <td>
                                    ${reporte.status === "Pendiente" ? '<span class="badge badge-warning right">Pendiente</span>' : ''}
                                    ${reporte.status === "Atendida" ? '<span class="badge badge-success right">Atendida</span>' : ''}
                                    ${reporte.status === "En Proceso" ? '<span class="badge badge-info right">En Proceso</span>' : ''}
                                </td>
                                <td class="text-center">
                                    {!! $btnEdit !!}
                                    {!! $btnDelete !!}
                                </td>
                            </tr>
                        `;
                    });

                    $('#table tbody').html(tableBody); // Reemplazar el contenido del tbody de la tabla
                }
            });
        }

        // Llamar a fetchReportes cada 30 segundos
        setInterval(fetchReportes, 15000); 
    </script>

    {{-- <script>
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
    </script> --}}
@stop