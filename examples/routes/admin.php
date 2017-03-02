<?php
/** @var \LaravelAdminPackage\Routing\Router $router */

$router->get('/', function () {
    return 'admin home';
})->name('home');

$router->get('log_as/{user?}', 'UserController@logAs');
$router->resourceWithDatatables('users', 'UserController');

$router->resource('roles', 'RoleController');

$router->delete('permissions/delete', 'PermissionController@destroyMany')->name('permissions.delete');
