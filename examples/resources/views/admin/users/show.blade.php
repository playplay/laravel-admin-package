@extends("admin::layouts.app")
@php(AdminShow::open($user))

@section('contentheader.title', 'Users')
@section('contentheader.description', 'Show')
@section('contentheader.elements')
    @can('log-as')
        {!! AdminShow::linkButton('@logAs','Se connecter en tant que', ['class' => 'btn btn-default btn-sm']) !!}
    @endcan
    {!! AdminShow::indexButton(['class' => 'btn btn-default btn-sm']) !!}
    {!! AdminShow::editButton(['class' => 'btn btn-default btn-sm']) !!}
@endsection

@section('main-content')
    <div class="col-lg-5">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Informations générales</h3>
            </div>
            <div class="box-body">
                <ul class="infolist">
                    @php($fields = [
                        'name' => 'text',
                        'email' => 'email',
                        'created_at' => 'date',
                    ])
                    @foreach($fields as $attribute => $type)
                        <li class="form-group">
                            <label class="col-sm-5">
                                {{ trans('validation.attributes.'.$attribute) }} :
                            </label>
                            <div class="col-sm-7">
                                {!! AdminShow::{$type . 'attribute'}($attribute) !!}
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Roles et permissions</h3>
            </div>
            <div class="box-body">
                <ul class="col-sm-6">
                    <li>
                        <h4>Roles :</h4>
                        <ul class="">
                            @foreach($user->roles as $role)
                                <li class="">
                                    {{ $role->name }}
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li>
                        <h4>Permissions associées :</h4>
                        <ul class="">
                            @foreach($user->getPermissionsViaRoles() as $permission)
                                <li class="">
                                    {{ $permission->name }}
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
                <ul class="col-sm-6">
                    <li>
                        <h4>Permissions directes :</h4>
                        <ul class="">
                            @foreach($user->getDirectPermissions() as $permission)
                                <li class="">
                                    {{ $permission->name }}
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
