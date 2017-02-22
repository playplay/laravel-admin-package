@extends("admin::layouts.app")
@php(AdminShow::open($user))

@section('contentheader.title', 'Users')
@section('contentheader.description', 'Show')
@section('contentheader.elements')
    {!! AdminShow::indexButton(['class' => 'btn btn-default btn-sm']) !!}
    {!! AdminShow::showButton(['class' => 'btn btn-default btn-sm']) !!}
@endsection

@section('main-content')
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    @php($options = ['style' => 'margin-left:20px'])
                    {!! AdminForm::open(['model' => $user, 'update' => 'Admin\\UserController@update']) !!}
                    {!! AdminForm::text('name', null, null, $options) !!}
                    {!! AdminForm::email('email' , null, null, $options) !!}
                    {!! AdminForm::password('password', null, $options) !!}
                    {!! AdminForm::password('password_confirmation', null, $options) !!}
                    @role('admin')
                        {!! AdminForm::checkbox('is_admin') !!}
                    @endrole
                    <br>
                    <div class="form-group pull-right">
                        {!! Form::reset('Réinitialiser', ['class' => 'btn btn-default']) !!}
                        {!! Form::submit('Enregistrer', ['class'=>'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
