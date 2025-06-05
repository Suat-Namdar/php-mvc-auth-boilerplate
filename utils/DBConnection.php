<?php

namespace utils;

use PDO;
use PDOException;

class DBConnection
{
    private PDO $pdo;
    private static ?DBConnection $dbConnection = null;

    private function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=_mvc_boilerplate", 'root', '');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!self::$dbConnection) {
            self::$dbConnection = new DBConnection();
        }

        return self::$dbConnection;
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}