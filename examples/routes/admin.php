<?php
/** @var \LaravelAdminPackage\Routing\Router $router */

$router->get('/', function () {
    return 'admin home';
})->name('home');

$router->resourceWithDatatables('users', 'UserController');
