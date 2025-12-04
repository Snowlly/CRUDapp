<link rel="stylesheet" href="View/assets/css/index.css">

<div class="index-container">

    <!-- SEARCH BAR -->
    <form method="GET" action="index.php" class="search-bar">
        <input type="hidden" name="page" value="EnterpriseIndex">

        <input
            type="text"
            name="q"
            value="<?= htmlspecialchars($search ?? '') ?>"
            placeholder="Rechercher des entreprises"
            class="search-input">

        <button class="search-btn">Rechercher</button>
    </form>

    <!-- ADD ENTERPRISE BUTTON -->
    <div class="add-container">
        <a href="index.php?page=EnterpriseCreate" class="add-btn">
            + Ajouter une entreprise
        </a>
    </div>

    <!-- RESULTS -->
    <div class="result-title">Résultats trouvés</div>
    <div class="result-sub">
        <?= count($enterprises) ?> entreprises correspondent à votre recherche
    </div>

    <!-- COMPANY CARDS -->
    <?php foreach ($enterprises as $e): ?>

        <?php
            // Récupérer la dénomination principale
            $denom = isset($e['Denomination'])
                ? $e['Denomination']
                : "Entreprise " . $e['EnterpriseNumber'];
        ?>

        <div class="company-card">
            <div class="company-header">
                <?= strtoupper($denom) ?>
            </div>

            <div class="company-body">

                <div class="company-grid">

                    <div>
                        <div class="label">Forme juridique</div>
                        <div class="value"><?= $e['JuridicalForm'] ?? "N/A" ?></div>
                    </div>

                    <div>
                        <div class="label">Activité</div>
                        <div class="value"><?= $e['Activity'] ?? "N/A" ?></div>
                    </div>

                    <div>
                        <div class="label">Lieu</div>
                        <div class="value"><?= $e['MunicipalityFR'] ?? "N/A" ?></div>
                    </div>

                </div>

            </div>

            <div class="company-footer">
                <a class="go-btn"
                   href="index.php?page=EnterpriseShow&id=<?= urlencode($e['EnterpriseNumber']) ?>">→</a>
            </div>
        </div>

    <?php endforeach; ?>

</div>
