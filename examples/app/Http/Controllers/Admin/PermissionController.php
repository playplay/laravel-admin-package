<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends BaseController
{
    public function __construct()
    {
        $this->authorizeResource(Permission::class);
    }

    public function destroyMany(Request $request)
    {
        Permission::destroy($request->only('permissions'));

        alert()->success('Les permissions ont été supprimées.', 'C\'est tout bon !')
            ->confirmButton()->autoclose(7000);

        return redirect()->back();
    }

    protected function resourceAbilityMap()
    {
        return [
            'destroyMany' => 'delete',
        ];
    }

    protected function methodsWithoutParameters()
    {
        return ['destroyMany'];
    }
}
