<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Accueil | EP</title>
    @include('inc.css')
</head>

<body class="animsition">
    <div class="page-wrapper">
        @include('equipe-projet.sidebar')

        <div class="page-container">
            @include('equipe-projet.header')

            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1">Tableau de bord</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-25">
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item bg-secondary">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="fa fa-user-md"></i>
                                            </div>
                                            <div class="text">
                                                <h2>12</h2>
                                                <span>Chefs projets</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item bg-secondary">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="fa fa-users"></i>
                                            </div>
                                            <div class="text">
                                                <h2>8</h2>
                                                <span>Equipes</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item bg-secondary">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="fas fa-list"></i>
                                            </div>
                                            <div class="text">
                                                <h2>124</h2>
                                                <span>Projets</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item bg-secondary">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="fa fa-check-square"></i>
                                            </div>
                                            <div class="text">
                                                <h2>64</h2>
                                                <span>Plans d'actions</span>
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
                                    <p>Copyright © <?= date('Y') ?> Entreposage</a>.</p>
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
                                data: [12,20,12,20,12,40,20,50,20,12,2,12]
                            },
                            {
                                label: "Risques",
                                borderColor: "rgba(28, 104, 74, 0.7)",
                                borderWidth: "1",
                                backgroundColor: "rgba(28, 104, 74, 0.5)",
                                pointHighlightStroke: "rgba(28, 104, 74, 0.7)",
                                data: [5,12,0,6,12,2,0,0,0,2,5,5]
                            }
                        ]
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
