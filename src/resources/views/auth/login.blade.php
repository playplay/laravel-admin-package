@extends('admin::layouts.auth')

@section('html.head.title', 'Connexion')

@section('content')
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="{{ route('admin.home') }}">{!! config('admin.sitename.html') !!}</a>
            </div>
            <div class="login-box-body">
                <p class="login-box-msg">Connexion</p>
                {!! Form::open(['route' => 'admin.auth.login']) !!}
                {!! AdminForm::hasFeedback('envelope')->email('email', false, null, ['placeholder' => 'Adresse email']) !!}
                {!! AdminForm::hasFeedback('lock')->password('password', false, ['placeholder' => 'Mot de passe']) !!}
                <div class="row">
                    <div class="col-xs-8">
                        {!! AdminForm::checkbox('remember', 'Se souvenir de moi') !!}
                    </div>
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-default btn-block btn-flat">Connexion</button>
                    </div><!-- /.col -->
                </div>
                {!! Form::close() !!}

                <div class="row" style="margin-top: 0.5em">
                    <div class="col-xs-6">
                        <a href="{{ route('admin.auth.passwordReset') }}">Mot de passe oublié</a><br>
                    </div>
                    @if(config('admin.is_registration_open'))
                        <div class="col-xs-6 text-right">
                            <a href="{{ route('admin.auth.register') }}">S'inscrire</a>
                        </div>
                    @endif
                </div>

            </div><!-- /.login-box-body -->

        </div><!-- /.login-box -->
    </body>

@endsection
