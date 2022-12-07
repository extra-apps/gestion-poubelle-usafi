<!DOCTYPE html>
<html lang="en">

<head>
    <title>Abonnement</title>
    @include('inc.css')

</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content rounded ">
                        <div class="row">
                            <div class="col-12 text-center">
                                <h5>Bienvenu {{ auth()->user()->name }}</h5> <br>
                                <h6 class="text-danger">veuillez effectuer le payement pour activer votre compte!</h6>
                            </div>
                            <div class="col-12">
                                <div class="mt-3 jumbotron p-3 bg-light">
                                    <b>Paiement abonnement</b>
                                    <hr>
                                    <small>Comment payer ? <br></small>
                                    <small class="text-muted">
                                        1. Entrez votre numéro(Airtel, Vodacom, Orange ou Africell) et valider <br>
                                        2. Entrer le code secret MobileMoney au téléphone puis valider, <br>
                                        3. Cliquez ensuite sur le bouton "Vérifier la transaction" pour vérifier votre
                                        transaction.
                                    </small>
                                    <hr>
                                    <form action="#" id="paynow">
                                        <div class="form-group mt-2">
                                            <small class="text-muted">Telephone mobile</small>
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
                                            <small class="text-muted">Montant : {{ "$montant $devise" }}</small>
                                        </div>
                                        <div id="rep-pay" style="display: none"></div>
                                        <div class="form-group mt-2 d-inline-flex">
                                            <div class="mt-2 mr-3">
                                                <input id="ac" type="checkbox" name="accept" class="form-control">
                                            </div>
                                            <label for="ac">J'accepte <a href="#" data-toggle="modal"
                                                    data-target="#modal">les conditions d'utilisation</a> </label>
                                        </div>
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
            </div>
        </div>

    </div>
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="text-white">Contrat d'utilisation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-3">
                    {!! $contrat !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Fermer</button>
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
                        var m = res.message.join('<br>') + " Référence : " +
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
