<?php

namespace App\Auth;

use Corviz\Behaviour\Singleton;

class Auth implements Singleton
{
    /**
     * @var static
     */
    private static $instance;

    /**
     * @return static
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * Returns true if user is authenticated,
     * otherwise returns false.
     *
     * @return bool
     */
    public function authenticated() : bool
    {
        //@TODO Implement authentication check.
        return false;
    }

    /**
     * Attempt to authenticate user.
     *
     * @param string $user
     * @param string $password
     *
     * @return bool
     */
    public function login(string $user, string $password) : bool
    {
        //@TODO Implement login check.
        return false;
    }

    /**
     * Sign out current user.
     */
    public function logout() : bool
    {
        //@TODO Implement method.
        return true;
    }

    /**
     * Auth constructor.
     */
    private function __construct()
    {
        //Deny new instances
    }
}
