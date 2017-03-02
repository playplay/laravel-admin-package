<div class="form-group permissions-checkboxes">
    @php($options = ['class' => 'btn btn-default btn-xs'])
    {!! AdminForm::label('permissions[]', 'Permissions') !!}
    <div>
        {!! Form::button('Selectionner tous', $options + ['rel' => "select-all-button"]) !!}
        {!! Form::button('Inverser la selection', $options + ['rel' => "select-invert-button"]) !!}
        {!! Form::button('Réinitialiser la selection', $options + ['rel' => "select-reset-button"]) !!}
    </div>
    {!! AdminForm::checkboxes('permissions[]', null, $allPermissions, $actualPermissions, true) !!}
</div>

@push('scripts')
    <script>
        $(function () {
            $('.permissions-checkboxes [rel=select-all-button]').click(function (event) {
                $('.permissions-checkboxes input:checkbox').each(function () {
                    this.checked = true;
                });
            });

            $('.permissions-checkboxes [rel=select-invert-button]').click(function (event) {
                $('.permissions-checkboxes input:checkbox').each(function () {
                    this.checked = !this.checked;
                });
            });

            $('.permissions-checkboxes [rel=select-reset-button]').click(function (event) {
                $('.permissions-checkboxes input:checkbox').each(function () {
                    this.checked = $(this).attr('checked');
                });
            });
        });
    </script>
@endpush