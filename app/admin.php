<?php

// Подключаемся к базе
$dbh = require_once 'dbconnect.php';
if ($dbh === false) {
    header("Location: /?errcode=4002");
    return;
}

// Получаем данные из базы
try {
    // Пользователи:
    $sth_users = $dbh->query('SELECT * FROM users ORDER BY id');
} catch (PDOException $e) {
    header("Location: /?errcode=4003");
    return;
}
try {
    // Заказы:
    $sql = 'SELECT orders.*, users.name as username FROM orders,users WHERE orders.user_id=users.id ORDER BY orders.id';
    $sth_orders = $dbh->query($sql);
} catch (PDOException $e) {
    header("Location: /?errcode=4004");
    return;
}

// Отображаем данные: в admin_view идёт работа только с $sth_users и $sth_orders
require_once 'admin_view.php';
