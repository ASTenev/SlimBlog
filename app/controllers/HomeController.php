<?php

namespace App\Controllers;

class HomeController
{
    public function index($request, $response, $args)
    {
        return $this->view->render($response, 'home.twig');
    }
}