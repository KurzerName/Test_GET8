<?php
// Т.к. я не умею ловить webhook на локальном сервере, то я сделал эмитацию

$webhook_message = json_encode(array(
    "hash"=> 1234,
    "name" => "Ivan",
    "family" => "Ivanov",
    "data" => [
        "key" => 123,
        "url" =>  "www.example.com",
        "img_name" => "foto.jpg"
    ],
    "update" => 1281120000
));

 // Возвращаем данные и статус