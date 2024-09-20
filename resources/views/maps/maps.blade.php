@extends('adminlte::page')

@section('content_header')
    <h1><b>MAPA GENERAL</b></h1>
@stop

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ol3/3.20.1/ol.css" />
    <style>
        #map {
            width: 100%;
            height: 500px;
        }
    </style>
    <div id="map"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/ol3/3.20.1/ol.js"></script>
    <script>
        var locations = @json($locations);

        var map = new ol.Map({
            target: 'map',
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                })
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([-92.0918, 16.9153]),
                zoom: 14
            })
        });

        var vectorSource = new ol.source.Vector();

        locations.forEach(function(location) {
            var marker = new ol.Feature({
                geometry: new ol.geom.Point(ol.proj.fromLonLat([location.longitude, location.latitude])),
                address: location.address
            });

            vectorSource.addFeature(marker);
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