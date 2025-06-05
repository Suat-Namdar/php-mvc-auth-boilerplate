<?php

namespace routes;

require_once '../core/Autoloader.php';
use core\Router;

Router::get('/', function () {
    if (isset($_SESSION['user'])) {
        header('Location: /dashboard');
        exit;
    }
    include '../app/views/welcome.php';
});
Router::post('/login', 'AuthController', 'login');
Router::get('/logout', 'AuthController', 'logout');
Router::get('/dashboard', 'DashboardController', 'index');

Router::get('/products', 'ProductController', 'index');
Router::post('/products', 'ProductController', 'store');
Router::get('/products/{id}', 'ProductController', 'show');
Router::put('/products/{id}', 'ProductController', 'update');
Router::delete('/products/{id}', 'ProductController', 'destroy');

Router::get('/isler', 'IslerController', 'index');
Router::post('/isler', 'IslerController', 'store');
Router::get('/isler/{id}', 'IslerController', 'show');
Router::put('/isler/{id}', 'IslerController', 'update');
Router::delete('/isler/{id}', 'IslerController', 'destroy');

include_once '../app/views/404.php';
Router::get('/404', function () {
    http_response_code(404);
    include '../app/views/404.php';
});
