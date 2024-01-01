<?php
class App
{
    private $__controller, $__action, $__params, $__routes;
    function __construct()
    {
        global $routes;
        $this->__controller = 'HomeController';
        $this->__action = 'index';
        $this->__params = [];
        $this->__routes = new Route();
        $this->handleURL();
    }
    function getURL()
    {
        if (!empty($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        } else {
            $url = '/';
        }
        return $url;
    }
    function handleURL()
    {
        $url = $this->getURL();
        $url = $this->__routes->handleRoute($url);
        $path = '';
        $urlArr = array_values(array_filter(explode('/', $url)));
        if (count($urlArr) >= 2) {
            foreach ($urlArr as $key => $value) {
                $path .= '/' . $value;
                unset($urlArr[$key]);
                if (file_exists(_DIR_ROOT . '/app/controllers' . $path . '.php')) {
                    $path = trim($path, $value);
                    $this->__controller = $value;
                    $urlArr = array_values($urlArr);
                    break;
                }
                if (empty($urlArr)) {
                    return $this->loadError();
                }
            }
        } else {
            if (!empty($urlArr[0])) {
                $this->__controller = $urlArr[0];
                unset($urlArr[0]);
                $urlArr = array_values($urlArr);
            }
        }
        if (!empty($urlArr[0])) {
            $this->__action = $urlArr[0];
            unset($urlArr[0]);
            $this->__params = $urlArr;
        }
        if (empty($path)) {
            $path = '/';
        }
        if (file_exists(_DIR_ROOT . '/app/controllers/' . $path . $this->__controller . '.php')) {
            require_once 'app/controllers/' . $path . $this->__controller . '.php';
            $this->__controller = new $this->__controller();
            if (method_exists($this->__controller, $this->__action)) {
                call_user_func_array([$this->__controller, $this->__action], $this->__params);
            } else {
                return $this->loadError();
            }
        } else {
            return $this->loadError();
        }
    }
    function loadError($name = '404')
    {
        if (file_exists(_DIR_ROOT . '/app/errors/' . $name . '.php')) {
            require_once _DIR_ROOT . '/app/errors/' . $name . '.php';
        }
    }
}
