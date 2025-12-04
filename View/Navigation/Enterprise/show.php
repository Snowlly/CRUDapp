<link rel="stylesheet" href="View/assets/css/show.css">

<div class="show-container">

    <!-- HEADER -->
    <div class="show-header">
        <h1 class="show-title">
            <?= $denominations[0]['Denomination'] ?? "Entreprise" ?>
        </h1>

        <?php if (!empty($denominations[1])): ?>
            <div class="show-subtitle">
                (<?= $denominations[1]['Denomination'] ?>)
            </div>
        <?php endif; ?>

        <div style="margin-top:20px;">
            <strong><?= $enterprise['EnterpriseNumber'] ?></strong>
            • <?= $enterprise['Status'] ?>
        </div>

        <?php if (!empty($addresses)): ?>
            <div style="margin-top:15px;">
                <strong>Adresse :</strong>
                <?= $addresses[0]['StreetFR'] ?>
                <?= $addresses[0]['HouseNumber'] ?>,
                <?= $addresses[0]['Zipcode'] ?>
                <?= $addresses[0]['MunicipalityFR'] ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($activities)): ?>
            <div style="margin-top:10px;">
                <strong>Activité :</strong>
                <?= $activities[0]['NaceCode'] ?> —
                <?= $activities[0]['Classification'] ?>
            </div>
        <?php endif; ?>

        <div style="margin-top:10px;">
            <strong>Création :</strong>
            <?= $enterprise['StartDate'] ?>
        </div>

        <div class="btn-actions">
            <a class="btn-blue" href="index.php?page=EnterpriseIndex">Retour</a>
            <a class="btn-red"
               onclick="return confirm('Supprimer cette entreprise ?')"
               href="index.php?page=EnterpriseIndex&action=delete&id=<?= $enterprise['EnterpriseNumber'] ?>">
                Supprimer
            </a>
        </div>
    </div>


    <!-- INFOS JURIDIQUES -->
    <div class="show-section">
        <div class="section-title">Informations juridiques</div>

        <div class="info-grid">
            <div class="key">Numéro BCE :</div>
            <div class="value"><?= $enterprise['EnterpriseNumber'] ?></div>

            <div class="key">Statut :</div>
            <div class="value"><?= $enterprise['Status'] ?></div>

            <div class="key">Forme juridique :</div>
            <div class="value"><?= $enterprise['JuridicalForm'] ?></div>

            <div class="key">Type entreprise :</div>
            <div class="value"><?= $enterprise['TypeOfEnterprise'] ?></div>

            <div class="key">Date création :</div>
            <div class="value"><?= $enterprise['StartDate'] ?></div>
        </div>
    </div>


    <!-- ACTIVITÉS -->
    <div class="show-section">
        <div class="section-title">Activités</div>

        <?php foreach ($activities as $act): ?>
            <div class="info-grid">
                <div class="key"><?= $act['Classification'] ?></div>
                <div class="value">
                    <?= $act['NaceCode'] ?> (<?= $act['NaceVersion'] ?>)
                </div>
            </div>
        <?php endforeach; ?>

    </div>


    <!-- ADRESSES -->
    <div class="show-section">
        <div class="section-title">Adresse(s)</div>

        <?php foreach ($addresses as $addr): ?>
            <div class="info-grid">
                <div class="key">Adresse :</div>
                <div class="value">
                    <?= $addr['StreetFR'] ?> <?= $addr['HouseNumber'] ?><br>
                    <?= $addr['Zipcode'] ?> <?= $addr['MunicipalityFR'] ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>


    <!-- SUCCURSALES -->
    <div class="show-section">
        <div class="section-title">Succursales</div>

        <?php if (empty($establishments)): ?>
            <p>Aucune succursale enregistrée.</p>
        <?php else: ?>
            <?php foreach ($establishments as $est): ?>
                <div class="info-grid">
                    <div class="key">N° :</div>
                    <div class="value"><?= $est['EstablishmentNumber'] ?></div>

                    <div class="key">Ouverture :</div>
                    <div class="value"><?= $est['StartDate'] ?></div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>
