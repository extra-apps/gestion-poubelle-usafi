<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Client {{ auth()->user()->name }}</title>
    @include('inc.css')
</head>

<body class="animsition">
    <div class="page-wrapper">
        @include('client.sidebar')

        <div class="page-container">
            @include('admin.header')

            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap mb-3">
                                    <h2 class="title-1">Poubelles
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive table--no-carde m-b-40">
                                    <table class="table table-borderless table-striped table-info">
                                        <thead>
                                            @php
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
                                            @foreach ($poubelles as $el)
                                                @php
                                                    if ($el->niveau == 'niveau1') {
                                                        $cl = 'success';
                                                        $n = 50;
                                                    } elseif ($el->niveau == 'niveau2') {
                                                        $cl = 'warning';
                                                        $n = 75;
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
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-{{ $cl }}"
                                                                role="progressbar" style="width: {{ $n }}%"
                                                                aria-valuenow="{{ $n }}" aria-valuemin="0"
                                                                aria-valuemax="100">
                                                                {{ $n }}%
                                                            </div>
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
                                    <h2 class="title-1">Paiements
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
                                                <th>N° Poubelle</th>
                                                <th>Niveau déchets</th>
                                                <th>Montant</th>
                                                <th>Date</th>
                                                <th>Etat paiement</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $m=1;
                                            @endphp
                                            @foreach ($paiements as $el)
                                                @php
                                                    if ($el->niveau == 'niveau1') {
                                                        $cl = 'success';
                                                        $n = 50;
                                                    } elseif ($el->niveau == 'niveau2') {
                                                        $cl = 'warning';
                                                        $n = 75;
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
                                                    <td>{{ num($el->poubelle->id) }}</td>
                                                    <td>
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-{{ $cl }}"
                                                                role="progressbar" style="width: {{ $n }}%"
                                                                aria-valuenow="{{ $n }}" aria-valuemin="0"
                                                                aria-valuemax="100">
                                                                {{ $n }}%
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ "$el->montant $el->devise" }}</td>
                                                    <td>{{ $el->date->format('d-m-Y H:i:s') }}</td>
                                                    <td class="text-center">
                                                        @if ($el->paie == 1)
                                                            <span class="badge badge-success"><i class="fa fa-check-circle"></i> PAYE</span>
                                                        @else
                                                            <span class="badge badge-danger"><i class="fa fa-times-circle"></i> NON PAYE</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($el->paie == 0)
                                                            <a href="{{ route('client.paiement-poubelle', ['item' => $el->id]) }}"
                                                                class="btn btn-outline-info">
                                                                <i class="fa fa-dollar"></i> Payer l'évacuation
                                                            </a>
                                                        @endif
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
