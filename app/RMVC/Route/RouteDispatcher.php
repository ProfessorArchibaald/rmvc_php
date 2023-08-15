<?php

declare(strict_types=1);

namespace App\RMVC\Route;

class RouteDispatcher
{
    private RouteConfiguration $routeConfiguration;

    /**
     * @param RouteConfiguration $routeConfiguration
     */
    public function __construct(RouteConfiguration $routeConfiguration)
    {
        $this->routeConfiguration = $routeConfiguration;
    }

    public function process()
    {
        // 1. Если строка запроса есть, значит мы должны почистить и сохранить ее.
        // 1.1 Следует почистить строку роута.
    }
}