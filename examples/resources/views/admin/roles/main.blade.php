@php($currentAction = explode('@', request()->route()->getActionName())[1])

@extends('admin::layouts.app')
@section('contentheader.title', 'Roles et permissions')
@section('contentheader.description', 'Management')
@section('contentheader.elements')
    @if($currentAction !== 'index')
        @can('delete', \Spatie\Permission\Models\Permission::class)
            {!! AdminShow::open(\Spatie\Permission\Models\Role::class)->indexButton(['class' => 'btn btn-default btn-sm'], 'link', 'Supprimer des permissions') !!}
        @endcan
    @endif
@endsection


@section("main-content")
    <div class="row">
        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Les roles</h3>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-stacked">
                        @foreach($roles as $role)
                            <li class="{{ isset($actualRole) && $role->is($actualRole) ? 'active' : ''}}">
                                @php($button = $currentAction === 'edit' ? 'editButton' : 'showButton')
                                {!! AdminShow::open($role)->$button(['class' => ''], 'link', $role->name) !!}
                            </li>
                        @endforeach
                        <li>
                            {!! AdminShow::open(\Spatie\Permission\Models\Role::class)->createButton(['class' => ''], 'link', 'Nouveau...') !!}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        @if($currentAction === 'index')
            @can('delete', \Spatie\Permission\Models\Permission::class)
                @include('admin.permissions.partials.delete')
            @endcan
        @elseif(isset($actualRole))
            @include('admin.roles.partials.' . $currentAction)
        @endif
    </div>
@endsection

@include('admin::partials.assets.forms')
@include('admin::partials.assets.delete-button')
