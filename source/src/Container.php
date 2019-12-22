<?php

namespace App;

class Container
{
    protected static $instance;
    /** @var array */
    private $dependencies;
    private $config;

    private function __construct($config)
    {
        $this->config = $config;
    }

    public static function getInstance(array $config)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static($config);
        }

        return static::$instance;
    }

    public function get($serviceName)
    {
        if(!$this->dependencies[$serviceName]) {
            $this->dependencies[$serviceName] = new Dependency(
                $this->config[$serviceName]['class'],
                $this->config[$serviceName]['constructorArgs'],
                $this->config[$serviceName]['method'] ?? null
            );
        }

        return $this->dependencies[$serviceName]->resolve($this);
    }

    private function __clone()
    {

    }
}