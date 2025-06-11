<?php

namespace core;

require_once '../core/AutoLoader.php';

class Debug
{
    public static function dd($data)
    {
        echo '<pre>';
        is_array($data) ? print_r($data) : var_dump($data);
        echo '</pre>';
        die();
    }

    public static function dump($data)
    {
        echo '<pre>';
        is_array($data) ? print_r($data) : var_dump($data);
        echo '</pre>';
    }

}