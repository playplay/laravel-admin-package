@push('scripts')
<script type="text/javascript">
    $(function () {
        $('form[rel="delete-button"]').on('submit', function (submission) {
            submission.preventDefault();
            var form = $(this), url = form.attr('action');
            var data = form.serialize();

            swal({
                title: 'Êtes vous sûr ?',
                text: 'Voulez vous vraiment supprimer ' + (data.name || 'cet élément') + ' ?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Oui, je le veux !',
                closeOnConfirm: false
            }, function () {
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': data._token
                    }
                }).done(function (data) {
                    swal('Supprimé !', (data.name || 'L\'élément') + ' a été supprimé !', 'success');
                    if (data.redirect !== undefined) {
                        window.location = data.redirect;
                    }
                    $('[rel="datatables"]').DataTable().ajax.reload(null, false);
                }).error(function (data) {
                    if (data.status === 400) {
                        var res = data.responseJSON;
                        swal({
                            title: res.title,
                            text: res.message,
                            type: res.type,
                            confirmButtonText: 'OK'
                        });
                    }
                    else {
                        swal('Oups !', 'Un problème est survenu, merci de contacter un admin.', 'error');
                    }
                });
            });
        });
    });
</script>
@endpush
