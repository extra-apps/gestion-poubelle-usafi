<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Accueil | admin</title>
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
                                <div class="overview-wrap">
                                    <h2 class="title-1">{{ ucfirst(config('app.name')) }} panel</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-25">
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item bg-info">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="fa fa-users" style="font-size: 40px"></i>
                                            </div>
                                            <div class="text">
                                                <h2>{{ '248' }}</h2>
                                                <span class="font-weight-bold" >Clients</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item bg-info">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="fa fa-car" style="font-size: 40px"></i>
                                            </div>
                                            <div class="text">
                                                <h2>{{ '4' }}</h2>
                                                <span class="font-weight-bold" >Chauffeurs</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item bg-info">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="fa fa-trash-alt" style="font-size: 40px"></i>
                                            </div>
                                            <div class="text">
                                                <h2>{{ '300' }}</h2>
                                                <span class="font-weight-bold" >Poubelles</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item bg-info">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="fas fa-trash" style="font-size: 40px"></i>
                                            </div>
                                            <div class="text">
                                                <h2>{{ '4' }}</h2>
                                                <span class="font-weight-bold" >Poubelles pleines</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="au-card recent-report">
                                    <div class="au-card-inner">
                                        <h3 class="title-2">Statistiques</h3>
                                        <div class="recent-report__chart">
                                            <canvas id="graph"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="copyright">
                                    <p>Copyright © <?= date('Y') ?> {{ config('app.name') }}</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @include('inc.js')

    <script>
        $(function() {
            var ctx = document.getElementById("graph");
            if (ctx) {
                ctx.height = 300;
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ["Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout",
                            "Septembrer", "Octobre", "Novembre", "Decembre"
                        ],
                        defaultFontFamily: "Poppins",
                        datasets: [{
                            label: "Projets",
                            borderColor: "rgba(0,0,0,.09)",
                            borderWidth: "1",
                            backgroundColor: "rgba(0,0,0,.08)",
                            data: {{ json_encode($tabpr0 = []) }}
                        }, ]
                    },
                    options: {
                        legend: {
                            position: 'top',
                            labels: {
                                fontFamily: 'Poppins'
                            }

                        },
                        responsive: true,
                        tooltips: {
                            mode: 'index',
                            intersect: false
                        },
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        },
                        scales: {
                            xAxes: [{
                                ticks: {
                                    fontFamily: "Poppins"

                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    fontFamily: "Poppins"
                                }
                            }]
                        }

                    }
                });
            }
        })
    </script>

</body>

</html>
