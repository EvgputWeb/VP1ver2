<?php
// Модуль для подключения к базе
// На выходе:  $dbh

// Файл с параметрами подключения
$config = require_once realpath(__DIR__ . '/../config.php');

foreach ($config['db'] as $key => $value) {
    ${$key} = $value;
}

try {
    // data source name
    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ];
    // Подключаемся к базе
    $dbh = new PDO($dsn, $user, $password, $opt);
    // Всё нормально - отдаём $dbh
    return $dbh;
} catch (PDOException $e) {
    return false;
}
