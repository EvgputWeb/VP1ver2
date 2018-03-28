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

$smtp = [
    'host' => "smtp.mail.ru",
    'username' => 'evgputweb_loftschool@mail.ru',
    'password' => 'loftschool_evgputweb',
    'secure' => 'ssl',
    'port' => 465,
    'mail_from' => 'evgputweb_loftschool@mail.ru'
];

$mail = new PHPMailer;
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->Host = $smtp['host'];
$mail->Username = $smtp['username'];
$mail->Password = $smtp['password'];
$mail->SMTPSecure = $smtp['secure'];
$mail->Port = $smtp['port'];
$mail->setFrom($smtp['mail_from'], 'E-mail с сайта');
$mail->addAddress($_REQUEST['email'], 'Получатель');
$mail->addReplyTo($smtp['mail_from'], 'Robot');
$mail->CharSet = 'UTF-8';
$mail->isHTML(true);
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
