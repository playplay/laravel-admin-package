<!-- adminlte -->
{{ Html::style('admin/vendor/bootstrap/css/bootstrap.min.css') }}
{{ Html::style('admin/vendor/adminlte/css/AdminLTE.min.css') }}
{{ Html::style('admin/vendor/adminlte/css/skins/_all-skins.min.css') }}


<!-- icons -->
{{--<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />--}}
{{ Html::style('admin/vendor/fa/css/font-awesome.min.css') }}

<!-- SweetAlert -->
{{ Html::style('admin/vendor/swal/sweetalert.css') }}
{{ Html::style('admin/css/app.css') }}

@stack('styles')
