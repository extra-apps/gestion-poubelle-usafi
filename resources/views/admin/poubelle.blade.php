<!DOCTYPE html>
<html lang="fr">

<head>
    <title>poubelle | admin</title>
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
                                    <h2 class="title-1">poubelles <span class="badge badge-info" nb></span></h2>
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
                                                        <div class="fa fa-spinner fa-spin fa-2x"></div>
                                                    </span>
                                                </th>
                                                <th>N° Poubelle</th>
                                                <th>Client</th>
                                                <th>Taille</th>
                                                <th>Niveau</th>
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
                <div class="modal-header bg-info">
                    <h4 class="text-white">Nouvelle poubelle</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="f-add">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Taille</label>
                            <input name="taille" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Client</label>
                            <select name="users_id" required class="form-control">
                                @foreach ($clients as $el)
                                    <option value="{{ $el->id }}">{{ $el->name }}</option>
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
                            Ajouter
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
                    url: '{{ route('app.poubelle') }}',
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
                                <td>${e.numero}</td>
                                <td>${e.client}</td>
                                <td>${e.taille}</td>
                                <td class='text-center'>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: ${e.niveau}" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                            ${e.niveau}
                                        </div>
                                    </div>
                                </td>
                                <td class='text-center'>${e.etat}</td>
                                <td>
                                    <button class="btn btn-outline-info" value='${e.id}'>
                                        <i class='fa fa-eye' ></i>
                                    </button>
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
                    url: '{{ route('app.poubelle') }}',
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
