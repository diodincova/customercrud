<?php

namespace App\Infrastructure\Http\Web;


use Symfony\Component\HttpFoundation\Response;

class IndexController
{
    public function index()
    {
        return Response::create();
    }
}