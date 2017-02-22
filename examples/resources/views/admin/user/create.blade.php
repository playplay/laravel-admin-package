<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Créer un utilisateur</h4>
</div>
{!! AdminForm::open(['route' => 'admin.users.store', 'rel' => 'modal']) !!}
<div class="modal-body">
    <div class="box-body">
        {!! AdminForm::input('text', 'name') !!}
        {!! AdminForm::email() !!}
        {!! AdminForm::password() !!}
        {!! AdminForm::password('password_confirmation') !!}
        @role('admin')
            {!! AdminForm::checkbox('is_admin') !!}
        @role
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
    <button type="submit" class="btn btn-primary">Créer</button>

</div>
{!! Form::close() !!}

@include('admin::partials.assets.modal-forms')
