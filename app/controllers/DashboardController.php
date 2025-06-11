<?php

namespace app\controllers;

use core\Controller;
use app\models\Product;

class DashboardController extends Controller
{
    public function __construct()
    {
        if (!$this->isAuthenticated()) {
            header('Location: /');
            exit;
        }
    }

    public function index()
    {
        $products = new Product();
        $products = $products->count();
        $this->view('pages/dashboard', [
            'products' => $products
        ]);
    }
}