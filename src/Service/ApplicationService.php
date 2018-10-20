<?php

namespace Service;

use Service\RouteService;

class ApplicationService
{
    /**
     * A router object
     *
     * @var RouteService
     */
    private $route;

    /**
     * Construct a route parser
     *
     * @param RouteService $route
     */
    public function __construct(RouteService $route) 
    {
        $this->route = $route;
    }

    /**
     * Handle a route to render a corresponding controller and action page
     *
     * @return void
     */
    public function run()
    {
        $ctrl   = '\\Controller\\' . ucwords($this->route->getController()) . 'Controller';
        $action = ucwords($this->route->getAction()) . 'Action';

        if (!class_exists($ctrl)) {
            throw new \Exception('The conntroller named "' . $ctrl . '" does not exist.');
        }

        $controller = new $ctrl;
        $controller->setRoute($this->route);
        
        if (!method_exists($controller, $action)) {
            throw new \Exception('Action "' . $action . '" is undefined.');
        }

        $controller->$action();

    }
}