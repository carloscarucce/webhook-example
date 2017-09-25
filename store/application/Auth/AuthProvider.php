<?php

namespace App\Auth;

use Corviz\DI\Provider;

class AuthProvider extends Provider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->container()->setSingleton(Auth::class, Auth::getInstance());
    }
}
