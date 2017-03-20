@push('scripts')
<script type="text/javascript">
    $(function () {
        $(document).on('submit', 'form[rel="delete-button"]', function (event) {
            event.preventDefault();

            var form = $(this), url = form.attr('action');
            var data = form.serializeObject();

            swal({
                title: 'Êtes vous sûr ?',
                text: 'Voulez vous vraiment supprimer ' + (data.title || 'cet élément') + ' ?',
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
                }).done(function () {
                    swal('Supprimé !', (data.title || 'L\'élément') + ' a été supprimé !', 'success');
                    if (data.redirect !== undefined) {
                        window.location = data.redirect;
                    }
                    $('[rel="datatables"]').DataTable().ajax.reload(null, false);
                }).error(function (response) {
                    if (response.status === 400) {
                        var res = response.responseJSON;
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

    $.fn.serializeObject = function () {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };
</script>
@endpush
