@push('styles')
{{ Html::style('assets/admin/vendor/plugins/select2/select2.css') }}
<style>
    .select2-tags-container ul {
        list-style: none;
        padding: 0;
        margin-top: 0;
        margin-bottom: 0;
        display: inline-block;
    }

    .tag-selected {
        list-style: none;
        background-color: #e4e4e4;
        border: 1px solid #aaa;
        border-radius: 4px;
        cursor: default;
        float: left;
        margin-right: 5px;
        margin-bottom: 5px;
        padding: 0 5px;
    }

    .destroy-tag-selected {
        color: #999;
        cursor: pointer;
        display: inline-block;
        font-weight: bold;
        margin-right: 2px;
    }

    .destroy-tag-selected:hover {
        text-decoration: none;
    }

    .select2-selection__choice {
        display: none;
    }

    .select2-container--default .select2-results__option[aria-selected="true"] {
        display: none;
    }

</style>
@endpush

@push('scripts')
{{ Html::script('assets/admin/vendor/plugins/select2/select2.full.min.js') }}
{{ Html::script('assets/admin/vendor/plugins/select2/i18n/fr.js') }}

<script type="text/javascript">
    $(function () {
        $('[rel=select2]').select2({});

        $('<div class="select2-tags-container"></div>').insertBefore('[rel=taginput]');
        $('[rel=taginput]').select2({
            tokenSeparators: [',', ' ']
        }).on('change', function() {
                var $selected = $(this).find('option:selected');
                var $container = $(this).siblings('.select2-tags-container');

                var $list = $('<ul>');
                $selected.each(function(k, v) {
                    var $li = $('<li class="tag-selected"><a class="destroy-tag-selected">×</a>' + $(v).text() + '</li>');
                    $li.children('a.destroy-tag-selected')
                        .off('click.select2-copy')
                        .on('click.select2-copy', function(e) {
                            var $opt = $(this).data('select2-opt');
                            $opt.attr('selected', false);
                            $opt.parents('select').trigger('change');
                        }).data('select2-opt', $(v));
                    $list.append($li);
                });
                if ($list.children('li').length) {
                    $container.html('').append($list);
                } else {
                    $container.html('Selectionnez des elements :');
                }
            }).trigger('change');
    });
</script>
@endpush
