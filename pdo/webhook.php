<?php
// Т.к. я не умею ловить webhook на локальном сервере, то я сделал эмитацию

$userInfo = file_get_contents("./webhook.json"); // Это был выполнен запрос
$userInfo = json_decode($userInfo, true);
// Возвращаем данные