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
                    {!! AdminForm::open(['model' => $user, 'update' => 'Admin\\UserController@update']) !!}
                    {!! AdminForm::text('name') !!}
                    {!! AdminForm::email() !!}
                    {!! AdminForm::password() !!}
                    {!! AdminForm::password('password_confirmation') !!}
                    @can('manage-role')

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

@push('styles')
<style>
    .form-control {
        margin-left: 3%;
        width: 94%;
    }
</style>
@endpush
