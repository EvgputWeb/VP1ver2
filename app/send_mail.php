<?php

use PHPMailer\PHPMailer\PHPMailer;

// Подключаем полезные функции
require_once 'utils.php';


// Получаем адрес и номер заказа данного пользователя
$userAddress = makeBeautyAddress($_REQUEST['street'], $_REQUEST['home'], $_REQUEST['part'], $_REQUEST['appt'], $_REQUEST['floor']);
$userOrderNum = getOrderNumber($dbh, $userId);


// Текст письма
$mailText = "Спасибо за заказ!<br><br>\n\n";
$mailText .= "Ваш заказ будет доставлен по адресу:<br>\n";
$mailText .= "<b>" . $userAddress . "</b><br><br>\n\n";
$mailText .= "Содержимое заказа:<br>\n";
$mailText .= "<b>DarkBeefBurger за 500 рублей, 1 шт</b><br><br>\n\n";
$mailText .= "Спасибо!<br>\n";
$mailText .= "Это Ваш " . $userOrderNum . " заказ!<br>\n";


$mail = new PHPMailer;
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->Host = "smtp.mailtrap.io";
$mail->Username = 'c25748876498c6';
$mail->Password = 'db1cb931cdfe56';
$mail->Port = 2525;
$mail->setFrom('from@mailtrap.com', 'E-mail с сайта');
$mail->addAddress($_REQUEST['email'], 'Получатель');     // Add a recipient
$mail->addReplyTo('from@mailtrap.com', 'Robot');
$mail->CharSet = 'UTF-8';
$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = 'Письмо от Бургерной: заказ №' . $orderId . ' от ' . date('d.m.Y H:i', time());
$mail->Body = $mailText;
$mail->AltBody = strip_tags($mailText);
if (!$mail->send()) {
    return null;
}

// Всё прошло успешно
return true;




/*
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
*/
