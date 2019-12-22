<?php

use App\Container;

if (! function_exists('app')) {
    /**
     * Get the available container instance.
     * @param string|null $make
     * @return mixed
     */
    function app(string $make = null)
    {
        $servicesConfig = require __DIR__ . '/config/services.php';
        /** @var Container $container */
        $container = Container::getInstance($servicesConfig);
        return $container->get($make);
    }
}