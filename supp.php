<?php
ini_set("memory_limit", "-1");
ini_set("max_execution_time", 0);
ini_set("display_errors", 1);

echo "--------- NETTOYAGE DES ORPHELINS : TABLE activity ---------\n";

try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=CRUDapp;charset=utf8",
        "root",
        "",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false,
        ]
    );
} catch (Exception $e) {
    die("Erreur connexion PDO : " . $e->getMessage());
}

$batch = 1000;  // Taille du batch
$totalDeleted = 0;

while (true) {

    echo "Suppression d'un batch de $batch lignes...\n";

    // Requête 100% compatible MySQL + LIMIT
    $sql = "
        DELETE FROM activity
        WHERE EntityNumber IN (
            SELECT EntityNumber FROM (
                SELECT a.EntityNumber
                FROM activity a
                LEFT JOIN enterprise e
                    ON e.EnterpriseNumber = a.EntityNumber
                WHERE e.EnterpriseNumber IS NULL
                LIMIT $batch
            ) AS tmp
        );
    ";

    $deleted = $pdo->exec($sql);

    echo "→ Lignes supprimées : $deleted\n";

    if ($deleted === 0) {
        echo "\n✔ Nettoyage terminé ! Aucun orphelin restant.\n";
        echo "Total supprimé : $totalDeleted lignes.\n";
        break;
    }

    $totalDeleted += $deleted;

    // Pause légère pour éviter charge CPU
    usleep(200000); // 0.2 seconde
}

echo "\n----------- FIN -----------\n";
