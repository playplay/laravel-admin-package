@push('styles')
{{ Html::style(asset('vendor/plugins/datatables/dataTables.bootstrap.css')) }}
@endpush

@push('scripts')
{{ Html::script(asset('vendor/plugins/datatables/jquery.dataTables.min.js')) }}
{{ Html::script(asset('vendor/plugins/datatables/dataTables.bootstrap.min.js')) }}
@endpush
