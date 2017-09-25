<?php

namespace App\Provider;

use Corviz\DI\Provider;
use Corviz\Mvc\View\DefaultTemplateEngine;
use Corviz\Mvc\View\TemplateEngine;

class AppProvider extends Provider
{
    /**
     * Initialize provider.
     */
    public function register()
    {
        //Register
        $this->container()->setSingleton(TemplateEngine::class, DefaultTemplateEngine::class);
    }
}
