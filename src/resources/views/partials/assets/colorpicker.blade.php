@push('styles')
{{ Html::style('admin/vendor/plugins/colorpicker/bootstrap-colorpicker.min.css') }}
@endpush

@push('scripts')
{{ Html::script('admin/vendor/plugins/colorpicker/bootstrap-colorpicker.min.js') }}

<script type="text/javascript">
    $(function () {
        $("[rel=colorpicker]").each(function () {
            $(this).wrap('<div class="input-group colorpicker-component"></div>');
            $(this).after('<span class="input-group-addon"><i></i></span>');
            $(this).parent(".input-group").colorpicker({format: 'hex'});
        });
    });
</script>
@endpush
