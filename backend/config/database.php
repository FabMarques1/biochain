<?php

require_once realpath(__DIR__ . "/../../vendor/autoload.php");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->safeLoad();

try{
    $host = $_ENV['DB_HOST'];
    $user = $_ENV['DB_USER'];
    $pass = $_ENV['DB_PASS'];
    $db = $_ENV['DB_NAME'];

    $conn = new mysqli($host, $user, $pass, $db);

} catch (Exception $e){
    echo "Erro na conexão com o banco: " . $e->getMessage();
}

?>