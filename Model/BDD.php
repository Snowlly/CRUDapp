<?php

try {
    $password = "";
    $bdd = new PDO('mysql:host=localhost;dbname=TrovaJob;charset=utf8;', 'root', $password, array(PDO::ATTR_PERSISTENT => true));
} catch (PDOException $e) {
    die($e->getMessage());
}

?>
