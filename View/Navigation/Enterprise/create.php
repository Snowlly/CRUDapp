<h2 class="title-create">Créer une nouvelle entreprise</h2>

<?php if (!empty($errors)): ?>
    <div class="error-box">
        <?php foreach ($errors as $e): ?>
            <div>⚠ <?= htmlspecialchars($e) ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="POST" class="create-form">

    <select name="AddressType">
        <label>Cette adresse est :</label><br>
        <option value="REGO">Siège social</option>
        <option value="SECU">Succursale / Unité d’établissement</option>
    </select>

    <!-- COLONNE GAUCHE : infos entreprise -->
    <div class="form-group">
        <label>Numéro d'entreprise (BCE)*</label>
        <input type="text" name="EnterpriseNumber" required>
    </div>

    <div class="form-group">
        <label>Nom de l'entreprise (dénomination)*</label>
        <input type="text" name="Denomination" required>
    </div>

    <div class="form-group">
        <label>Status*</label>
        <select name="Status" required>
            <option value="AC">Active</option>
            <option value="NA">Non Active</option>
        </select>
    </div>

    <div class="form-group">
        <label>Situation juridique</label>
        <input type="number" name="JuridicalSituation">
    </div>

    <div class="form-group">
        <label>Type d'entreprise</label>
        <input type="number" name="TypeOfEnterprise">
    </div>

    <div class="form-group">
        <label>Forme juridique</label>
        <input type="number" name="JuridicalForm">
    </div>

    <div class="form-group">
        <label>Date de création</label>
        <input type="date" name="StartDate">
    </div>

    <!-- COLONNE DROITE : adresse siège -->
    <div class="form-group">
        <label>Rue</label>
        <input type="text" name="StreetFR">
    </div>

    <div class="form-group">
        <label>Numéro</label>
        <input type="text" name="HouseNumber">
    </div>

    <div class="form-group">
        <label>Code postal</label>
        <input type="text" name="Zipcode">
    </div>

    <div class="form-group">
        <label>Ville</label>
        <input type="text" name="MunicipalityFR">
    </div>

    <button class="submit-btn">Créer l'entreprise</button>

</form>