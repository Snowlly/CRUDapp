<?php

class BDD {
    protected $pdo;

    public function __construct() {
        try {
            $password = "";
            $this->pdo = new PDO(
                'mysql:host=localhost;dbname=CRUDapp;charset=utf8;',
                'root',
                $password,
                array(PDO::ATTR_PERSISTENT => true)
            );
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
