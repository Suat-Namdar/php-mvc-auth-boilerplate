<?php

namespace app\controllers;

require_once '../core/AutoLoader.php';

use core\Debug;
use core\Flasher;
use core\Controller;
use app\models\AlisView;
use app\models\AlisSave;

class AlislarController extends Controller
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
        $alislar = new AlisView();
        $datalar = $alislar->all(); // alislar tablosundaki tüm verileri al
        $this->view('pages/alislar/index', [
            'datalar' => $datalar,
            'title' => 'Alış Listesi',
        ]);
    }

    public function create()
    {
        try {
            // $this->validateFormData($_POST, $_FILES);
            // $filepath = $this->processThumbnail($_FILES['thumbnail']);

            $fields = $_POST;
            unset($fields['_method']); // method spoofing için eklenen alanı çıkar
            unset($fields['id']); // id alanını güncelleme işleminde kullanmamak için çıkar
            $datalar = new AlisSave(); // alislar tablosuna veri eklemek için setTable metodunu kullan
            $datalar->create($fields);

            Flasher::setFlash('success', 'Alis created successfully.');
            header('Location: /alislar');
            exit;
        } catch (\Throwable $th) {
            Flasher::setFlash('error', $th->getMessage());
            header('Location: /alislar');
            exit;
        }
    }

    public function update($data)
    {
        try {
            // $this->validateFormData($_POST, $_FILES);
            $fields = $_POST;
            unset($fields['_method']); // method spoofing için eklenen alanı çıkar
            unset($fields['id']); // id alanını güncelleme işleminde kullanmamak için çıkar
            $datalar = new AlisSave();
            $datalar->update($fields, $data['id']);
            Flasher::setFlash('success', 'Alis updated successfully.');
            header('Location: /alislar');
            // header('Location: /alislar/' . $data['id']);
            exit;
        } catch (\Throwable $th) {
            Flasher::setFlash('error', $th->getMessage());
            header('Location: /alislar/' . $data['id']);
            exit;
        }
    }
    public function delete($data)
    {
        $fields = $_POST;
        unset($fields['_method']); // method spoofing için eklenen alanı çıkar
        unset($fields['id']); // id alanını güncelleme işleminde kullanmamak için çıkar
        $datalar = new AlisSave();
        $datalar->delete($data['id']);

        Flasher::setFlash('success', 'Alis deleted successfully.');
        header('Location: /alislar');
        exit;
    }
    private function validateFormData($postData, $filesData)
    {
        if (!is_numeric($postData['fiyat'])) {
            throw new \Exception("Fiyat must be a number.", 400);
        }
    }

}
