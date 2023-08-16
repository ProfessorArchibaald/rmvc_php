<?php

declare(strict_types=1);

namespace App\RMVC\Route;

class RouteDispatcher
{
    private RouteConfiguration $routeConfiguration;

    private string $requestUri = '/';

    private array $paramMap = [];

    private array $paramRequestMap = [];

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
        // 1.1. Следует почистить строку Route из web.php.
        $this->saveRequestUri();

        //2. Разбиваем строку Route из web.php на массив и сохраняем в новый массив позицию параметра и его название.
        $this->setParamMap();

        //3. Разбиваем строку запроса на массив и проверяем если в этом массиве позиция, как у позиции параметра.
        //3.1. Если есть такая позиция, значит приводим строку запроса в регулярное выражение.
        $this->makeRegexRequest();

        //4. Запускаем контроллер и action.
        $this->run();
    }

    private function saveRequestUri(): void
    {
        if ($_SERVER['REQUEST_URI'] !== '/') {
            $this->requestUri = $this->clean($_SERVER['REQUEST_URI']);
            $this->routeConfiguration->route = $this->clean($this->routeConfiguration->route);
        }
    }

    private function clean(string $str): string
    {
        return preg_replace('/(^\/)|(\/$)/', '', $str);
    }

    private function setParamMap(): void
    {
        $routeArray = explode('/', $this->routeConfiguration->route);

        foreach ($routeArray as $paramKey => $param) {
            if (preg_match('/{.*}/', $param)) {
                $this->paramMap[$paramKey] = preg_replace('/(^{)|(}$)/', '', $param);
            }
        }
    }

    private function makeRegexRequest(): void
    {
        $requestUriArray = explode('/', $this->requestUri);

        foreach ($this->paramMap as $paramKey => $param) {
            if (!isset($requestUriArray[$paramKey])) {
                return;
            }
            $this->paramRequestMap[$param] = $requestUriArray[$paramKey];
            $requestUriArray[$paramKey] = '{.*}';
        }
        $this->requestUri = implode('/', $requestUriArray);
        $this->prepareRegex();
    }

    private function prepareRegex(): void
    {
        $this->requestUri = str_replace('/', '\/', $this->requestUri);
    }

    private function run(): void
    {
        if (preg_match("/$this->requestUri/", $this->routeConfiguration->route)) {
            $this->render();
        }
    }

    private function render()
    {
        $ClassName = $this->routeConfiguration->controller;
        $action = $this->routeConfiguration->action;
        print((new $ClassName)->$action(...$this->paramRequestMap));

        die();
    }
}