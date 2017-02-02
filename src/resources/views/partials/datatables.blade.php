<table id="{{ $tableId = 'table_' . str_random() }}" class="table table-bordered table-striped table-hover"
       rel="datatables">
    <thead>
        <tr>
            @foreach( $columns as $attribute )
                <th>{{ trans('validation.attributes.' . $attribute) }}</th>
            @endforeach
            @if(isset($config['has_actions']))
                <th>Actions</th>
            @endif
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

@push('scripts')
    <script type="text/javascript">
    $(function () {
        var datatable = $("#{{ $tableId }}").DataTable({
            @if(isset($config['reorder_url']))
            rowReorder: {
                update: false,
                dataSrc: 'order'
            },
            @endif
            processing: true,
            serverSide: true,
            ajax: "{{ $config['ajax_url'] }}",
            columns: [
                    @foreach( $columns as $attribute )
                {
                    data: '{{ $attribute }}', name: '{{ $attribute }}'
                },
                    @endforeach
                    @if(isset($config['has_actions']))
                {
                    data: 'actions', name: 'actions', searchable: false, orderable: false
                }
                @endif
            ],
            language: {
                processing: "Traitement en cours...",
                info: "Affichage des {{ $config['vars'] }} _START_ &agrave; _END_ sur _TOTAL_ {{ $config['vars'] }}",
                infoEmpty: "Aucun(e) {{ $config['var'] }} trouvé(e)",
                infoFiltered: "(filtr&eacute; de _MAX_ {{ $config['vars'] }} au total)",
                infoPostFix: "",
                loadingRecords: "Chargement en cours...",
                zeroRecords: "Aucun(e) {{ $config['var'] }} trouvé(e)",
                emptyTable: "Aucun(e) {{ $config['var'] }} trouvé(e)",
                paginate: {
                    first: "<<",
                    previous: "<",
                    next: ">",
                    last: ">>"
                },
                aria: {
                    sSortAscending: ": activer pour trier la colonne par ordre croissant",
                    sSortDescending: ": activer pour trier la colonne par ordre d&eacute;croissant"
                },
                lengthMenu: "_MENU_",
                search: "_INPUT_",
                searchPlaceholder: "Recherche"
            },
            fnDrawCallback: function (oSettings) {
                if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
                    $(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
                    var $indexInfo = $('#index_info');
                    $indexInfo.text('Affichage des ' + oSettings.fnRecordsDisplay() + ' {!! $config['vars'] !!}');
                    if (oSettings.fnRecordsDisplay() <= 1) {
                        $indexInfo.hide();
                    }
                } else {
                    $(oSettings.nTableWrapper).find('.dataTables_paginate').show();
                    $('ul.pagination li.paginate_button.disabled').remove();
                }

            }

        });
        @if(isset($config['reorder_url']))
            datatable.on('row-reorder', function (e, diff) {
            $.ajax({
                url: "{{ $config['reorder_url'] }}",
                type: 'POST',
                data: JSON.stringify(diff),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'content-type': 'application/json'
                },
                success: function (data) {
                    datatable.ajax.reload(null, false);
                },
                error: function (data) {
                    swal('Oups !', 'Un problème est survenu, merci de contacter un admin.', 'error');
                }
            });
        });
        @endif
    });

</script>
@endpush