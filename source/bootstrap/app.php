<?php

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

require dirname(__DIR__).'/vendor/autoload.php';
require dirname(__DIR__).'/helpers.php';

$fileLocator = new FileLocator([dirname(__DIR__)]);
$loader = new YamlFileLoader($fileLocator);
$routes = $loader->load('routes.yaml');

$matcher = new UrlMatcher($routes, new RequestContext());

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new RouterListener($matcher, new RequestStack()));

$request = Request::createFromGlobals();
$kernel = new HttpKernel($dispatcher, new ControllerResolver(), new RequestStack(), new ArgumentResolver());

try {
    $response = $kernel->handle($request);
} catch (Exception $e) {
    $response = new JsonResponse(
        [ 'status' => Response::HTTP_NOT_FOUND, 'errors' => ['Route not found'], 'data' => [] ],
        Response::HTTP_NOT_FOUND
    );
}

$response->send();
$kernel->terminate($request, $response);
