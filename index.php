<?php

use app\core\Router;
use app\database\Database;

require_once "app/config/BASE_URL.php";

session_start();

require __DIR__.'./vendor/autoload.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$route = Router::getInstance();
$route->parse();

//$db = Database::getInstance();