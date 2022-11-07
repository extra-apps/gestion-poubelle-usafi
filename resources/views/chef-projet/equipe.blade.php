<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Equipes | CP</title>
    @include('inc.css')
</head>

<body class="animsition">
    <div class="page-wrapper">
        @include('chef-projet.sidebar')

        <div class="page-container">
            @include('chef-projet.header')

            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap mb-3">
                                    <h2 class="title-1">Equipe projet <span
                                            class="badge badge-secondary badge-pill" nb>4</span></h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive table--no-carde m-b-40">
                                    <table t-data class="table table-borderless table-striped table-secondary">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nom</th>
                                                <th>Role</th>
                                                <th>Service</th>
                                                <th>Observation</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>DevTeam</td>
                                                <td>Developpement</td>
                                                <td>Maintainance</td>
                                                <td>OK</td>
                                                <td>
                                                    <button class="btn btn-outline-secondary">Détails</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Marketing</td>
                                                <td>Publicité</td>
                                                <td>Maintainance</td>
                                                <td>OK</td>
                                                <td>
                                                    <button class="btn btn-outline-secondary">Détails</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Security Team</td>
                                                <td>Developpement</td>
                                                <td>Maintainance</td>
                                                <td>OK</td>
                                                <td>
                                                    <button class="btn btn-outline-secondary">Détails</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Community Team</td>
                                                <td>Securité</td>
                                                <td>Maintainance</td>
                                                <td>OK</td>
                                                <td>
                                                    <button class="btn btn-outline-secondary">Détails</button>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
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

    <script>
        $(function() {

        })
    </script>

</body>

</html>
