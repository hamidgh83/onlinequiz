<?php

namespace Service;

abstract class AbstractSession 
{
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    public function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }
    
    public function has($key)
    {
        return isset($_SESSION[$key]) ? true : false;
    }
    
    public function clear($key = null)
    {
        if ($key) {
            unset($_SESSION[$key]);
        }
        else {
            $_SESSION = [];
        }
    }
}
