<?php

namespace LaravelAdminPackage\Datatables;

abstract class BaseEngine extends \Yajra\Datatables\Engines\BaseEngine
{
    public function addActions()
    {
        return $this->addColumn('actions', function ($model) {
            return app('admin_show')->open($model)->indexActions('name');
        });
    }
}
