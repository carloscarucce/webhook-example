<?php

use \App\Http\Middleware;

return [
    /*
     * Middlewares
     */
    'middleware' => [
        'auth' => Middleware\AuthMiddleware::class,
    ],

    /*
     * Application providers
     */
    'providers' => [
        \App\Auth\AuthProvider::class,
        \App\Provider\AppProvider::class,
        \App\Provider\RequestProvider::class,
        \App\Provider\RoutingProvider::class,
    ],
];
