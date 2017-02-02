<?php
/** @var \LaravelAdminPackage\Routing\Router $router */

$router->get('/', function () {
    return 'home';
})->name('home');

$router->resourceWithDatatables('users', 'UserController');
