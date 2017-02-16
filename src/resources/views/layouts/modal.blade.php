<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">
        @yield('title')
    </h4>
</div>
@yield('before_body')
<div class="modal-body">
    <div class="box-body">
        @yield('body');
    </div>
</div>
<div class="modal-footer">
    @yield('footer')
</div>
@yield('after_footer')

@include('admin::partials.partials.modal-form')