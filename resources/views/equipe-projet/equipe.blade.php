<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Equipes | CP</title>
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
                                <div class="overview-wrap mb-3">
                                    <h2 class="title-1">Equipes <span class="badge badge-secondary badge-pill"
                                            nb>4</span></h2>
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
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <h4 class="text-white">Nouvelle équipe</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="f-add">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Nom de l'equipe</label>
                            <input name="nom" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Role</label>
                            <input name="role" required class="form-control telephone">
                        </div>
                        <div class="form-group">
                            <label for="">service</label>
                            <input name="service" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Observation</label>
                            <textarea name="observation" class="form-control"></textarea>
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
