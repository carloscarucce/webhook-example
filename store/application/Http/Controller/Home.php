<?php

namespace App\Http\Controller;

use Corviz\Http\Response;
use Corviz\Http\ResponseFactory;

class Home extends AppController
{
    /**
     * Index action handler.
     */
    public function index()
    {
        $response = new Response();
        $response->addHeader('location', 'http://localhost/webhook/store/public/checkout/cart/');

        return $response;
    }
}
