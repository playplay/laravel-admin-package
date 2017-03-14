<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends BaseController
{

    public function __construct()
    {
        $this->authorizeResource(Role::class);
    }

    public function index()
    {
        return $this->returnView();
    }

    protected function returnView(Role $role = null)
    {
        $roles = Role::with('permissions')->get();
        $allPermissions = Permission::pluck('name', 'id')->toArray();
        if ($role) {
            $actualRole = $role;
            $actualPermissions = $role->permissions()->pluck('id')->toArray();
            $allUsers = User::pluck('name', 'id')->toArray();
            $actualUsers = $role->users()->pluck('id')->toArray();
        }

        return view('admin.roles.main', compact('roles',
            'actualRole',
            'allPermissions',
            'actualPermissions',
            'allUsers',
            'actualUsers'
        ));
    }

    public function show(Role $role)
    {
        return $this->returnView($role);
    }

    public function create()
    {
        return redirect($this->action(
            'edit',
            Role::create(['name' => 'Nouveau role'])
        ));
    }

    public function edit(Role $role)
    {
        return $this->returnView($role);
    }

    public function update(Request $request, Role $role)
    {
        $role->update($request->intersect(['name']));

        extract(($request->only('users', 'permissions')),EXTR_SKIP);

        $role->users()->sync((array) $users);

        $existingPermissions = Permission::whereIn('id', $permissions)->pluck('id');
        $role->permissions()->sync($existingPermissions);

        if ($this->createNewPermissions($role, $permissions, $existingPermissions)) {
            alert()->success('<strong>' . $role->name . '</strong> a été modifié avec succés.', 'C\'est tout bon !')
                ->html()->confirmButton()->autoclose(7000);
        }

        $role->forgetCachedPermissions();

        return redirect()->back();
    }

    protected function createNewPermissions(Role $role, array $permissions, Collection $existingPermissions)
    {
        $permissionsToCreate = collect($permissions)->diff($existingPermissions)->map(function ($name) {
            return compact('name');
        });

        if ($permissionsToCreate->isEmpty()) {
            return true;
        }

        try {
            $this->authorize('manage-permissions');
        } catch (AuthorizationException $e) {
            $msg = 'Vous n\'avez pas les droits de créer des permissions <br>
                <strong>Celles déjà existantes ont néanmoins été ajouté au rôle.</strong>';
            alert()->error($msg, 'Désolé')->html()->confirmButton()->autoclose(7000);

            return false;
        }

        $role->permissions()->createMany($permissionsToCreate->toArray());

        return true;
    }

    public function destroy(Role $role)
    {
        return $this->ajaxDelete($role);
    }
}
