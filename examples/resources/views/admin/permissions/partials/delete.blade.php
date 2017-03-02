<div class="col-md-8">
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Supprimer des permissions</h3>
        </div>
        <div class="box-body">
            {!! AdminForm::open(['route' => 'admin.permissions.delete', 'method' => 'delete', 'id' => 'form-delete-perms' ]) !!}
            {!! AdminForm::tags('permissions[]', false, $allPermissions) !!}
            {!! AdminForm::submit('Supprimer', ['class' => 'btn btn-danger']) !!}
            {!! AdminForm::close() !!}
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(function () {
            $(document).on('submit', '#form-delete-perms', function (event) {
                event.preventDefault();
                form = this;
                swal({
                    title: 'Êtes vous sûr ?',
                    text: "Voulez vous <strong>vraiment</strong> supprimer ces permissions ? <br/> (attention réservés aux devs car incidences dans le code !)",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Oui, je le veux !',
                    html: true
                }, function() {
                    form.submit();
                });
            });
        });
    </script>
@endpush