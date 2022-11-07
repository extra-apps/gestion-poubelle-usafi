<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Projets | CP</title>
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
                                    <h2 class="title-1">Projets <span class="badge badge-secondary badge-pill"
                                            nb>4</span> </h2>
                                    <button class="btn btn-secondary" data-toggle="modal" data-target="#modal">
                                        <i class="zmdi zmdi-plus-circle"></i> Ajouter</button>
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
                                                <th>Projet</th>
                                                <th>Date début</th>
                                                <th>Date fin</th>
                                                <th>Cout</th>
                                                <th>Equipe</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Conception System SYDONIA</td>
                                                <td>01/12/2022</td>
                                                <td>05/01/2023</td>
                                                <td>4500 USD</td>
                                                <td>Dev Team</td>
                                                <td>
                                                    <button class="btn btn-outline-secondary">Détails</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Conception BI</td>
                                                <td>01/12/2022</td>
                                                <td>05/01/2023</td>
                                                <td>600 USD</td>
                                                <td>Dev Team</td>
                                                <td>
                                                    <button class="btn btn-outline-secondary">Détails</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Gestion Securité</td>
                                                <td>01/12/2022</td>
                                                <td>05/01/2023</td>
                                                <td>4500 USD</td>
                                                <td>Dev Team</td>
                                                <td>
                                                    <button class="btn btn-outline-secondary">Détails</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Conception APP MANAGEMENT</td>
                                                <td>01/12/2022</td>
                                                <td>05/01/2023</td>
                                                <td>1500 USD</td>
                                                <td>Dev Team</td>
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
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <h4 class="text-white">Nouveau chef de projet</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="f-add">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Nom chef de projet</label>
                            <input name="nomchefprojet" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Fonction</label>
                            <input name="fonction" required class="form-control telephone">
                        </div>
                        <div class="form-group">
                            <div id="rep"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-secondary">
                            <span></span>
                            Ajouter
                        </button>
                    </div>
                </form>
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
