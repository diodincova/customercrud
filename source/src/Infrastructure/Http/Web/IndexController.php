<?php

namespace App\Infrastructure\Http\Web;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class IndexController
{
    public function index()
    {
        return JsonResponse::create([ 'status' => Response::HTTP_OK, 'errors' => [], 'data' => [] ]);
    }
}