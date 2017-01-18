<!-- REQUIRED JS SCRIPTS ON ALL PAGES -->

<!-- Jquery -->
<script src="{{ asset('vendor/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>

<!-- SweetAlert -->
<script src="{{ asset('vendor/swal/sweetalert.min.js') }}" type="text/javascript"></script>

<!-- AdminLTE App -->
<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/adminlte/js/app.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/plugins/slimScroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>

<!-- Loaded by page -->
@stack('scripts')
