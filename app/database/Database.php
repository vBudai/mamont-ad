<?php

namespace app\database;

use mysql_xdevapi\Exception;
use PDO;
use PDOException;
use Symfony\Component\Dotenv\Dotenv;

class Database
{
    private static ?Database $instance = null;

    private PDO $conn; // Connection

    public static function getInstance(): ?Database
    {
        if(self::$instance === null){
            self::$instance = new self();
        }

        return self::$instance;
    }

    // Подключение к бд
    private function __construct() {
        $dotenv = new Dotenv();
        if(file_exists(__DIR__ . '../../config/.env')){
            $dotenv->load(__DIR__ . '../../config/.env');
        }

        try{
            $this->conn = new PDO(
                "mysql:host=$_ENV[DB_ADDRESS];
                dbname=$_ENV[DB_NAME]",
                $_ENV['DB_LOGIN'],
                $_ENV['DB_PASSWORD']);

        } catch (PDOException $e){
            echo 'Ошибка подключения к БД: ' . $e->getMessage() . '<br>';
        }
    }

    private function __clone(){}

    //Проверка выполнения запроса к бд
    private function dbCheckError($query): void
    {
        $errInfo = $query->errorInfo();
        if($errInfo[0] !== PDO::ERR_NONE){
            echo $errInfo[2];
            exit();
        }
    }

    public function query($sql) : array|null
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $this->dbCheckError($stmt);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function lastInsertId($table): bool|string
    {
        return $this->conn->lastInsertId($table);
    }
}