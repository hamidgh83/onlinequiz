<?php

namespace View;

use Service\RouteService;

class Handler extends AbstractView
{
    public function createUrl(string $controller, string $action, array $params = [])
    {
        return $this->router->createUrl($controller, $action, $params);
    }

    public function getBaseUrl()
    {
        return $this->router->getBaseUrl();
    }

    public function getAssetsUrl()
    {
        return $this->getBaseUrl() . 'Assets/';
    }
}
