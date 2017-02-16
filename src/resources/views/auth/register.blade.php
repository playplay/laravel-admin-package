@extends('admin::layouts.auth')

@section('html.head.title', 'Inscription')

@section('content')
    <body class="hold-transition register-page">
        <div class="register-box">
            <div class="register-logo">
                <a href="{{ route('admin.home') }}">{!! config('admin.sitename.html') !!}</a>
            </div>

            <div class="register-box-body">
                <p class="login-box-msg">Inscription</p>
                {!! Form::open(['route' => 'admin.auth.register']) !!}
                {!! AdminForm::hasFeedback('user')->text('name', false, null, ['placeholder' => 'Nom']) !!}
                {!! AdminForm::hasFeedback('envelope')->email('email', false, null, ['placeholder' => trans('validation.attributes.email')]) !!}
                {!! AdminForm::hasFeedback('lock')->password('password', false, ['placeholder' => trans('validation.attributes.password')]) !!}
                {!! AdminForm::hasFeedback('lock')->password('password_confirmation', false, ['placeholder' => 'Confirmation']) !!}
                <div class="row">
                    <div class="col-xs-8">
                        <a href="{{ route('admin.auth.login') }}">J'ai déjà un compte</a>
                    </div>
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-default btn-block btn-flat">Inscription</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </body>

@endsection
