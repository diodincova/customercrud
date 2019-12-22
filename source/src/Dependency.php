<?php

namespace App;

class Dependency
{
    private $className;
    private $constructorArgs = [];
    private $method;
    private $service;

    public function __construct(string $className, array $constructorArgs, string $method = null)
    {
        $this->className = $className;
        $this->constructorArgs = $constructorArgs;
        $this->method = $method;
    }

    public function resolve(Container $container)
    {
        if(!$this->service) {
            $args = [];
            foreach ($this->constructorArgs as $arg) {
                if (is_string($arg) && $arg[0] === '@') {
                    $args[] = $container->get(substr($arg, 1));
                } else {
                    $args[] = $arg;
                }
            }
            if($func = $this->method) {
                $this->service = $this->className::$func(...$args);
            } else {
                $this->service = new $this->className(...$args);
            }
        }

        return $this->service;
    }
}