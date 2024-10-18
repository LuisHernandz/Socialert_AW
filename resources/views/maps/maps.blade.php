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
        .popup {
            position: absolute;
            background: white;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            bottom: 12px;
            left: -50px;
            min-width: 200px;
        }
        .popup:after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: white transparent transparent transparent;
        }
    </style>
    <div id="map"></div>
    <div id="popup" class="popup" style="display: none;"></div>

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

            var markerStyle = new ol.style.Style({
                image: new ol.style.Icon({
                    anchor: [0.5, 1],
                    src: '/img/posicion.png',
                    scale: 0.1
                })
            });

            marker.setStyle(markerStyle);
            vectorSource.addFeature(marker);
        });

        var markerLayer = new ol.layer.Vector({
            source: vectorSource
        });

        map.addLayer(markerLayer);

        var element = document.getElementById('popup');
        var popupOverlay = new ol.Overlay({
            element: element,
            autoPan: true,
            autoPanAnimation: {
                duration: 250
            }
        });
        map.addOverlay(popupOverlay);

        map.on('click', function(evt) {
            var feature = map.forEachFeatureAtPixel(evt.pixel, function(feature) {
                return feature;
            });

            if (feature) {
                var coordinates = feature.getGeometry().getCoordinates();
                element.innerHTML = '<b><p>Dirección: </b>' + feature.get('address') + '</p>';
                element.style.display = 'block';
                popupOverlay.setPosition(coordinates);
            } else {
                element.style.display = 'none';
                popupOverlay.setPosition(undefined);
            }
        });
    </script>
@stop

@section('css')
    <style>
        aside {
            background-color: #08233d !important;
        }

        .layout-navbar-fixed .wrapper .sidebar-dark-primary .brand-link:not([class*="navbar"]) {
            background-color: transparent !important;
        }

        .btn-default {
            border: none;
            background-color: inherit;
            box-shadow: none !important;
        }
    </style>
@stop
