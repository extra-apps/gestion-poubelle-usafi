<!DOCTYPE html>
<html lang="en">

<head>
    <title>Connexion</title>
    @include('inc.css')

</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content rounded">
                        <div class="login-logo">
                            <a href="#">
                                <img src="<?= asset('assets') ?>/images/logo1.png" width="200px" height="200px" alt="">
                            </a>
                        </div>
                        <div class="login-form">
                            <form id="f-log" method="post">
                                <div class="form-group">
                                    <label>Email ou telephone</label>
                                    <input required class="au-input au-input--full" name="login">
                                </div>
                                <div class="form-group">
                                    <label>Mot de passe</label>
                                    <input required class="au-input au-input--full" type="password" name="password">
                                </div>
                                <div class="form-group">
                                    <div id="rep"></div>
                                </div>
                                <?php if (0) : ?>
                                <div class="form-group">
                                    <div class="alert alert-danger">
                                        <h5><?= $this->session->message ?></h5>
                                    </div>
                                </div>
                                <?php endif ?>
                                <button class="btn btn-block btn-info m-b-20" type="submit"><span></span> connexion</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @include('inc.js')
    <script>
        $(function() {
            $('#f-log').submit(function() {
                event.preventDefault();
                var form = $(this);
                var btn = $(':submit', form)
                btn.find('span').removeClass().addClass('fa fa-spinner fa-spin');
                var data = $(form).serialize();
                $(':input', form).attr('disabled', true);
                var rep = $('#rep', form);
                rep.slideUp();

                $.ajax({
                    url: '{{ route('app.connexion') }}',
                    type: 'post',
                    data: data + '&r={{ request()->get('r') }}&_token=' + '{{ csrf_token() }}',
                    success: function(r) {
                        btn.find('span').removeClass();
                        $(':input', form).attr('disabled', false);
                        if (r.success) {
                            rep.removeClass().addClass('alert alert-success').html("")
                                .slideDown();
                            setTimeout(() => {
                                location.assign(r.url);
                            }, 1000);
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
            })
        })
    </script>
</body>

</html>
