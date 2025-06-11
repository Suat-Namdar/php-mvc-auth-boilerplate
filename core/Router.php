<?php

namespace core;

require_once '../core/AutoLoader.php';

class Router
{
    public static $groupPrefix = '';

    public function __construct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method'])) {
            $_SERVER['REQUEST_METHOD'] = strtoupper($_POST['_method']);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_POST['_method'])) {
            $_SERVER['REQUEST_METHOD'] = strtoupper($_POST['_method']);
        }
    }

    public static function group($prefix, $callback)
    {
        $previousPrefix = self::$groupPrefix;
        self::$groupPrefix .= rtrim($prefix, '/');
        $callback();
        self::$groupPrefix = $previousPrefix;
    }

    public static function get($path = '/', $controller = '', $action = null)
    {
        $uri = self::buildUri($path);
        return self::handle('GET', $uri, $controller, $action);
    }

    public static function post($path = '/', $controller = '', $action = null)
    {
        $uri = self::buildUri($path);
        return self::handle('POST', $uri, $controller, $action);
    }

    public static function put($path = '/', $controller = '', $action = null)
    {
        $uri = self::buildUri($path);
        if (!isset($_POST['_method'])) {
            return;
        }
        if ($_POST['_method'] != 'UPDATE' && $_POST['_method'] != 'PUT') {
            return;
        }
        return self::handle('POST', $uri, $controller, $action);
    }

    public static function delete($path = '/', $controller = '', $action = null)
    {
        $uri = self::buildUri($path);
        if (!isset($_POST['_method'])) {
            return;
        }
        if ($_POST['_method'] != 'DELETE') {
            return;
        }
        return self::handle('POST', $uri, $controller, $action);
    }

    private static function buildUri($path)
    {
        $prefix = self::$groupPrefix;
        // Eğer path boşsa sadece prefix döndür
        if ($path === '/' || $path === '') {
            return $prefix ?: '/';
        }
        // Eğer prefix yoksa path döndür
        if (!$prefix) {
            return $path;
        }
        // Her iki tarafın da slash'larını düzgünleştir
        return rtrim($prefix, '/') . (substr($path, 0, 1) === '/' ? $path : '/' . $path);
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
