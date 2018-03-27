<?php

use ReCaptcha\ReCaptcha;


// Проверяем сначала прохождение капчи
if (key_exists('g_recaptcha_response', $_REQUEST)) {
    $remoteIp = $_SERVER['REMOTE_ADDR'];
    $recaptcha = new ReCaptcha('6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe');
    $resp = $recaptcha->verify($_REQUEST['g_recaptcha_response'], $remoteIp);
    if (!$resp->isSuccess()) {
        return null;
    }
} else {
    return null;
}
// Капча пройдена

$email = $_REQUEST['email'];

// Ищем пользователя по email
try {
    $sth = $dbh->prepare('SELECT id FROM users WHERE email = :email');
    $sth->execute(array('email' => $email));
    $userId = $sth->fetchColumn();
} catch (PDOException $e) {
    return null;
}

if ($userId === false) {
    // Нет такого пользователя. Создаём.
    try {
        $sth = $dbh->prepare("INSERT INTO users(name, email, phone) VALUES (:fname, :femail, :fphone)");
        $sth->execute(array(
            "fname" => $_REQUEST['name'],
            "femail" => $_REQUEST['email'],
            "fphone" => $_REQUEST['phone']
        ));
        $userId = $dbh->lastInsertId();
    } catch (PDOException $e) {
        return null;
    }
}

return $userId;
