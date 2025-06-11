<?php

namespace core;

require_once '../core/AutoLoader.php';

use PDO;
use utils\DBConnection;

class Model
{
    protected PDO $pdo;
    protected string $table;

    public function __construct()
    {
        $this->pdo = DBConnection::getInstance()->getPdo();
    }

    public function all()
    {
        $sql = "SELECT * FROM {$this->table}";
        $prepare = $this->pdo->prepare($sql);
        $prepare->execute();
        $result = $prepare->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function find(int $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $prepare = $this->pdo->prepare($sql);
        $prepare->bindParam(':id', $id, PDO::PARAM_INT);
        $prepare->execute();
        $result = $prepare->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function create($data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $prepare = $this->pdo->prepare($sql);
        $i = 1;
        foreach ($data as $value) {
            $prepare->bindValue($i, $value);
            $i++;
        }
        $prepare->execute();
        return true;
    }

    public function update(array $data, int $id)
    {
        $updateSql = implode(", ", array_map(fn($key) => "$key = ?", array_keys($data)));
        $sql = "UPDATE {$this->table} SET {$updateSql} WHERE id = ?";
        $prepare = $this->pdo->prepare($sql);
        $i = 1;
        foreach ($data as $value) {
            $prepare->bindValue($i, $value);
            $i++;
        }
        $prepare->bindValue($i, $id, PDO::PARAM_INT);
        $prepare->execute();
        return true;
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $prepare = $this->pdo->prepare($sql);
        $prepare->bindParam(':id', $id, PDO::PARAM_INT);
        $prepare->execute();
        return true;
    }

    public function where(array $conditions)
    {
        $whereConditions = [];
        foreach ($conditions as $column => $value) {
            $whereConditions[] = "$column = ?";
        }
        $whereClause = implode(" AND ", $whereConditions);
        $sql = "SELECT * FROM {$this->table} WHERE $whereClause";
        $prepare = $this->pdo->prepare($sql);
        $prepare->execute(array_values($conditions));
        $result = $prepare->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function count()
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";
        $stmt = $this->pdo->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    public function paginate($perPage = 10, $currentPage = 1)
    {
        $offset = ($currentPage - 1) * $perPage;
        $sql = "SELECT * FROM {$this->table} LIMIT :perPage OFFSET :offset";
        $prepare = $this->pdo->prepare($sql);
        $prepare->bindParam(':perPage', $perPage, PDO::PARAM_INT);
        $prepare->bindParam(':offset', $offset, PDO::PARAM_INT);
        $prepare->execute();
        $result = $prepare->fetchAll(PDO::FETCH_OBJ);
        $totalRows = $this->count();
        $totalPages = ceil($totalRows / $perPage);
        return [
            'data' => $result,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage
        ];
    }

    public function query(string $sql, array $params = [])
    {
        $prepare = $this->pdo->prepare($sql);
        $prepare->execute($params);
        return $prepare->fetchAll(PDO::FETCH_OBJ);
    }
}