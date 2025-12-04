<?php
class EnterpriseModel extends BDD {

    public function __construct() {
        parent::__construct();
    }

    public function search(?string $query) {

    // 🟦 CAS 1 : aucune recherche → on affiche juste 50 entreprises
    if (!$query) {
        $sql = "
            SELECT  e.EnterpriseNumber,
                    e.Status,
                    e.JuridicalForm,
                    d.Denomination,
                    a.NaceCode,
                    addr.MunicipalityFR
            FROM enterprise e
            LEFT JOIN denomination d
                ON d.EntityNumber = e.EnterpriseNumber
                AND d.TypeOfDenomination = '001'
            LEFT JOIN activity a
                ON a.EntityNumber = e.EnterpriseNumber
                AND a.Classification = 'MAIN'
            LEFT JOIN address addr
                ON addr.EntityNumber = e.EnterpriseNumber
            LIMIT 3
        ";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🟦 CAS 2 : il y a une recherche → on filtre avec LIKE
    $sql = "
        SELECT  DISTINCT
                e.EnterpriseNumber,
                e.Status,
                e.JuridicalForm,
                d.Denomination,
                a.NaceCode,
                addr.MunicipalityFR
        FROM enterprise e
        LEFT JOIN denomination d
            ON d.EntityNumber = e.EnterpriseNumber
            AND d.TypeOfDenomination = '001'
        LEFT JOIN activity a
            ON a.EntityNumber = e.EnterpriseNumber
            AND a.Classification = 'MAIN'
        LEFT JOIN address addr
            ON addr.EntityNumber = e.EnterpriseNumber
        WHERE e.EnterpriseNumber LIKE :q
           OR d.Denomination LIKE :q
        LIMIT 10
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['q' => "%$query%"]);   // 👉 ici on utilise bien $query

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    public function getById($entityNumber) {
        $req = $this->pdo->prepare("SELECT * FROM enterprise WHERE EnterpriseNumber = ?");
        $req->execute([$entityNumber]);
        return $req->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $req = $this->pdo->prepare("
            INSERT INTO enterprise (EnterpriseNumber, Status, JuridicalSituation, TypeOfEnterprise, JuridicalForm, StartDate)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        return $req->execute([
            $data['EnterpriseNumber'],
            $data['Status'],
            $data['JuridicalSituation'],
            $data['TypeOfEnterprise'],
            $data['JuridicalForm'],
            $data['StartDate']
        ]);
    }

    public function update($entityNumber, $data) {
        $req = $this->pdo->prepare("
            UPDATE enterprise SET
            Status=?, JuridicalSituation=?, TypeOfEnterprise=?, JuridicalForm=?, StartDate=?
            WHERE EnterpriseNumber=?
        ");

        return $req->execute([
            $data['Status'],
            $data['JuridicalSituation'],
            $data['TypeOfEnterprise'],
            $data['JuridicalForm'],
            $data['StartDate'],
            $entityNumber
        ]);
    }

    public function delete($entityNumber) {
        $req = $this->pdo->prepare("DELETE FROM enterprise WHERE EnterpriseNumber=?");
        return $req->execute([$entityNumber]);
    }

    public function getDenominations(string $id) {
        $stmt = $this->pdo->prepare("SELECT * FROM denomination WHERE EntityNumber = ? ORDER BY TypeOfDenomination");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAddresses(string $id) {
        $stmt = $this->pdo->prepare("SELECT * FROM address WHERE EntityNumber = ?");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActivities(string $id) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM activity 
            WHERE EntityNumber = ? 
            ORDER BY (Classification = 'MAIN') DESC
        ");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEstablishments(string $id) {
        $stmt = $this->pdo->prepare("SELECT * FROM establishment WHERE EnterpriseNumber = ?");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>