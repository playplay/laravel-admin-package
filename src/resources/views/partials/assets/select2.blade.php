@push('styles')
{{ Html::style('vendor/plugins/select2/select2.css') }}
@endpush

@push('scripts')
{{ Html::script('vendor/plugins/select2/select2.full.min.js') }}
{{ Html::script('vendor/plugins/select2/i18n/fr.js') }}

<script type="text/javascript">
    $(function () {
        $("[rel=select2]").select2({
        });
        $("[rel=taginput]").select2({
            tags: true,
            tokenSeparators: [',']
        });
    });
</script>
@endpush
