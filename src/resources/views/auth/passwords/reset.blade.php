@extends('admin::layouts.auth')

@section('html.head.title')
    Password reset
@endsection

@section('content')
    <body class="login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="{{ route('admin.home') }}">{!! config('admin.sitename.html') !!}</a>
            </div><!-- /.login-logo -->

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Oups !</strong> Quelques problèmes avec les données insérées<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="login-box-body">
                <p class="login-box-msg">Réinitialiser le mot de passe</p>
                {!! Form::open(['route' => 'admin.auth.passwordReset']) !!}
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" placeholder="Email" name="email"
                               value="{{ old('email') }}"/>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Mot de passe" name="password"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Mot de passe"
                               name="password_confirmation"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>

                    <div class="row">
                        <div class="col-xs-2">
                        </div><!-- /.col -->
                        <div class="col-xs-8">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Réinitialiser</button>
                        </div><!-- /.col -->
                        <div class="col-xs-2">
                        </div><!-- /.col -->
                    </div>
                {!! Form::close() !!}

                <div class="row" style="margin-top: 0.5em">
                    <div class="col-xs-6">
                        <a href="{{ route('admin.auth.login') }}">Se connecter</a><br>
                    </div>
                    @if(config('admin.is_registration_open'))
                        <div class="col-xs-6 text-right">
                            <a href="{{ route('admin.auth.register') }}">S'inscrire</a>
                        </div>
                    @endif
                </div>
            </div><!-- /.login-box-body -->

        </div><!-- /.login-box -->

        @include('admin::layouts.partials.html.scripts_auth')

        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
    </body>
@endsection
