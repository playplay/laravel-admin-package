<?php 

namespace MathieuTu\LaravelAdminPackage\Facades;

use Illuminate\Support\Facades\Facade;

class Show extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'admin_show';
    }
}
