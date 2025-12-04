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

    $errors = [];

    if (empty($data['EnterpriseNumber'])) {
        $errors[] = "Le numéro d'entreprise est obligatoire.";
    }

    if (empty($data['Denomination'])) {
        $errors[] = "Le nom de l'entreprise est obligatoire.";
    }

    if (empty($data['Status'])) {
        $errors[] = "Le statut est obligatoire.";
    }

    if (!empty($errors)) {
        return $errors;
    }

    $num  = trim($data['EnterpriseNumber']);
    $denom = trim($data['Denomination']);

    // On commence une transaction pour tout insérer proprement
    $this->pdo->beginTransaction();

    try {
        // 1) enterprise
        $sqlEnt = "
            INSERT INTO enterprise (
                EnterpriseNumber, Status, JuridicalSituation,
                TypeOfEnterprise, JuridicalForm, StartDate
            ) VALUES (
                :num, :status, :js, :toe, :jf, :start
            )
        ";

        $stmt = $this->pdo->prepare($sqlEnt);
        $stmt->execute([
            ':num'   => $num,
            ':status'=> $data['Status'],
            ':js'    => $data['JuridicalSituation'] ?? null,
            ':toe'   => $data['TypeOfEnterprise'] ?? null,
            ':jf'    => $data['JuridicalForm'] ?? null,
            ':start' => $data['StartDate'] ?? null,
        ]);

        // 2) denomination (nom principal)
        $sqlDen = "
            INSERT INTO denomination (EntityNumber, Language, TypeOfDenomination, Denomination)
            VALUES (:num, '2', '001', :denom)
        ";
        $stmtDen = $this->pdo->prepare($sqlDen);
        $stmtDen->execute([
            ':num'   => $num,
            ':denom' => $denom
        ]);

        // 3) address (si renseignée)
       
            $addressType = $data['AddressType'] ?? 'REGO';

        if (
            !empty($data['StreetFR']) ||
            !empty($data['MunicipalityFR']) ||
            !empty($data['Zipcode'])
        ) {
            $sqlAddr = "
                INSERT INTO address (
                    EntityNumber, TypeOfAddress,
                    Zipcode, MunicipalityFR, MunicipalityNL,
                    StreetFR, StreetNL, HouseNumber
                ) VALUES (
                    :num, :type,
                    :zip, :city, :city,
                    :street, :street, :house
                )
            ";

            $stmtAddr = $this->pdo->prepare($sqlAddr);
            $stmtAddr->execute([
                ':num'   => $num,
                ':type'  => $addressType,
                ':zip'   => $data['Zipcode'] ?? null,
                ':city'  => $data['MunicipalityFR'] ?? null,
                ':street'=> $data['StreetFR'] ?? null,
                ':house' => $data['HouseNumber'] ?? null,
            ]);
        }
        
        if ($addressType === 'SECU') {

        // Génération d’un numéro d’établissement (fictif mais unique)
        $establishmentNumber = "2." . str_pad(rand(1,999999999), 9, "0", STR_PAD_LEFT);

        $sqlEst = "
            INSERT INTO establishment (
                EstablishmentNumber,
                StartDate,
                EnterpriseNumber
            ) VALUES (
                :estnum,
                :start,
                :ent
            )
        ";

        $stmtEst = $this->pdo->prepare($sqlEst);
        $stmtEst->execute([
            ':estnum' => $establishmentNumber,
            ':start'  => $data['StartDate'] ?? date("Y-m-d"),
            ':ent'    => $num
        ]);
    }


        $this->pdo->commit();
        return true;

    } catch (\Throwable $e) {
        $this->pdo->rollBack();
        return ["Erreur lors de la création : " . $e->getMessage()];
    }
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