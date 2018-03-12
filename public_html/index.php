<?php
// начинаем работать с сессией
session_start();

$appDir = realpath(__DIR__ . '/../app');


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

// такой страницы нет
header("HTTP/1.0 404 Not Found");
