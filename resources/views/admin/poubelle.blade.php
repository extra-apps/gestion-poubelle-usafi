<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Poubelle | admin</title>
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
                                    <h2 class="title-1">Poubelles <span class="badge badge-info" nb></span></h2>
                                    <button class="btn btn-info" data-toggle="modal" data-target="#modal">
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
                                                        <div class="fa fa-spinner fa-spin fa-2x"></div>
                                                    </span>
                                                </th>
                                                <th>N° Poubelle</th>
                                                <th>Taille</th>
                                                <th>Etat</th>
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
                <div class="modal-header bg-secondary">
                    <h4 class="text-white">Nouvel enregistrement</h4>
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
                            <label for="">Role</label>
                            <input name="role" required class="form-control">
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

    <div class="modal fade" id="modaldel" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <h4 class="text-white">Suppression</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="f-del">
                    <div class="modal-body">
                        Confirmer la suppression ?
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id">
                        <button type="button" class="btn btn-light" data-dismiss="modal">NON</button>
                        <button type="submit" class="btn btn-secondary">
                            <span></span>
                            OUI
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('inc.js')

    <script>
        $(function() {
            spin = $('span[spin]');

            function getdata() {
                spin.fadeIn();
                $.ajax({
                    url: '{{ route('app.equipeprojet') }}',
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
                                <td>${e.role1}</td>
                                <td>${e.service ?? '-'}</td>
                                <td>${e.observation ?? '-'}</td>
                                <td>
                                    <button class="btn btn-outline-secondary del" value='${e.id}'>Supprimer</button>
                                </td>
                            </tr>
                            `;
                        });
                        table.find('tbody').empty().html(str);
                        $('.del').off('click').click(function() {
                            var mdl = $('#modaldel');
                            $('input[name=id]', mdl).val(this.value);
                            mdl.modal();
                        })

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
                    url: '{{ route('app.equipeprojet') }}',
                    type: 'post',
                    data: data + '&_token={{ csrf_token() }}',
                    success: function(r) {
                        form[0].reset();
                        btn.find('span').removeClass();
                        $(':input', form).attr('disabled', false);
                        if (r.success) {
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
            $('#f-del').submit(function() {
                event.preventDefault();
                var form = $(this);
                var btn = $(':submit', form)
                btn.find('span').removeClass().addClass('fa fa-spinner fa-spin');
                var data = $(form).serialize();
                $(':input', form).attr('disabled', true);

                $.ajax({
                    url: '{{ route('app.equipeprojet') }}',
                    type: 'delete',
                    data: data + '&_token={{ csrf_token() }}',
                    success: function(r) {
                        $('#modaldel').modal('hide');
                        btn.find('span').removeClass();
                        $(':input', form).attr('disabled', false);
                        getdata();

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
