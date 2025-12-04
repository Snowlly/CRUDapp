<h2 class="title-create">Modifier l'entreprise</h2>

<?php if (!empty($errors)): ?>
    <div class="error-box">
        <?php foreach ($errors as $e): ?>
            <div>⚠ <?= htmlspecialchars($e) ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="POST" class="create-form">

    <!-- INFORMATIONS ENTREPRISE -->
    <div class="form-group">
        <label>Numéro BCE (non modifiable)</label>
        <input type="text" value="<?= $enterprise['EnterpriseNumber'] ?>" disabled>
    </div>

    <div class="form-group">
        <label>Nouveau nom / Dénomination*</label>
        <input type="text" name="Denomination"
               value="<?= htmlspecialchars($denomination['Denomination'] ?? '') ?>"
               required>
    </div>

    <div class="form-group">
        <label>Status*</label>
        <select name="Status" required>
            <option value="AC" <?= $enterprise['Status'] === 'AC' ? 'selected' : '' ?>>Active</option>
            <option value="NA" <?= $enterprise['Status'] === 'NA' ? 'selected' : '' ?>>Non Active</option>
        </select>
    </div>

    <div class="form-group">
        <label>Situation juridique</label>
        <input type="number" name="JuridicalSituation"
               value="<?= $enterprise['JuridicalSituation'] ?>">
    </div>

    <div class="form-group">
        <label>Type d'entreprise</label>
        <input type="number" name="TypeOfEnterprise"
               value="<?= $enterprise['TypeOfEnterprise'] ?>">
    </div>

    <div class="form-group">
        <label>Forme juridique</label>
        <input type="number" name="JuridicalForm"
               value="<?= $enterprise['JuridicalForm'] ?>">
    </div>

    <div class="form-group">
        <label>Date de création</label>
        <input type="date" name="StartDate"
               value="<?= $enterprise['StartDate'] ?>">
    </div>


    <!-- ADRESSE PRINCIPALE -->
    <h3 class="section-divider">Adresse principale</h3>

    <div class="form-group">
        <label>Rue</label>
        <input type="text" name="StreetFR"
               value="<?= $address['StreetFR'] ?? '' ?>">
    </div>

    <div class="form-group">
        <label>Numéro</label>
        <input type="text" name="HouseNumber"
               value="<?= $address['HouseNumber'] ?? '' ?>">
    </div>

    <div class="form-group">
        <label>Code Postal</label>
        <input type="text" name="Zipcode"
               value="<?= $address['Zipcode'] ?? '' ?>">
    </div>

    <div class="form-group">
        <label>Ville</label>
        <input type="text" name="MunicipalityFR"
               value="<?= $address['MunicipalityFR'] ?? '' ?>">
    </div>


    <!-- BOUTONS -->
    <div class="edit-actions">
        <a href="index.php?page=EnterpriseShow&id=<?= $enterprise['EnterpriseNumber'] ?>"
           class="btn-blue">Annuler</a>

        <button type="submit" class="submit-btn">
            Enregistrer les modifications
        </button>
    </div>

</form>
