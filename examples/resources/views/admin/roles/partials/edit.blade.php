<div class="col-md-8">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Edition de "{{$actualRole->name}}"</h3>
        </div>
        <div class="box-body">
            {!! AdminForm::open(['model' => $actualRole, 'update' => 'admin.roles.update', 'style' => 'display: inline']) !!}
            {!! AdminForm::text('name') !!}
            @include('admin.permissions.partials.checkboxes')
            @include('admin.users.partials.checkboxes')
            {!! Form::submit('Enregistrer', ['class' => 'btn btn-primary']) !!}
            {!! AdminForm::close() !!}
            {!! AdminShow::open($actualRole)->deleteButton(['class' => 'btn btn-danger', 'style' => 'margin-left:10px'], 'Supprimer', 'name', '@index') !!}
            {!! AdminShow::open($actualRole)->showButton(['class' => 'btn btn-default', 'style' => 'margin-left:10px'], 'link', 'Revenir') !!}
        </div>
    </div>
</div>