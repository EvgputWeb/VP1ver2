<?php

// Подключаем полезные функции
require_once 'utils.php';

// Создаём папку для писем, если её нет
$emailsFolder = __DIR__ . DIRECTORY_SEPARATOR . '_emails_';
if (!file_exists($emailsFolder)) {
    try {
        mkdir($emailsFolder, 0777);
    } catch (ErrorException $e) {
        return null;
    }
}

// Файл для сохранения текста письма
$emailFileName = $emailsFolder . DIRECTORY_SEPARATOR . date('Y-m-d__H-i-s') . '.txt';

// Получаем адрес и номер заказа данного пользователя
$userAddress = makeBeautyAddress($_REQUEST['street'], $_REQUEST['home'], $_REQUEST['part'], $_REQUEST['appt'], $_REQUEST['floor']);
$userOrderNum = getOrderNumber($dbh, $userId);

// Текст письма
$mailText = "Заказ № $orderId\n\n";
$mailText .= "Ваш заказ будет доставлен по адресу:\n";
$mailText .= $userAddress . "\n\n";
$mailText .= "Содержимое заказа:\n";
$mailText .= "DarkBeefBurger за 500 рублей, 1 шт\n\n";
$mailText .= "Спасибо!\n";
$mailText .= "Это Ваш " . $userOrderNum . " заказ!\n";

// Пишем в файл
try {
    file_put_contents($emailFileName, $mailText);
} catch (ErrorException $e) {
    return null;
}

// Всё прошло успешно
return true;
