<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Paiement poubelle {{ num($poubelle->id) }}</title>
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
                                    <h2 class="title-1">Paiement poubelle {{ num($poubelle->id) }}
                                </div>
                            </div>
                        </div>
                        <div class="login-wrap pt-0">
                            <div class="login-content rounded ">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <h6 class="text-danger">veuillez effectuer le payement pour permetre
                                            l'évacuation de votre poubelle!</h6>
                                    </div>
                                    <div class="col-12">
                                        <div class="mt-3 jumbotron p-3 bg-light">
                                            <b>Paiement de la poubelle {{ num($poubelle->id) }}</b>
                                            <hr>
                                            <b>Niveau actuel de la poubelle : <i>{{ $niveau }}</i></b> <br>
                                            <b>Montant à payer : <i>{{ "$montant $devise" }}</i></b> <br>
                                            <hr>
                                            <small>Comment payer ? <br></small>
                                            <small class="text-muted">
                                                1. Entrez votre numéro(Airtel, Vodacom, Orange ou Africell) et valider
                                                <br>
                                                2. Entrer le code secret MobileMoney au téléphone puis valider, <br>
                                                3. Cliquez ensuite sur le bouton "Vérifier la transaction" pour vérifier
                                                votre
                                                transaction.
                                            </small>
                                            <hr>
                                            <form action="#" id="paynow">
                                                <div class="form-group mt-2">
                                                    <small class="text-muted">Telephone mobile</small>
                                                    <input type="hidden" name="type" value="poubelle">
                                                    <input type="hidden" name="poubelle_id"
                                                        value="{{ $poubelle->id }}">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend bg-gray p-1">
                                                            <span class="input-group-text" id="basic-addon1">+243</span>
                                                        </div>
                                                        @php
                                                            $tel = (int) auth()->user()->telephone;
                                                            $tel = substr($tel, 3);
                                                        @endphp
                                                        <input id="paynumber" type="text" class="form-control"
                                                            placeholder="Telephone mobile money" name="telephone"
                                                            value="{{ $tel }}" required>
                                                    </div>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <small class="text-muted">Montant :
                                                        {{ "$montant $devise" }}</small>
                                                </div>
                                                <div id="rep-pay" style="display: none"></div>

                                                <div class="d-flex justify-content-center">
                                                    <button class="btn btn-success mr-3" type="submit">
                                                        <span class="fa fa-money-bill mr-3"></span>
                                                        Payer
                                                    </button>
                                                    <button class="btn btn-danger mr-3" id="btn-check" type="button"
                                                        style="display: none">
                                                        <span class="fa fa-money-bill mr-3"></span>
                                                        Vérifier la transaction
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
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

    <script src="{{ asset('assets/js/jquery.mask.min.js') }}"></script>

    <script>
        $(function() {
            $("#paynumber").mask('000000000');
            btnCheck = $('#btn-check');
            ref = '';

            $('#paynow').submit(function() {
                event.preventDefault();
                var f = $(this);
                var btn = $(':submit', f).attr('disabled', true);
                var cl = btn.find('span').attr('class');
                btn.find('span').removeClass().addClass('fa fa-circle-notch fa-spin mr-1');

                var data = f.serialize();
                data = data + "&_token={{ @csrf_token() }}";

                rep = $('#rep-pay');
                if (rep.is(':visible')) {
                    rep.slideUp();
                }

                $.ajax({
                    url: "{{ route('payment.init') }}",
                    type: 'post',
                    data: data,
                    timeout: 20000,
                }).done(function(res) {
                    btn.find('span').removeClass().addClass(cl);
                    if (res.success) {
                        ref = res.ref;
                        var m = res.message + " Référence : " +
                            ref;
                        rep.removeClass().addClass('alert alert-success').html(m)
                            .slideDown();
                        btn.hide();
                        btnCheck.show();
                    } else {
                        btn.attr('disabled', false);
                        var m = res.message
                        rep.removeClass().addClass('alert alert-danger').html(m)
                            .slideDown();
                    }

                })
            })

            btnCheck.click(function() {
                event.preventDefault();
                var btn = $(this);
                btn.attr('disabled', true);
                var cl = btn.find('span').attr('class');
                btn.find('span').removeClass().addClass('fa fa-circle-notch fa-spin mr-1');
                rep = $('#rep-pay');
                if (rep.is(':visible')) {
                    rep.slideUp();
                }
                $.ajax({
                    url: '{{ route('payment.check') }}/' + ref,
                    type: 'post',
                    data: {
                        _token: '{{ @csrf_token() }}'
                    },
                    timeout: 20000,
                }).done(function(res) {
                    btn.find('span').removeClass().addClass(cl);
                    if (res.success) {
                        var m = res.message.join('<br>')
                        rep.removeClass().addClass('alert alert-success').html(m)
                            .slideDown();
                        btn.hide();
                        btnCheck.hide();
                        setTimeout(() => {
                            location.reload();
                        }, 3000);
                    } else {
                        btn.attr('disabled', false);
                        var m = res.message;
                        rep.removeClass().addClass('alert alert-danger').html(m)
                            .slideDown();
                    }
                })
            })
        })
    </script>

</body>

</html>
