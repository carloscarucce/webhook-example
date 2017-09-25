<?php

namespace App\Http\Middleware;

use App\Auth\Auth;
use Closure;
use Corviz\Http\Middleware;
use Corviz\Http\Response;

class AuthMiddleware extends Middleware
{
    /**
     * @var \App\Auth\Auth
     */
    protected $auth;

    /**
     * {@inheritdoc}
     */
    public function handle(Closure $next) : Response
    {
        if ($this->auth->authenticated()) {
            return $next();
        }

        throw new \Exception('Access denied.');
    }

    /**
     * Authentication constructor.
     *
     * @param \App\Auth\Auth $auth
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }
}
