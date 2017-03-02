<div class="col-md-8">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Les permissions de "{{$actualRole->name}}"</h3>
        </div>
        <div class="box-body">
            {!! AdminForm::open(['model' => $actualRole, 'update' => 'admin.roles.update']) !!}
            {!! AdminForm::tags('permissions[]', 'Permissions', $allPermissions, $actualPermissions, [], true) !!}
            {!! AdminForm::tags('users[]', 'Utilisateurs', $allUsers, $actualUsers) !!}
            {!! Form::submit('Enregistrer', ['class' => 'btn btn-primary']) !!}
            {!! AdminShow::open($actualRole)->editButton(['class' => 'btn btn-default', 'style' => 'margin-left:10px'], 'link', 'Avancé') !!}
            {!! AdminForm::close() !!}
        </div>
    </div>
</div>