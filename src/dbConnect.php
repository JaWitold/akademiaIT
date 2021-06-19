<?php
$data = require_once "dbConfig.php";

global $db;

try {
    $db = new PDO('mysql:host=' . $data["host"] . '; dbname=' . $data["db_name"],
        $data["login"],
        $data["password"],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]);

} catch (PDOException $e) {
    //exit($e->getMessage());
    //throw $e;
    throw new Exception("Internal Error - try again later");
}
