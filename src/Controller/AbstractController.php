<?php

namespace Controller;

use Service\RouteService;
use View\Handler as View;


abstract class AbstractController 
{
    protected $router;

    /**
     * Get a controller class name
     */
    public function getId()
    {
        return get_called_class();
    }

    /**
     * Set a RouteService object
     * 
     * @param RouteService $router
     */
    public function setRoute(RouteService $router)
    {
        $this->router = $router;
    }

    /**
     * Create a complete URL based on the given parameters
     *
     * @param string $controller
     * @param string $action
     * @param array $params
     * @return string
     */
    public function createUrl(string $controller, string $action, array $params = [])
    {
        return $this->router->createUrl($controller, $action, $params);
    }

    /**
     * Render a HTML page view
     *
     * @param [type] $view
     * @param array $params
     * @return void
     */
    public function render($file, $params = [])
    {
        $view = new View;
        
        $view->setViewPath($this->getId());
        echo $view->render($file, $params);
    }

}