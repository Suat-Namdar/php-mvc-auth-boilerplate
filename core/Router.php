<?php

namespace core;

require_once '../core/AutoLoader.php';

class Router
{
    public static function get($path = '/', $controller = '', $action = null)
    {
        return self::handle('GET', $path, $controller, $action);
    }

    public static function post($path = '/', $controller = '', $action = null)
    {
        return self::handle('POST', $path, $controller, $action);
    }

    public static function put($path = '/', $controller = '', $action = null)
    {
        if (!isset($_POST['_method'])) {
            return;
        }
        if ($_POST['_method'] != 'UPDATE') {
            return;
        }
        return self::handle('POST', $path, $controller, $action);
    }

    public static function delete($path = '/', $controller = '', $action = null)
    {
        if (!isset($_POST['_method'])) {
            return;
        }
        if ($_POST['_method'] != 'DELETE') {
            return;
        }
        return self::handle('POST', $path, $controller, $action);
    }

    public static function handle($method = 'GET', $path = '/', $controller = '', $action = null)
    {
        $currentMethod = $_SERVER['REQUEST_METHOD'];
        $currentUri = $_SERVER['REQUEST_URI'];
        $currentUri = parse_url($currentUri, PHP_URL_PATH);

        // Trailing slash normalization
        $currentUri = rtrim($currentUri, '/');
        $path = rtrim($path, '/');
        if ($currentUri === '')
            $currentUri = '/';
        if ($path === '')
            $path = '/';

        if ($currentMethod != $method) {
            return false;
        }
        $pattern = '#^' . preg_replace('/{([^\/]+)}/', '(?P<$1>\d+)', $path) . '$#siD';
        if (preg_match($pattern, $currentUri, $matches)) {
            if (is_callable($controller)) {
                $controller($matches);
            } else {
                $controller = '\\app\\controllers\\' . $controller;
                $controller = new $controller();
                $controller->$action($matches);
                exit;
            }
        }
    }
}
