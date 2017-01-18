@push('styles')
{{ Html::style('vendor/plugins/datatables/dataTables.bootstrap.css') }}
@endpush

@push('scripts')
{{ Html::script('vendor/plugins/datatables/jquery.dataTables.min.js') }}
{{ Html::script('vendor/plugins/datatables/dataTables.bootstrap.min.js') }}
@endpush
