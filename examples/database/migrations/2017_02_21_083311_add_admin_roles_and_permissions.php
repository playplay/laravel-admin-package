<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddAdminRolesAndPermissions extends Migration
{
    protected $permissions;

    public function __construct()
    {
        $this->permissions = collect(['see-backoffice', 'manage-users', 'log-as']);
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->permissions()->createMany(
            $this->permissions->map(function ($permisssion) {
                return ['name' => $permisssion];
            })->toArray()
        );

        \App\Models\User::find(1)->assignRole('admin');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Models\User::find(1)->removeRole('admin');

        Permission::whereIn('name', $this->permissions->toArray())->delete();
        Role::whereName('admin')->delete();
    }
}
