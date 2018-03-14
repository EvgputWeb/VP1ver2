<?php

// Функция для формирования адреса в удобочитаемом виде
function makeBeautyAddress($street, $home, $part, $appt, $floor)
{
    $addrPart = ['street', 'home', 'part', 'appt', 'floor'];
    $addrPrefix = ['ул. ', 'д. ', 'корп. ', 'кв. ', 'этаж '];
    $address = '';
    for ($i = 0; $i < count($addrPart); $i++) {
        if (!empty(${$addrPart[$i]})) {
            $address .= $addrPrefix[$i] . ${$addrPart[$i]} . ', ';
        }
    }
    $address = trim($address); // удаляем пробелы вначале и в конце строки
    if (mb_strlen($address) > 1) {
        $lastChar = mb_substr($address, -1, 1); // последний символ строки
        if ($lastChar == ',') {
            $address = mb_substr($address, 0, mb_strlen($address) - 1);
        }
    }
    return $address;
}

// Функция для получения номера заказа указанного пользователя
// Возвращает строку. Например: "первый", "12-й"
function getOrderNumber(PDO $dbh, $userId)
{
    try {
        $sth = $dbh->prepare('SELECT count(*) AS count FROM orders WHERE user_id = :userId');
        $sth->execute(array('userId' => $userId));
        $count = $sth->fetchColumn();
    } catch (PDOException $e) {
        return null;
    }
    if ($count == 1) {
        return "первый";
    } else {
        return "$count-й";
    }
}
