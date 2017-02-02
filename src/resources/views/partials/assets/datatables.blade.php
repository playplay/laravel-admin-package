@push('styles')
{{ Html::style('admin/vendor/plugins/datatables/dataTables.bootstrap.css') }}
@endpush

@push('scripts')
{{ Html::script('admin/vendor/plugins/datatables/jquery.dataTables.min.js') }}
{{ Html::script('admin/vendor/plugins/datatables/dataTables.bootstrap.min.js') }}
@endpush
