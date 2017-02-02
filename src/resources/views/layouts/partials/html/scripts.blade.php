<!-- REQUIRED JS SCRIPTS ON ALL PAGES -->

<!-- Jquery -->
<script src="{{ asset('admin/vendor/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>

<!-- SweetAlert -->
<script src="{{ asset('admin/vendor/swal/sweetalert.min.js') }}" type="text/javascript"></script>

<!-- AdminLTE App -->
<script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/vendor/adminlte/js/app.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/vendor/plugins/slimScroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>

<!-- Empty bootstrap modal -->
<script>
$('body').on('hidden.bs.modal', '.modal', function () {
    $(this).removeData('bs.modal');
});
</script>
<!-- Loaded by page -->
@stack('scripts')
