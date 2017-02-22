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
    <div id="page-content" class="profile2">
        <div>
            <div class="panel infolist">
                <div class="panel-body">
                    @php($fields = [
                        'name' => 'text',
                        'email' => 'email',
                        'created_at' => 'date',
                    ])
                    @foreach($fields as $attribute => $type)
                        <div class="form-group">
                            <label class="col-md-3">
                                {{ trans('validation.attributes.'.$attribute) }} :
                            </label>
                            <div class="col-md-9">
                                {!! AdminShow::{$type . 'attribute'}($attribute) !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
