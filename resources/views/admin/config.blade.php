<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Configuration | admin</title>
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
                                    <h2 class="title-1">Configuration montant paiement</h2>
                                    <button class="btn btn-outline-info" data-toggle="modal" data-target="#modal">
                                        <i class="zmdi zmdi-edit"></i> Modifier</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive table--no-carde m-b-40">
                                    <table t-data class="table table-hover table-borderless table-striped table-info">
                                        <thead>
                                            <tr>
                                                <td class="2">Ouverture compte</td>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <td>Montant</td>
                                            <td>{{ "$compte $devise" }}</td>
                                        </tr>
                                        <thead>
                                            <tr>
                                                <td class="2">Evacuation poubelle</td>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <td>Niveau 1</td>
                                            <td>{{ "$niveau1 $devise" }}</td>
                                        </tr>
                                        <tr>
                                            <td>Niveau 2</td>
                                            <td>{{ "$niveau2 $devise" }}</td>
                                        </tr>
                                        <tr>
                                            <td>Niveau 3</td>
                                            <td>{{ "$niveau3 $devise" }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap mb-3">
                                    <h2 class="title-1">Impression QRCode</h2>
                                    <button class="btn btn-outline-info btnprint">
                                        <i class="zmdi zmdi-print"></i> Imprimer</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive table--no-carde m-b-40">
                                    <table t-data class="table table-hover table-borderless table-striped table-info">
                                        <thead>
                                            <tr>
                                                <td></td>
                                                <th>N° Poubelle</th>
                                                <th>QRCode</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $n = 1;
                                            @endphp
                                            @foreach ($poubelles as $el)
                                                <tr>
                                                    <td>{{ $n++ }}</td>
                                                    <td>{{ num($el->id) }}</td>
                                                    <td class="text-center">
                                                        <div num="{{ num($el->id) }}"></div>
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
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="text-white">Montant paiement</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="f-add">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Montant ouverture compte (CDF)</label>
                            <input name="compte" required value="{{ $compte }}" type="number" min="1"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Montant poubelle niveau 1 (CDF)</label>
                            <input name="niveau1" required value="{{ $niveau1 }}" type="number" min="1"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Montant poubelle niveau 2 (CDF)</label>
                            <input name="niveau2" required value="{{ $niveau2 }}" type="number" min="1"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Montant poubelle niveau 3 (CDF)</label>
                            <input name="niveau3" required value="{{ $niveau3 }}" type="number" min="1"
                                class="form-control">
                        </div>

                        <div class="form-group">
                            <div id="rep"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-outline-info">
                            <span></span>
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div style="display: none">
        <div id="print-zone" sytyle="
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            -ms-overflow-style: -ms-autohiding-scrollbar;
        ">
            @foreach ($poubelles as $el)
                <div >
                    <div style="height: 297mm; width: 210mm;">
                        <div style="width: 100%;">
                            <div>
                                <div style="width: 100%; margin-top: 20%; margin-left: 40% " qr="{{ num($el->id) }}">
                                </div>
                                <h5 style="margin: 50px 0px 50px; font-weight: bold; margin-left: 70% ">
                                    {{ num($el->id) }}</h5>
                            </div>
                        </div>
                    </div>
                    <div style="page-break-after:always; display:block; position:relativ6e;"></div>
                </div>
            @endforeach
        </div>
    </div>

    @include('inc.js')
    <script src="{{ asset('assets/js/printThis.js') }}"></script>
    <script src="{{ asset('assets/js/qrcode.min.js') }}"></script>
    <style>
        @page {
            size: A4 !important;
            margin: 0 !important;
        }

        @media print {

            html,
            body {
                width: 210mm !important;
                height: 297mm !important;
            }
        }

    </style>
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
                    url: '{{ route('app.config') }}',
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
                            getdata();
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

            $('.btnprint').click(function() {
                $("#print-zone").printThis({
                    importStyle: true,
                });
            })

            $('div[num]').each(function(i, e) {
                var qrcode = new QRCode(e, {
                    width: 100,
                    height: 100
                });
                var qr = $(e).attr('num');
                qrcode.makeCode(qr);
            });

            $('div[qr]').each(function(i, e) {
                var qrcode = new QRCode(e, {
                    width: 500,
                    height: 500
                });
                var qr = $(e).attr('qr');
                qrcode.makeCode(qr);
            })
        })
    </script>

</body>

</html>
