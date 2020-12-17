<?php
// Я использовал mysql
// название базы данных - GET-8
// в нём таблицы:
// hash int(15) index
// name text 
// family text
// update_date int(25)
// data json

$driver = "mysql";
$host = "localhost";
$dbname = "get-8";
$user = "root";
$pass = "";
$charset = "utf-8";
$option = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];


try{

    $pdo = new PDO("$driver:host = $host;dbname=$dbname;charset = $charset", $user, $pass, $option);

}catch(PDOException $e){
    die($e);
}