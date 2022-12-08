<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Commentaire | admin</title>
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
                                    <h2 class="title-1">Commentaire</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive table--no-carde m-b-40">
                                    <table class="table table-hover table-bordered table-striped table-info">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Client</th>
                                                <th>Sujet</th>
                                                <th>Commentaite</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        @php
                                            $n = 1;
                                        @endphp
                                        <tbody>
                                            @foreach ($commentaires as $el)
                                                <tr>
                                                    <td>{{ $n++ }}</td>
                                                    <td>
                                                        {{ $el->user->name }}
                                                    </td>
                                                    <td>{{ $el->sujet }}</td>
                                                    <td>{{ $el->commentaire }}</td>
                                                    <td>{{ $el->date->format('Y-m-d H:i:s') }}</td>
                                                </tr>
                                            @endforeach
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


</body>

</html>
