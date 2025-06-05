<?php

namespace app\controllers;

require_once '../core/Autoloader.php';

use core\Flasher;
use core\Controller;
use core\Pagination;
use app\models\Isler;

class IslerController extends Controller
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
        $isler = new Isler();
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $itemsPerPage = 10;
        $isler = $isler->paginate($itemsPerPage, $currentPage);
        $pagination = new Pagination($isler['currentPage'], $isler['totalPages'], $itemsPerPage);
        $this->view('pages/isler/index', [
            'isler' => $isler,
            'pagination' => $pagination->render()
        ]);
    }
    public function show($data)
    {
        $is = new Isler();
        $is = $is->find($data['id']);
        $this->view('pages/isler/show', [
            'is' => $is
        ]);
    }
    public function store()
    {
        try {
            $this->validateFormData($_POST, $_FILES);

            // $filepath = $this->processThumbnail($_FILES['thumbnail']);

            $is = new Isler();
            $is->create([
                'tarih' => $_POST['tarih'],
                'arac_id' => $_POST['arac_id'],
                'yukleme_yeri' => $_POST['yukleme_yeri'],
                'bosaltma_yeri' => $_POST['bosaltma_yeri'],
                'fiyat' => $_POST['fiyat'],
                'durum' => $_POST['durum'],
                'fatura_firma' => $_POST['fatura_firma'],
                'fatura_no' => $_POST['fatura_no'],
                'fatura_tarihi' => $_POST['fatura_tarihi'],
                'odeme_tarihi' => $_POST['odeme_tarihi']
            ]);

            Flasher::setFlash('success', 'Is created successfully.');
            header('Location: /isler');
            exit;
        } catch (\Throwable $th) {
            Flasher::setFlash('error', $th->getMessage());
            header('Location: /isler');
            exit;
        }
    }
    public function update($data)
    {
        try {
            $this->validateFormData($_POST, $_FILES);

            $is = new Isler();
            $is->update([
                'tarih' => $_POST['tarih'],
                'arac_id' => $_POST['arac_id'],
                'yukleme_yeri' => $_POST['yukleme_yeri'],
                'bosaltma_yeri' => $_POST['bosaltma_yeri'],
                'fiyat' => $_POST['fiyat'],
                'durum' => $_POST['durum'],
                'fatura_firma' => $_POST['fatura_firma'],
                'fatura_no' => $_POST['fatura_no'],
                'fatura_tarihi' => $_POST['fatura_tarihi'],
                'odeme_tarihi' => $_POST['odeme_tarihi']
            ], $data['id']);

            Flasher::setFlash('success', 'Is updated successfully.');
            header('Location: /isler/' . $data['id']);
            exit;
        } catch (\Throwable $th) {
            Flasher::setFlash('error', $th->getMessage());
            header('Location: /isler/' . $data['id']);
            exit;
        }
    }
    public function destroy($data)
    {
        $is = new Isler();
        $is = $is->delete($data['id']);
        Flasher::setFlash('success', 'Is deleted successfully.');
        header('Location: /isler');
        exit;
    }
    private function validateFormData($postData, $filesData)
    {
        if (!is_numeric($postData['fiyat'])) {
            throw new \Exception("Fiyat must be a number.", 400);
        }
    }
    
}
