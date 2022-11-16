<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Chauffeur {{ auth()->user()->name }}</title>
    @include('inc.css')
</head>

<body class="animsition">
    <div class="page-wrapper">
        @include('chauffeur.sidebar')

        <div class="page-container">
            @include('admin.header')

            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap mb-3">
                                    <h2 class="title-1">Poubelles assignées
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive table--no-carde m-b-40">
                                    <table class="table table-borderless table-striped table-info">
                                        <thead>
                                            @php
                                                $n = 1;
                                            @endphp
                                            <tr>
                                                <th></th>
                                                <th>Client</th>
                                                <th>N° Poubelle</th>
                                                <th>Taille</th>
                                                <th>Niveau déchets</th>
                                                <th>Etat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($poubelles as $el)
                                                <tr>
                                                    <td>{{ $n++ }}</td>
                                                    <td>{{ $el->user->name }}</td>
                                                    <td>{{ num($el->id) }}</td>
                                                    <td>{{ $el->taille }}</td>
                                                    <td>{{ $el->niveau }}</td>
                                                    <td>{{ $el->etat }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap mb-3">
                                    <h2 class="title-1">Localisation poubelles
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive table--no-carde m-b-40">
                                    <div class="card-body">
                                        <div class="shadow mt-3 w-100" style="height: 800px" id="map"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="copyright">
                                    <p>Copyright © <?= date('Y') ?> {{ config('app.name') }}</a>.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @include('inc.js')
    <script src="{{ asset('assets/js/inputmask.js') }}"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <link rel="stylesheet" href="//unpkg.com/leaflet-gesture-handling/dist/leaflet-gesture-handling.min.css"
        type="text/css">
    <script src="//unpkg.com/leaflet-gesture-handling"></script>

    <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css'
        rel='stylesheet' />
    <script>
        $(function() {

            dlat = '{{ @json_decode($client->map)->lat }}';
            dlon = '{{ @json_decode($client->map)->lon }}';
            MLAT = -11.6697222;
            MLON = 27.483333333333334;

            initMap();

            function initMap() {
                if (dlat == '') {
                    lat = MLAT;
                    lon = MLON;
                } else {
                    lat = dlat;
                    lon = dlon;
                }

                macarte = null;
                try {
                    macarte = L.map('map', {
                        fullscreenControl: true,
                        gestureHandling: true
                    }).setView([lat, lon], 11);

                    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
                        attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
                        minZoom: 1,
                        maxZoom: 20
                    }).addTo(macarte);

                    if (dlat != '') {
                        marker = L.marker([lat, lon]);
                        var circ = L.circle([lat, lon], {
                            weight: 1,
                            fillOpacity: 0.1,
                            radius: 300
                        });
                        var info =
                            `<p><i class="fa fa-map-marker text-danger"></i> Adresse du client</p>`;
                        marker.bindPopup(info).on('mouseover', function(e) {
                            this.openPopup();
                        });

                        user_markers = new L.FeatureGroup();
                        user_markers.addLayer(marker);
                        user_markers.addLayer(circ);
                        macarte.addLayer(user_markers);
                        macarte.setView([lat, lon], 15);

                    }

                } catch (error) {
                    // console.error(error);
                }
            }

        })
    </script>

</body>

</html>
