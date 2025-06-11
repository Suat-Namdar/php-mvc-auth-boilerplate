<?php

namespace app\controllers;

use core\Flasher;
use core\Controller;
use core\Pagination;
use app\models\Product;

class ProductController extends Controller
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
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $itemsPerPage = 10;
        $products = $products->paginate($itemsPerPage, $currentPage);
        $pagination = new Pagination($products['currentPage'], $products['totalPages'], $itemsPerPage);
        $this->view('pages/products/index', [
            'products' => $products,
            'pagination' => $pagination->render()
        ]);
    }
    public function show($data)
    {
        $product = new Product();
        $product = $product->find($data['id']);
        $this->view('pages/products/show', [
            'product' => $product
        ]);
    }
    public function store()
    {
        try {
            $this->validateFormData($_POST, $_FILES);

            $filepath = $this->processThumbnail($_FILES['thumbnail']);

            $product = new Product();
            $product->create([
                'name' => $_POST['name'],
                'thumbnail' => $filepath,
                'price' => $_POST['price'],
                'description' => $_POST['description']
            ]);

            Flasher::setFlash('success', 'Product created successfully.');
            header('Location: /products');
            exit;
        } catch (\Throwable $th) {
            Flasher::setFlash('error', $th->getMessage());
            header('Location: /products');
            exit;
        }
    }
    public function update($data)
    {
        try {
            $this->validateFormData($_POST, $_FILES);

            $filepath = $this->processThumbnail($_FILES['thumbnail'], $data['id']);

            $product = new Product();
            $product->update([
                'name' => $_POST['name'],
                'thumbnail' => $filepath,
                'price' => $_POST['price'],
                'description' => $_POST['description']
            ], $data['id']);

            Flasher::setFlash('success', 'Product updated successfully.');
            header('Location: /products/' . $data['id']);
            exit;
        } catch (\Throwable $th) {
            Flasher::setFlash('error', $th->getMessage());
            header('Location: /products/' . $data['id']);
            exit;
        }
    }
    public function destroy($data)
    {
        $product = new Product();
        $product = $product->delete($data['id']);
        Flasher::setFlash('success', 'Product deleted successfully.');
        header('Location: /products');
        exit;
    }
    private function validateFormData($postData, $filesData)
    {
        if (!is_numeric($postData['price'])) {
            throw new \Exception("Price must be a number.", 400);
        }

        $allowedTypes = ['image/jpg', 'image/png', 'image/jpeg'];
        $maxFileSize = 2 * 1024 * 1024;

        if (!isset($filesData['thumbnail']) || !in_array($filesData['thumbnail']['type'], $allowedTypes)) {
            throw new \Exception('Thumbnail must be an image (jpg, png, jpeg).', 400);
        }

        if ($filesData['thumbnail']['size'] > $maxFileSize) {
            throw new \Exception('Thumbnail size must be less than 2MB.', 400);
        }
    }
    private function processThumbnail($thumbnail, $id = null)
    {
        $ext = pathinfo($thumbnail['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;

        $targetDir = 'images/products/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $filepath = $targetDir . $filename;

        if (!move_uploaded_file($thumbnail['tmp_name'], $filepath)) {
            throw new \Exception('Failed to move uploaded file.');
        }

        if ($id) {
            $product = new Product();
            $existingProduct = $product->find($id);
            if ($existingProduct && $existingProduct->thumbnail && $existingProduct->thumbnail !== $filepath) {
                unlink($existingProduct->thumbnail);
            }
        }

        return $filepath;
    }
}