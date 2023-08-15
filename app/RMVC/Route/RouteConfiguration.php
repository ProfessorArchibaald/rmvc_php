<?php

declare(strict_types=1);

namespace App\RMVC\Route;

class RouteConfiguration
{
    public string $route;

    public string $controller;

    public string $action;

    private string $name;

    private string $middleware;

    /**
     * @param string $route
     * @param string $controller
     * @param string $action
     */
    public function __construct(string $route, string $controller, string $action)
    {
        $this->route = $route;
        $this->controller = $controller;
        $this->action = $action;
    }

    public function name(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function middleware(string $middleware): self
    {
        $this->middleware = $middleware;

        return $this;
    }

}