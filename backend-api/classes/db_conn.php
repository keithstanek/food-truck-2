<?php
require(__DIR__ . '/../config/config.php');

class Database {
    private $pdo;
    public function __construct() {
        $host = Constants::$DB_HOST;
        $dbname = Constants::$DB_NAME;
        $user = Constants::$DB_USER;
        $pass = Constants::$DB_PASS;

        $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function getConnection() {
        return $this->pdo;
    }
}