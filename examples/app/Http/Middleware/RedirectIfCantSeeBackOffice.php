<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class RedirectIfCantSeeBackOffice
{
    /**
     * @var \App\Models\User
     */
    private $user;

    public function __construct(Guard $auth)
    {
        $this->user = $auth->user();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->user->can('see-backoffice')) {
            return $next($request);
        }

        return redirect()->route('home');
    }
}
