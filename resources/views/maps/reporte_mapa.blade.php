@extends('adminlte::page')

@section('css')
    <style>
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
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: white transparent transparent transparent;
        }
    </style>
@stop

@section('content_header')
    <h1><b>MAPA DEL REPORTE: {{$reporte->id}}</b></h1>

    <div id="map" style="width: 100%; height: 500px;"></div>
    <div id="popup" class="popup">
        <div id="popup-content"></div>
    </div>

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

        marker.setStyle(new ol.style.Style({
            image: new ol.style.Icon({
                src: '/img/posicion.png',
                scale: 0.1
            })
        }));

        var vectorSource = new ol.source.Vector({
            features: [marker]
        });

        var markerLayer = new ol.layer.Vector({
            source: vectorSource
        });

        map.addLayer(markerLayer);

        var popupElement = document.getElementById('popup');
        var popup = new ol.Overlay({
            element: popupElement,
            positioning: 'bottom-center',
            stopEvent: false,
            offset: [0, -10]
        });
        map.addOverlay(popup);

        map.on('click', function(evt) {
            var feature = map.forEachFeatureAtPixel(evt.pixel, function(feature) {
                return feature;
            });

            if (feature) {
                var coordinates = feature.getGeometry().getCoordinates();
                popup.setPosition(coordinates);

                var address = feature.get('address');
                document.getElementById('popup-content').innerHTML = `<p><b>Dirección:</b> ${address}</p>`;

                popupElement.style.display = 'block';
            } else {
                popupElement.style.display = 'none';
            }
        });
    </script>
@stop