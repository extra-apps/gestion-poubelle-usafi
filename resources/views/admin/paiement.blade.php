<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Paiements | admin</title>
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
                                    <h2 class="title-1">Paiements
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive table--no-carde m-b-40">
                                    <table t-data class="table table-hover table-borderless table-striped table-info">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>N° Poubelle</th>
                                                <th>Client</th>
                                                <th>Niveau déchets</th>
                                                <th>Montant</th>
                                                <th>Etat paiement</th>
                                                <th>Date</th>
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

    @include('inc.js')
    <script>
        $(function() {
            spin = $('span[spin]');

            function getdata() {
                spin.fadeIn();
                $.ajax({
                    url: '{{ route('app.paiement') }}',
                    data: '_token={{ csrf_token() }}',
                    success: function(r) {
                        $('span[nb]').html(r.length);
                        spin.fadeOut();
                        var table = $('table[t-data]');
                        var str = '';
                        $(r).each(function(i, e) {
                            if (e.niveau == 50) {
                                cl = 'success';
                            } else if (e.niveau == 75) {
                                cl = 'warning';
                            } else if (e.niveau == 100) {
                                cl = 'danger';
                            } else {
                                cl = '';
                            }

                            if(e.paie == 1){
                                etat=`<span class="badge badge-success"><i class="fa fa-check-circle"></i> PAYE</span>`;
                            }else{
                                etat=`<span class="badge badge-danger"><i class="fa fa-times-circle"></i> NON PAYE</span>`;
                            }

                            str += `
                            <tr>
                                <td>${i+1}</td>
                                <td>${e.numero}</td>
                                <td>${e.client}</td>
                                <td class='text-center'>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-${cl}" role="progressbar" style="width: ${e.niveau}%" aria-valuenow="${e.niveau}" aria-valuemin="0" aria-valuemax="100">
                                            ${e.niveau}%
                                        </div>
                                    </div>
                                </td>
                                <td class='text-center'>${e.montant}</td>
                                <td class='text-center'>${etat}</td>
                                <td class='text-center'>${e.date}</td>
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

            setInterval(() => {
                getdata();
            }, 3000);

        })
    </script>

</body>

</html>
