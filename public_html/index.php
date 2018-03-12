<?php
// начинаем работать с сессией
session_start();

$upDir = realpath(__DIR__ . '/..');
$appDir = $upDir . '/app';

// создание БД
if ($_SERVER['REQUEST_URI'] == "/createdb") {
    require_once($upDir . '/createdb.php');
    return;
}

// стартовая страница
if ($_SERVER['REQUEST_URI'] == "/") {
    require_once(__DIR__ . '/home.html');
    return;
}

// заказ
if ($_SERVER['REQUEST_URI'] == "/order") {
    require_once($appDir . '/order.php');
    return;
}

// админ
if ($_SERVER['REQUEST_URI'] == "/admin") {
    require_once($appDir . '/admin.php');
    return;
}

// обработка ошибок
if (strpos($_SERVER['REQUEST_URI'], 'errcode') > 0) {
    require_once($appDir . '/error.php');
    return;
}

// такой страницы нет
header("HTTP/1.0 404 Not Found");
