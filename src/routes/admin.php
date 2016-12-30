<?php
/** @var Illuminate\Routing\Router $router */

$router->get('/', function () {
    return 'home';
})->name('home');
