@extends('admin::layouts.auth')

@section('html.head.title', 'Connexion')

@section('content')
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="{{ route('admin.home') }}">{!! config('admin.sitename.html') !!}</a>
            </div>

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Oups !</strong> Il y a eu un problème avec vos identifiants.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="login-box-body">
                <p class="login-box-msg">Connexion</p>
                {!! Form::open(['route' => 'admin.auth.login']) !!}
                <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="Adresse email" name="email" required/>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Mot de passe" name="password" required/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox" style="margin-bottom: inherit;">
                            <label>
                                <input type="checkbox" name="remember"> Se souvenir de moi
                            </label>
                        </div>
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

        @include('admin::layouts.partials.html.scripts_auth')
    </body>

@endsection
