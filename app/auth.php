<?php

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
