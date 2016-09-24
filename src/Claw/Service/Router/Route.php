<?php

namespace Claw\Service\Router;

class Route
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $path;

    /**
     * @var callable
     */
    private $callback;

    /**
     * Route constructor.
     *
     * @param string   $method
     * @param string   $path
     * @param callable $callback
     */
    public function __construct($method, $path, callable $callback)
    {
        $this->method = $method;
        $this->path = $path;
        $this->callback = $callback;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return callable
     */
    public function getCallback()
    {
        return $this->callback;
    }
}
