<?php

namespace app\core;

use app\database\Database;

class BaseModel
{
    protected Database $db;

    public function __construct(){
        $this->db = Database::getInstance();
    }
}