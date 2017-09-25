<?php

namespace App\Http\Controller;

class Home extends AppController
{
    /**
     * Index action handler.
     */
    public function index()
    {
        return $this->view('home/index');
    }
}
