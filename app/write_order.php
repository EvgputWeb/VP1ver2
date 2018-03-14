<?php

((!empty($_REQUEST['payment'])) && ($_REQUEST['payment'] == 'card')) ? ($payment = 1) : ($payment = 0);
((!empty($_REQUEST['callback'])) && ($_REQUEST['callback'] == 'on')) ? ($callback = 1) : ($callback = 0);

$sql = "INSERT INTO orders" .
    "(user_id, street, home, part, appt, floor, comment, payment, callback) " .
    "VALUES " .
    "(:fuser_id, :fstreet, :fhome, :fpart, :fappt, :ffloor, :fcomment, :fpayment, :fcallback)";

try {
    $sth = $dbh->prepare($sql);
    $sth->execute(array(
        "fuser_id" => $userId,
        "fstreet" => $_REQUEST['street'],
        "fhome" => $_REQUEST['home'],
        "fpart" => $_REQUEST['part'],
        "fappt" => $_REQUEST['appt'],
        "ffloor" => $_REQUEST['floor'],
        "fcomment" => $_REQUEST['comment'],
        "fpayment" => $payment,
        "fcallback" => $callback
    ));
    $orderId = $dbh->lastInsertId();
} catch (PDOException $e) {
    return null;
}

return $orderId;
