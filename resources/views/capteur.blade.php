<!DOCTYPE html>
<html lang="en">

<head>
    <title>Capteur</title>
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
                                <h6 class="text-danger">Simulateur</h6>
                            </div>
                            <div class="col-12">
                                <div class="mt-3 jumbotron p-3">
                                    <form action="#" id="paynow">
                                        <div class="form-group mt-2">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend bg-gray p-1">
                                                    <span class="input-group-text" id="basic-addon1">N° Poubelle</span>
                                                </div>
                                                <input class="form-control" name="poubelle" value="P-240" required>
                                            </div>
                                        </div>
                                        <div class="form-group mt-2">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend bg-gray p-1">
                                                    <span class="input-group-text" id="basic-addon1">cap3</span>
                                                </div>
                                                <input type="number" min="0" max="1" class="form-control" name="cap3"
                                                    value="0" required>
                                            </div>
                                        </div>
                                        <div class="form-group mt-2">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend bg-gray p-1">
                                                    <span class="input-group-text" id="basic-addon1">cap2</span>
                                                </div>
                                                <input type="number" min="0" max="1" class="form-control" name="cap2"
                                                    value="0" required>
                                            </div>
                                        </div>
                                        <div class="form-group mt-2">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend bg-gray p-1">
                                                    <span class="input-group-text" id="basic-addon1">cap1</span>
                                                </div>
                                                <input type="number" min="0" max="1" class="form-control" name="cap1"
                                                    value="0" required>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <b class="mr-2"><i req class=""></i></b>
                                            <b id="rep-pay" class="text-danger"></b>
                                        </div>

                                        {{-- <div class="d-flex justify-content-center">
                                            <button class="btn btn-success mr-3" type="submit">
                                                <span class="fa fa-money-bill mr-3"></span>
                                                Envoyer
                                            </button>
                                            <button class="btn btn-danger mr-3" id="btn-check" type="button">
                                                <span class="fa fa-money-bill mr-3"></span>
                                                Arreter
                                            </button>
                                        </div> --}}
                                    </form>
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
            function send() {
                var f = $('#paynow');
                var data = f.serialize();
                data = data;
                rep = $('#rep-pay');
                var i = $('i[req]');
                i.removeClass().addClass('fa fa-spinner fa-spin');
                $.ajax({
                    url: "{{ route('capteur') }}",
                    data: data,
                    timeout: 20000,
                }).done(function(res) {
                    i.removeClass().addClass('fa fa-check-circle');
                    rep.html(res);
                })
            }

            setInterval(() => {
                send();
            }, 3000);


        })
    </script>
</body>

</html>
