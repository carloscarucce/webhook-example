<?php

namespace App\Provider;

use Corviz\DI\Provider;
use Corviz\Http\Request;
use Corviz\Http\RequestParser\FormUrlEncodedParser;
use Corviz\Http\RequestParser\JsonParser;
use Corviz\Http\RequestParser\MultipartFormDataParser;

class RequestProvider extends Provider
{
    /**
     * Init dependencies in the application container.
     */
    public function register()
    {
        /*
         * The parsers *MUST* be registered before
         * evaluating the request.
         */
        $this->registerParsers();

        //Register request in the container
        $this->container()->set(Request::class, Request::current());
    }

    /**
     * Register request parsers here.
     */
    private function registerParsers()
    {
        //Register parsers
        Request::registerParser(FormUrlEncodedParser::class);
        Request::registerParser(MultipartFormDataParser::class);
        Request::registerParser(JsonParser::class);
    }
}
