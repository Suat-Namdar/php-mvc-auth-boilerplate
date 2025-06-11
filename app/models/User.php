<?php

namespace app\models;

use core\Model;

class User extends Model
{
    protected string $table = 'users';

    public function getByEmail($email)
    {
        $result = $this->where(['email' => $email]);
        return $result ? $result[0] : null;
    }
}
