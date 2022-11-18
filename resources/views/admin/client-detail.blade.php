<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Client {{ $client->name }} | admin</title>
    @include('inc.css')
</head>

<body class="animsition">
    <div class="page-wrapper">
        @include('admin.sidebar')

        <div class="page-container">
            @include('admin.header')

            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap mb-3">
                                    <h2 class="title-1">Client
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive table--no-carde m-b-40">
                                    <table class="table table-borderless table-striped table-info">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Nom</td>
                                                <td>{{ $client->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td>{{ $client->email }}</td>
                                            </tr>
                                            <tr>
                                                <th>Telephone</th>
                                                <td>{{ $client->telephone }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap mb-3">
                                    <h2 class="title-1">Poubelles du client
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive table--no-carde m-b-40">
                                    <table class="table table-borderless table-striped table-info">
                                        <thead>
                                            @php
                                                $poub = $client
                                                    ->poubelles()
                                                    ->orderBy('niveau', 'desc')
                                                    ->get();
                                                $m = 1;
                                            @endphp
                                            <tr>
                                                <th></th>
                                                <th>N° Poubelle</th>
                                                <th>Taille</th>
                                                <th>Niveau déchets</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($poub as $el)
                                                @php
                                                    if ($el->niveau == 'niveau1') {
                                                        $cl = 'success';
                                                        $n = 10;
                                                    } elseif ($el->niveau == 'niveau2') {
                                                        $cl = 'warning';
                                                        $n = 60;
                                                    } elseif ($el->niveau == 'niveau3') {
                                                        $cl = 'danger';
                                                        $n = 100;
                                                    } else {
                                                        $cl = '';
                                                        $n = 0;
                                                    }
                                                @endphp
                                                <tr>
                                                    <td>{{ $m++ }}</td>
                                                    <td>{{ num($el->id) }}</td>
                                                    <td>{{ $el->taille }}</td>
                                                    <td>
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-{{ $cl }}"
                                                            role="progressbar" style="width: {{ $n }}%"
                                                            aria-valuenow="{{ $n }}" aria-valuemin="0"
                                                            aria-valuemax="100">
                                                            {{ $n }}%
                                                        </div>
                                                    </td>
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
                                    <h2 class="title-1">Localisation client
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive table--no-carde m-b-40">
                                    <div class="card-body">
                                        @if (empty($client->map))
                                            <div class="alert alert-danger">
                                                <h6>Veuillez enregistrer l'emplacement du client</h4>
                                            </div>
                                        @endif
                                        <div class="">
                                            <button class="btn btn-danger m-1 mb-3" id="btn-add-c" type="button">
                                                Ajout automatique
                                            </button>
                                            <button class="btn btn-secondary m-1 mb-3" id="btn-emap">
                                                <i class="fa fa-map-marker"></i>
                                                Ajout manuel
                                            </button>
                                            <button class="btn btn-success m-1 mb-3" id='btn-save' style='display:none'>
                                                <i class="fa fa-save"></i> Enregister l'emplacement
                                            </button>
                                            <div class="d-fleix jjustify-content-end">
                                                <p class="text-danger" i-title></p>

                                            </div>
                                        </div>
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
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="text-white">Nouveau client</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="f-add">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Nom</label>
                            <input name="name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Emai;</label>
                            <input name="email" required type="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">telephone</label>
                            <input name="telephone" required class="form-control telephone" minlength="10">
                        </div>
                        <div class="form-group">
                            <div id="rep"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-outline-info">
                            <span></span>
                            Ajouter
                        </button>
                    </div>
                </form>
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
            btn_loc = $('#btn-add-c')
            btn_loc.click(function() {
                btn = $(this);
                txt = btn.html();
                btn.attr('disabled', true).html(
                    '<i class="spinner-border"></i> Recherche de votre position en cours ...');
                getLocation();
            });

            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition, showError);
                    first_zoom = false;
                } else {
                    alert("Votre navigateur ne supporte pas la géolocation.");
                    btn_loc.attr('disabled', false).html(txt)
                }
            }

            function showPosition(position) {
                btn.attr('disabled', false).html(txt);
                setTimeout(() => {
                    btn_loc.attr('disabled', false).html(txt)
                    var lat = position.coords.latitude;
                    var lon = position.coords.longitude;
                    marker = L.marker([lat, lon]);

                    var info =
                        `<p><i class="fa fa-map-marker text-danger"></i> Votre position</p><p><i>Si la position ne correspond pas à votre emplacement, recliquez sur le button au dessus de la carte pour actualiser votre position.</i></p>`;
                    marker.bindPopup(info, {
                        showOnMouseOver: true
                    });

                    try {
                        if (typeof markers !== 'undefined') {
                            macarte.removeLayer(markers);
                        }
                    } catch (error) {

                    }

                    try {
                        macarte.removeLayer(user_markers);
                    } catch (error) {}

                    var circ = L.circle([lat, lon], {
                        weight: 0.5,
                        fillOpacity: 0.1,
                        radius: 1000
                    });

                    user_markers = new L.FeatureGroup();
                    user_markers.addLayer(marker);
                    user_markers.addLayer(circ);
                    macarte.addLayer(user_markers);
                    if (!first_zoom) {
                        macarte.setView([lat, lon], 15);
                        first_zoom = true;
                    }
                }, 1000);

                $.ajax({
                    url: "{{ route('admin.client.maj', $client->id) }}",
                    type: 'post',
                    data: {
                        map: JSON.stringify({
                            lat: position.coords.latitude,
                            lon: position.coords.longitude
                        }),
                        _token: '{{ csrf_token() }}'
                    },
                }).then(function(res) {});
            }

            function showError(error) {
                btn_loc.attr('disabled', false).html(txt);
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        alert(
                            "Merci d'autoriser le site à acceder à votre position" +
                            (error.message ? error.message : '')
                        );
                        break;
                    case error.POSITION_UNAVAILABLE:
                        alert(
                            "Le service de localisation n'est pas disponible pour le moment!"
                        );
                        break;
                    case error.TIMEOUT:
                        alert(
                            "Le service de localisation a pris du temps pour répondre, veuillez réesayer."
                        );
                        break;
                    case error.UNKNOWN_ERROR:
                        alert(
                            "Une erreur s'est produite" + (error
                                .message ? error.message : '') + '</i>');
                        break;
                }
            }

            dlat = '{{ @json_decode($client->map)->lat }}';
            dlon = '{{ @json_decode($client->map)->lon }}';
            MLAT = -11.6697222;
            MLON = 27.483333333333334;

            $.get("https://ipinfo.io", function(resp) {
                try {
                    data = resp.loc.split(',');
                    MLAT = data[0];
                    MLON = data[1];
                } catch (error) {}
                initMap();
            }, "jsonp").fail(function(res) {
                initMap();
            });

            function initMap() {
                if (dlat == '') {
                    lat = MLAT;
                    lon = MLON;
                } else {
                    lat = dlat;
                    lon = dlon;
                }

                macarte = null;
                first_zoom = false

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

                    } else {
                        marker = L.marker([lat, lon]);
                        var circ = L.circle([lat, lon], {
                            weight: 1,
                            fillOpacity: 0.1,
                            radius: 500
                        });
                        var info =
                            `<p><i class="fa fa-map-marker text-danger"></i> Votre position actuelle.</p>`;
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

            function cleanMap() {
                macarte.removeLayer(markers);
            }

            // ======================
            btnEdit = $('#btn-emap');
            btnSave = $('#btn-save');

            btnEdit.click(function() {
                if (macarte) {
                    macarte.off('click');
                    $('[i-title]').removeClass().addClass('text-danger').html(
                        'Cliquez maintenant sur la carte pour spécifier l\'adresse du client.'
                    );
                    macarte.on('click', function(e) {
                        MLAT = e.latlng.lat;
                        MLON = e.latlng.lng;
                        $.get('https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' +
                            MLAT +
                            '&lon=' + MLON,
                            function(data) {
                                ADRESSE = data.display_name ? data.display_name : '';
                                var popup = L.popup();
                                popup
                                    .setLatLng(e.latlng)
                                    .setContent(
                                        "<b class='text-danger'>Le client se trouve à cette adresse : </b>" +
                                        ADRESSE)
                                    .openOn(macarte);
                                btnEdit.hide();
                                btnSave.show();
                                $('[i-title]').removeClass().addClass('text-success').
                                html(
                                    "Cliquez sur \"Enregistrer l'emplacement\".");
                            }).fail(function(res) {
                            alert("Une erreur s'est produite.");
                        });
                    });
                } else {
                    alert("Oops! Essayez de recharger cette page.");
                }
            });

            btnSave.click(function() {
                $('[i-title]').html('');
                var btn = btnSave;
                btn.attr('disabled', true).find('i').removeClass().addClass(
                    'spinner-border spinner-border-sm');
                $.ajax({
                    url: "{{ route('admin.client.maj', $client->id) }}",
                    type: 'post',
                    data: {
                        map: JSON.stringify({
                            lat: MLAT,
                            lon: MLON
                        }),
                        _token: '{{ csrf_token() }}'
                    },
                }).then(function(res) {
                    btn.attr('disabled', false).find('i').removeClass().addClass(
                        'fa fa-save');
                    addOnMap(MLAT, MLON, '');
                }).fail(function(res) {
                    btn.attr('disabled', false).find('i').removeClass().addClass(
                        'fa fa-save');
                });
            });

            function addOnMap(lat, lon, title) {
                marker = L.marker([lat, lon]);
                marker.on('mouseover', function(e) {
                    this.openPopup();
                });
                if (typeof markers !== 'undefined') {
                    macarte.removeLayer(markers);
                }
                try {
                    macarte.removeLayer(user_markers);
                } catch (error) {}
                markers = new L.FeatureGroup();
                markers.addLayer(marker);

                var circ = L.circle([lat, lon], {
                    weight: 0.5,
                    fillOpacity: 0.1,
                    radius: 1000
                });
                markers.addLayer(circ);

                macarte.addLayer(markers);
                var info =
                    `<h5><i class="fa fa-map-marker text-danger"></i> Adresse du client.</br></h5>`;
                marker.bindPopup(info).openPopup();
                macarte.setView([lat, lon], 15);

            }

        })
    </script>

</body>

</html>
