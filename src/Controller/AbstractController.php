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
     * Redirect to a new
     *
     * @param [type] $controller
     * @param string $action
     * @param array $params
     * @return void
     */
    public function redirect(string $controller, string $action, array $params = [])
    {
        return $this->router->redirect($controller, $action, $params);
    }

    /**
     * Render a HTML page view
     *
     * @param string $view
     * @param array $params
     * @return void
     */
    public function render(string $file, array $params = [])
    {
        $view = new View($this->router);
        
        $view->setViewPath($this->getId());
        echo $view->render($file, $params);
    }

}