<div class="form-group users-checkboxes">
    @php($options = ['class' => 'btn btn-default btn-xs'])
    {!! AdminForm::label('users[]', 'Utilisateurs') !!}
    <div>
        {!! Form::button('Selectionner tous', $options + ['rel' => "select-all-button"]) !!}
        {!! Form::button('Inverser la selection', $options + ['rel' => "select-invert-button"]) !!}
        {!! Form::button('Réinitialiser la selection', $options + ['rel' => "select-reset-button"]) !!}
    </div>
    {!! AdminForm::checkboxes('users[]', null, $allUsers, $actualUsers, true) !!}
</div>

@push('scripts')
    <script>
        $(function () {
            $('.users-checkboxes [rel=select-all-button]').click(function (event) {
                $('.users-checkboxes input:checkbox').each(function () {
                    this.checked = true;
                });
            });

            $('.users-checkboxes [rel=select-invert-button]').click(function (event) {
                $('.users-checkboxes input:checkbox').each(function () {
                    this.checked = !this.checked;
                });
            });

            $('.users-checkboxes [rel=select-reset-button]').click(function (event) {
                $('.users-checkboxes input:checkbox').each(function () {
                    this.checked = $(this).attr('checked');
                });
            });
        });
    </script>
@endpush