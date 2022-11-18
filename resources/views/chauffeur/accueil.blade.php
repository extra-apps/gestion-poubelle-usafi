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
                                    <table t-data class="table table-borderless table-striped table-info">
                                        <thead>
                                            @php
                                                $n = 1;
                                            @endphp
                                            <tr>
                                                <th>
                                                    <span spin>
                                                        <div class="fa fa-cog fa-spin text-info"></div>
                                                    </span>
                                                </th>
                                                <th>N° Poubelle</th>
                                                <th>Client</th>
                                                <th>Taille</th>
                                                <th>Niveau déchets</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
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

            MLAT = -11.6697222;
            MLON = 27.483333333333334;

            POUBELLE = {!! json_encode($map) !!};
            initMap();

            function initMap() {

                macarte = null;
                try {
                    macarte = L.map('map', {
                        fullscreenControl: true,
                        gestureHandling: true
                    }).setView([MLAT, MLON], 12);

                    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
                        attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
                        minZoom: 1,
                        maxZoom: 20
                    }).addTo(macarte);

                    user_markers = new L.FeatureGroup();
                    var markerL = [];

                    // var popupLocation1 = new L.LatLng(51.5, -0.09);
                    // var popupLocation2 = new L.LatLng(51.51, -0.08);

                    // var popupContent1 = '<p>Hello world!<br />This is a nice popup.</p>',
                    //     popup1 = new L.Popup();

                    // popup1.setLatLng(popupLocation1);
                    // popup1.setContent(popupContent1);

                    // var popupContent2 = '<p>Hello world!<br />This is a nice popup.</p>',
                    //     popup2 = new L.Popup();

                    // popup2.setLatLng(popupLocation2);
                    // popup2.setContent(popupContent2);
                    // macarte.addLayer(popup1).addLayer(popup2);
                    $(POUBELLE).each(function(i, e) {
                        var map = JSON.parse(e.map);
                        var lat = map.lat;
                        var lon = map.lon;
                        var marker = L.marker([lat, lon]);
                        var info =
                            `<p><i class="fa fa-user text-danger"></i> Client : ${e.user}</p>${e.poubelle}`;
                        marker.bindPopup(info).on('mouseover', function(e) {
                            this.openPopup();
                        });
                        user_markers.addLayer(marker);
                        markerL.push(marker);
                    })
                    macarte.addLayer(user_markers);
                    $(markerL).each(function(i, e) {
                        e.openPopup();
                    })
                } catch (error) {
                    console.error(error);
                }
            }

            spin = $('span[spin]');

            function getdata(show = true) {
                if (show) {
                    spin.fadeIn();
                }
                $.ajax({
                    url: '{{ route('app.poubelle') }}',
                    data: 'u={{ auth()->user()->id }}&_token={{ csrf_token() }}',
                    success: function(r) {
                        $('span[nb]').html(r.length);
                        spin.fadeOut();
                        var table = $('table[t-data]');
                        var str = '';
                        $(r).each(function(i, e) {
                            if (e.niveau == 10) {
                                cl = 'success';
                            } else if (e.niveau == 60) {
                                cl = 'warning';
                            } else if (e.niveau == 100) {
                                cl = 'danger';
                            } else {
                                cl = '';
                            }
                            str += `
                            <tr>
                                <td>${i+1}</td>
                                <td>${e.numero}</td>
                                <td>${e.client}</td>
                                <td>${e.taille}</td>
                                <td class='text-center'>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-${cl}" role="progressbar" style="width: ${e.niveau}%" aria-valuenow="${e.niveau}" aria-valuemin="0" aria-valuemax="100">
                                            ${e.niveau}%
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <button value='${e.id}' class="btn btn-outline-info valide">
                                        <i class='fa fa-check-circle' ></i>
                                    </button>
                                </td>
                            </tr>
                            `;
                        });
                        table.find('tbody').empty().html(str);

                    },
                    error: function(r) {
                        spin.fadeOut();
                        btn.find('span').removeClass();
                        $(':input', form).attr('disabled', false);
                        alert("Echec reseau, actualisez cette page");
                    }
                });
            }

            setInterval(() => {
                getdata(false);
            }, 3000);

        })
    </script>

</body>

</html>
