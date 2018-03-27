<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

mb_internal_encoding("UTF-8");
mb_regex_encoding("UTF-8");


define('ROOT', realpath(__DIR__ . '/..'));
define('APP', ROOT . '/app');

require_once ROOT . "/vendor/autoload.php";


// начинаем работать с сессией
session_start();


// создание БД
if ($_SERVER['REQUEST_URI'] == "/createdb") {
    require_once(ROOT . '/createdb.php');
    return;
}

// стартовая страница
if ($_SERVER['REQUEST_URI'] == "/") {
    require_once(__DIR__ . '/home.html');
    return;
}

// заказ
if ($_SERVER['REQUEST_URI'] == "/order") {
    require_once(APP . '/order.php');
    return;
}

// админ-панель
if ($_SERVER['REQUEST_URI'] == "/admin") {
    require_once(APP . '/admin.php');
    return;
}

// обработка ошибок
if (strpos($_SERVER['REQUEST_URI'], 'errcode') > 0) {
    require_once(APP . '/error.php');
    return;
}

// такой страницы нет
header("HTTP/1.0 404 Not Found");
