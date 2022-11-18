<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Poubelle {{ num($poubelle->id) }} | admin</title>
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
                                    <h2 class="title-1">Poubelle <span class="badge badge-info"
                                            nb>{{ num($poubelle->id) }}</span> | Chaffeur : {{ $chauffeur }}</h2>
                                    <button class="btn btn-outline-info" data-toggle="modal" data-target="#modal">
                                        <i class="zmdi zmdi-car-taxi"></i> Chauffeur</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive table--no-carde m-b-40">
                                    <table t-data class="table table-hover table-borderless table-striped table-info">
                                        <thead>
                                            <tr>
                                                <th>N° Poubelle</th>
                                                <th>Client</th>
                                                <th>Taille</th>
                                                <th>Niveau déchets</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                if ($poubelle->niveau == 'niveau1') {
                                                    $cl = 'success';
                                                    $n = 10;
                                                } elseif ($poubelle->niveau == 'niveau2') {
                                                    $cl = 'warning';
                                                    $n = 60;
                                                } elseif ($poubelle->niveau == 'niveau3') {
                                                    $cl = 'danger';
                                                    $n = 100;
                                                } else {
                                                    $cl = '';
                                                    $n = 0;
                                                }
                                            @endphp
                                            <tr>
                                                <td>{{ num($poubelle->id) }}</td>
                                                <td>{{ $poubelle->user->name }}</td>
                                                <td>{{ $poubelle->taille }}</td>
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
                                    <table t-data class="table table-hover table-borderless table-striped table-info">
                                        <thead>
                                            @php
                                                $n = 1;
                                                $paie = $poubelle
                                                    ->paiements()
                                                    ->orderBy('id', 'desc')
                                                    ->get();
                                            @endphp
                                            <tr>
                                                <th></th>
                                                <th>Montant</th>
                                                <th>Client</th>
                                                <th>Niveau déchets</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($paie as $el)
                                                <tr>
                                                    <td>{{ $n++ }}</td>
                                                    <td>{{ $el->poubelle->user->name }}</td>
                                                    <td>
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger"
                                                            role="progressbar" style="width: 30" aria-valuenow="10"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            30
                                                        </div>
                                                    </td>
                                                    <td>{{ "$el->montant $el->devise" }}</td>
                                                    <td>{{ $el->date->format('d-m-Y H:i:s') }}</td>
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
                                    <h2 class="title-1">Evacuations
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive table--no-carde m-b-40">
                                    <table t-data class="table table-hover table-borderless table-striped table-info">
                                        <thead>
                                            @php
                                                $n = 1;
                                                $eva = $poubelle
                                                    ->evacuations()
                                                    ->orderBy('id', 'desc')
                                                    ->get();
                                            @endphp
                                            <tr>
                                                <th></th>
                                                <th>Chauffeur</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($eva as $el)
                                                <tr>
                                                    <td>{{ $n++ }}</td>
                                                    <td>{{ $el->user->name }}</td>
                                                    <td>{{ $el->date->format('d-m-Y H:i:s') }}</td>
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
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="text-white">Chauffeur evacuateur</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="f-add">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Chauffeur</label>
                            <input type="hidden" name="poubelle_id" value="{{ $poubelle->id }}">
                            <select name="users_id" required class="form-control">
                                @foreach ($chauffeurs as $el)
                                    <option @if ($el->id == $idchauf) 'selected' @endif
                                        value="{{ $el->id }}">{{ $el->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div id="rep"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-outline-info">
                            <span></span>
                            Modifier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('inc.js')
    <script>
        $(function() {


            $('#f-add').submit(function() {
                event.preventDefault();
                var form = $(this);
                var btn = $(':submit', form)
                btn.find('span').removeClass().addClass('fa fa-spinner fa-spin');
                var data = $(form).serialize();
                $(':input', form).attr('disabled', true);
                var rep = $('#rep', form);
                rep.slideUp();

                $.ajax({
                    url: '{{ route('app.evacuateur') }}',
                    type: 'post',
                    data: data + '&_token={{ csrf_token() }}',
                    success: function(r) {
                        btn.find('span').removeClass();
                        $(':input', form).attr('disabled', false);
                        if (r.success) {
                            rep.removeClass().addClass('alert alert-success').html(r.message)
                                .slideDown();
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        } else {
                            rep.removeClass().addClass('alert alert-danger').html(r.message)
                                .slideDown();
                        }
                    },
                    error: function(r) {
                        btn.find('span').removeClass();
                        $(':input', form).attr('disabled', false);
                        alert("Echec reseau, actualisez cette page");
                    }
                });
            });

        })
    </script>

</body>

</html>
