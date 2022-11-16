<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Client | admin</title>
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
                                    <h2 class="title-1">Clients <span class="badge badge-info" nb></span></h2>
                                    <button class="btn btn-outline-info" data-toggle="modal" data-target="#modal">
                                        <i class="zmdi zmdi-plus-circle"></i> Ajouter</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive table--no-carde m-b-40">
                                    <table t-data class="table table-borderless table-striped table-info">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <span spin>
                                                        <div class="fa fa-cog fa-spin text-info"></div>
                                                    </span>
                                                </th>
                                                <th>Nom</th>
                                                <th>Email</th>
                                                <th>Telephone</th>
                                                <th>Nbre. poubelles</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
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
                    <h4 class="text-white">Nouveau client</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="f-add">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Nom</label>
                            <input name="name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Emai;</label>
                            <input name="email" required type="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">telephone</label>
                            <input name="telephone" required class="form-control telephone" minlength="10">
                        </div>
                        <div class="form-group">
                            <div id="rep"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-outline-info">
                            <span></span>
                            Ajouter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('inc.js')
    <script src="{{ asset('assets/js/inputmask.js') }}"></script>
    <script>
        $(function() {
            $(".telephone").inputmask("(999)999999999");
            spin = $('span[spin]');

            function getdata() {
                spin.fadeIn();
                $.ajax({
                    url: '{{ route('app.client') }}',
                    data: '_token={{ csrf_token() }}',
                    success: function(r) {
                        $('span[nb]').html(r.length);
                        spin.fadeOut();
                        var table = $('table[t-data]');
                        var str = '';
                        $(r).each(function(i, e) {
                            str += `
                            <tr>
                                <td>${i+1}</td>
                                <td>${e.name}</td>
                                <td>${e.email}</td>
                                <td>${e.telephone}</td>
                                <td class='text-center'>${e.nbpoubelle}</td>
                                <td>
                                    <a class="btn btn-outline-info" href='{{ route('admin.client', ['item' => '']) }}${e.id}'>
                                        <i class='fa fa-eye' ></i>
                                    </a>
                                </td>
                            </tr>
                            `;
                        });
                        table.find('tbody').empty().html(str);

                    },
                    error: function(r) {
                        spin.fadeOut();
                        btn.find('span').removeClass();
                        $(':input', form).attr('disabled', false);
                        alert("Echec reseau, actualisez cette page");
                    }
                });
            }

            getdata();

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
                    url: '{{ route('app.client') }}',
                    type: 'post',
                    data: data + '&_token={{ csrf_token() }}',
                    success: function(r) {
                        btn.find('span').removeClass();
                        $(':input', form).attr('disabled', false);
                        if (r.success) {
                            form[0].reset();
                            rep.removeClass().addClass('alert alert-success').html(r.message)
                                .slideDown();
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

        })
    </script>

</body>

</html>
