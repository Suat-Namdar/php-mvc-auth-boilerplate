<?php

namespace core;

require_once '../core/AutoLoader.php';

class Controller
{
    protected function view($filename = '', $data = [])
    {
        extract($data);
        require_once '../app/views/' . $filename . '.php';
    }

    protected function isAuthenticated()
    {
        return isset($_SESSION['user']);
    }

}