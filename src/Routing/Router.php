<?php

namespace LaravelAdminPackage\Routing;

class Router extends \Illuminate\Routing\Router
{
    /**
     * Register the typical authentication routes for an application.
     *
     * @param array $options
     * @return void
     */
    public function auth(array $options = [])
    {
        // Authentication Routes...
        $this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
        $this->post('login', 'Auth\LoginController@login');
        $this->any('logout', 'Auth\LoginController@logout')->name('logout');

        // Registration Routes...
        $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
        $this->post('register', 'Auth\RegisterController@register');

        // Password Reset Routes...
        $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('passwordReset');
        $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('passwordSendEmail');
        $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('passwordResetForm');
        $this->post('password/reset', 'Auth\ResetPasswordController@reset');
    }

    /**
     * Route a resource to a controller.
     *
     * @param  string $name
     * @param  string $controller
     * @param  array  $options
     *
     * @return void
     */
    public function resourceWithDatatables($name, $controller, array $options = [])
    {
        $registrar = new ResourceRegistrar($this);
        $registrar->register($name, $controller, $options);
    }
}
