@extends('admin::layouts.app')
@section('contentheader.title', 'Users')
@section('contentheader.description', 'Index')
@section('contentheader.elements')
    {!! AdminShow::open(App\Models\User::class)->createButton(['class' => 'btn btn-default btn-sm'], 'modal') !!}
@endsection



@section("main-content")
    <div class="box">
        <div class="box-body">
            @include('admin::partials.datatables', [
                'columns' => [
                    'name',
                    'email',
                    'is_admin' => ['searchable' => false, 'orderable' => false],
                    'created_at',
                ],
                'config' => [
                    'has_actions' => true,
                    'ajax_url' => route('admin.users.datatables'),
                    'var' => 'utilisateur',
                    'vars' => 'utilisateurs'
                ]
            ])
        </div>
    </div>
@endsection

@include('admin::partials.assets.datatables')
@include('admin::partials.assets.delete-button')
