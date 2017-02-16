@push('styles')
{{ Html::style('assets/admin/vendor/plugins/datatables/dataTables.bootstrap.css') }}
@endpush

@push('scripts')
{{ Html::script('assets/admin/vendor/plugins/datatables/jquery.dataTables.min.js') }}
{{ Html::script('assets/admin/vendor/plugins/datatables/dataTables.bootstrap.min.js') }}
@endpush
