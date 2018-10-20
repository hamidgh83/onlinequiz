<?php

namespace View;

abstract class AbstractView
{
    private $template  = 'default';

    private $viewPath;

    /**
     * Set path to the view files of a given controller name
     *
     * @param string $controller
     * @return void
     */
    public function setViewPath($controller)
    {
        $reflect    = new \ReflectionClass(new $controller);
        $controller = $reflect->getShortName();

        $this->viewPath = dirname(__FILE__) . '/' . strtolower(substr($controller, 0, strpos($controller, 'Controller')));
    }

    /**
     * Get full path of the given view file name
     * 
     * @param string $fileName
     */
    private function getViewFile($fileName)
    {
        $filePath = $this->viewPath . '/' . $fileName . '.php';

        if (!is_file($filePath)) {
            throw new \Exception('Unable to find view "' . $fileName .'".');
        }

        return $filePath;
    }
    
    /**
     * Set a template name
     *
     * @param string $template
     * @return void
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }
    
    /**
     * Get current template name
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }
    
    /**
     * Get file path of the given template name
     *
     * @param string $fileName
     * @return void
     */
    private function getTemplateFile($fileName)
    {
        $filePath = dirname(__FILE__) . '/template/' . $fileName . '.php';

        if (!is_file($filePath)) {
            throw new \Exception('Unable to find template "' . $fileName .'".');
        }

        return $filePath;
    }

    /**
     * Load a view file
     *
     * @param string $file
     * @param array $params
     * @param boolean $isTemplate
     * @return string
     */
    private function loadFile($file, $params, $isTemplate = false)
    {
        if ($isTemplate) {
            $filePath = $this->getTemplateFile($file);
        }
        else {
            $filePath = $this->getViewFile($file);
        }
        
        // Turn on output buffering
        ob_start();

        // Extract parameters array and map it into its corresponding variables
        extract($params, EXTR_OVERWRITE);

        // Include the target file
        require $filePath;

        // Buffering file content
        $output = ob_get_contents();

        // Cleaning output buffer and turn it off 
        ob_end_clean();

        return $output;
    }

    /**
     * Render a page view
     *
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render($view, $params = [])
    {
        $content = $this->loadFile($view, $params);
        
        return $this->loadFile($this->getTemplate(), ['content' => $content], true);
    }
}