<?php

namespace Service;

class RouteService 
{
    /**
     * Controller
     *
     * @var string 
     */
    private $controller = 'index';
    
    /**
     * Action
     *
     * @var string
     */
    private $action = 'index';
    
    /**
     * Params
     *
     * @var array
     */
    private $params = [];

    /**
     * Base url
     *
     * @var string
     */
    private $baseUrl;

    
    public function __construct()
    {
        // Get current URL
        $url = $this->getRequest();
        
        $this->parseUrl($url);
    }

    /**
     * Get current request
     *
     * @return string
     */
    protected function getRequest(): string
    {
        if(isset($_SERVER['HTTPS'])){
            $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
        }
        else{
            $protocol = 'http';
        }
        
        $this->baseUrl = $protocol . "://" . $_SERVER['HTTP_HOST'];

        return $this->baseUrl . $_SERVER['REQUEST_URI'];
    }   

    /**
     * Parse a given url and split it into corresponding keys and values
     *
     * @param string $url
     * @return void
     */
    private function parseUrl($url) 
    {
        $queryString = parse_url($url, PHP_URL_QUERY);

        parse_str($queryString, $params);

        if (is_array($params)) {
            $this->setController ($params['controller'] ?? $this->controller);
            $this->setAction ($params['action'] ?? $this->action);
            
            unset($params['controller'], $params['action']);
            
            $params = array_filter($params, function($val) {
                return $val != "";
            });
            
            $this->setParams($params);
        }
    }

    /**
     * This creates a complete URL based on the given parameters
     *
     * @param string $controller
     * @param string $action
     * @param array $params
     * @return string
     */
    public function createUrl(string $controller, string $action, array $params = []): string
    {
        $queryString = null;

        if (count($params) > 0) {
            $arr = [];
            
            foreach ($params as $param => $val) {
                $arr[] = "$param=$val"; 
            }

            $queryString = '&' . implode('&', $arr);
        }

        return urldecode($this->getBaseUrl() . "?controller=$controller&action=$action" . $queryString);
    }

    /**
     * Get controller
     *
     * @return  string
     */ 
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Set controller
     *
     * @param  string  $controller  controller
     *
     * @return  self
     */ 
    public function setController(string $controller)
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * Get action
     *
     * @return  string
     */ 
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set action
     *
     * @param  string  $action  action
     *
     * @return  self
     */ 
    public function setAction(string $action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get params
     *
     * @return  array
     */ 
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Set params
     *
     * @param  array  $params  params
     *
     * @return  self
     */ 
    public function setParams(array $params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * Get base url
     *
     * @return  string
     */ 
    public function getBaseUrl()
    {
        return $this->baseUrl . '/';
    }
}