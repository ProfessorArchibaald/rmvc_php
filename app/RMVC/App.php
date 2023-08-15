<?php

declare(strict_types=1);

namespace App\RMVC;

use App\RMVC\Route\Route;
use App\RMVC\Route\RouteDispatcher;

class App
{
    public static function run(): void
    {
        foreach (Route::getRoutesGet() as $routeConfiguration) {
            $routeDispatcher = new RouteDispatcher($routeConfiguration);
            $routeDispatcher->process();
        }
    }
}