<?php

namespace MathieuTu\LaravelAdminPackage\Routing;

class Router extends \Illuminate\Routing\Router
{
    /**
     * Register the typical authentication routes for an application.
     *
     * @return void
     */
    public function auth()
    {
        parent::auth();

        // Password Reset Routes...
        $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('passwordReset');
        $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('passwordSendEmail');
        $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
        $this->post('password/reset', 'Auth\ResetPasswordController@reset');
    }
}
