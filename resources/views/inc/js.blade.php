<script src="<?= asset('assets') ?>/vendor/jquery-3.2.1.min.js"></script>
<script src="<?= asset('assets') ?>/vendor/bootstrap-4.1/popper.min.js"></script>
<script src="<?= asset('assets') ?>/vendor/bootstrap-4.1/bootstrap.min.js"></script>
<script src="<?= asset('assets') ?>/vendor/slick/slick.min.js">
</script>
<script src="<?= asset('assets') ?>/vendor/wow/wow.min.js"></script>
<script src="<?= asset('assets') ?>/vendor/animsition/animsition.min.js"></script>
<script src="<?= asset('assets') ?>/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
</script>
<script src="<?= asset('assets') ?>/vendor/counter-up/jquery.waypoints.min.js"></script>
<script src="<?= asset('assets') ?>/vendor/counter-up/jquery.counterup.min.js">
</script>
<script src="<?= asset('assets') ?>/vendor/circle-progress/circle-progress.min.js"></script>
<script src="<?= asset('assets') ?>/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="<?= asset('assets') ?>/vendor/chartjs/Chart.bundle.min.js"></script>
<script src="<?= asset('assets') ?>/vendor/select2/select2.min.js">
</script>
<script src="<?= asset('assets') ?>/js/main.js"></script>
<script>
    $(function() {
        var current_url = location.href;
        var cu = current_url.split("?");
        current_url = cu[0];
        $(`a[href='${current_url}']`).closest("li").addClass("active");
        // $(".table").DataTable({
        //     dom: "lBfrtip",
        //     buttons: ["excel", "pdf", "print"],
        //     pageLength: 50,
        //     lengthMenu: [
        //         [10, 25, 50, 100, -1],
        //         [10, 25, 50, 100, "All"],
        //     ],
        // });

        $(".show_hide_password").on('click', function(event) {
            event.preventDefault();
            var div = $(this);
            event.preventDefault();
            if (div.prev().attr("type") == "text") {
                div.prev().attr('type', 'password');
                div.find('i').removeClass("fa-eye").addClass("fa-eye-slash");
            } else if (div.prev().attr("type") == "password") {
                div.prev().attr('type', 'text');
                div.find('i').removeClass("fa-eye-slash").addClass("fa-eye");
            }
        });

        $('#f-com').submit(function() {
            event.preventDefault();
            var form = $(this);
            var btn = $(':submit', form)
            btn.find('span').removeClass().addClass('fa fa-spinner fa-spin');
            var data = $(form).serialize();
            $(':input', form).attr('disabled', true);
            var rep = $('#rep', form);
            rep.slideUp();

            $.ajax({
                url: '{{ route('app.commentaire') }}',
                type: 'post',
                data: data + '&_token={{ csrf_token() }}',
                success: function(r) {
                    btn.find('span').removeClass();
                    $(':input', form).attr('disabled', false);
                    form[0].reset();
                    rep.removeClass().addClass('alert alert-success').html(
                            "Merci d'avoir laisser votre commentaire.")
                        .slideDown();
                },
                error: function(r) {
                    btn.find('span').removeClass();
                    $(':input', form).attr('disabled', false);
                    alert("Echec reseau, actualisez cette page");
                }
            });
        });
    })


    // _token: '{{ csrf_token() }}'
</script>
