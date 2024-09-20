@extends('adminlte::page')

@section('content_header')
    <h1><b>MAPA DEL REPORTE: {{$reporte->id}}</b></h1>

    <div id="map" style="width: 100%; height: 500px;"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/ol3/3.20.1/ol.js"></script>
    <script>
        var map = new ol.Map({
            target: 'map',
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                })
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([{{$reporte->longitude}}, {{$reporte->latitude}}]),
                zoom: 14
            })
        });

        var marker = new ol.Feature({
            geometry: new ol.geom.Point(ol.proj.fromLonLat([{{$reporte->longitude}}, {{$reporte->latitude}}])),
            address: '{{$reporte->address}}'
        });

        var vectorSource = new ol.source.Vector({
            features: [marker]
        });

        var markerLayer = new ol.layer.Vector({
            source: vectorSource
        });

        map.addLayer(markerLayer);

        map.on('click', function(evt) {
            map.forEachFeatureAtPixel(evt.pixel, function(feature) {
                alert('Dirección: ' + feature.get('address'));
            });
        });
    </script>
@stop
