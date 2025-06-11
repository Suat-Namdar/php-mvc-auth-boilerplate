<?php

namespace routes;

require_once '../core/Autoloader.php';

use core\Router;
use core\Debug;

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

Router::group('/isler', function() {
    Router::get('/', 'IslerController', 'index');
    Router::post('/', 'IslerController', 'create');
    Router::get('/{id}', 'IslerController', 'read');
    Router::put('/{id}', 'IslerController', 'update');
    Router::delete('/{id}', 'IslerController', 'delete');
});

Router::group('/alislar', function() {
    Router::get('/', 'AlislarController', 'index');
    Router::post('/', 'AlislarController', 'create');
    Router::get('/{id}', 'AlislarController', 'read');
    Router::put('/{id}', 'AlislarController', 'update');
    Router::delete('/{id}', 'AlislarController', 'delete');
});

include_once '../app/views/404.php';
Router::get('/404', function () {
    http_response_code(404);
    include '../app/views/404.php';
});
