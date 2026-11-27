<?php
require 'header.php';
exiger_role(['ADMIN', 'SECRETAIRE']);

$erreur = '';
$succes = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $cin = trim($_POST['cin'] ?? '');
    $groupe = $_POST['groupe_sanguin'] ?? '';
    $ville = trim($_POST['ville'] ?? '');

    if ($nom === '' || $prenom === '' || $ville === '') {
        $erreur = "Tous les champs sont obligatoires.";
    } elseif (!preg_match('/^[0-9]{8}$/', $cin)) {
        $erreur = "Le CIN doit contenir 8 chiffres.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO donneurs (nom, prenom, cin, groupe_sanguin, ville) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nom, $prenom, $cin, $groupe, $ville]);
            $succes = "Donneur ajouté avec succès.";
        } catch (PDOException $e) {
            $erreur = "Ce CIN existe déjà ou le groupe sanguin est invalide.";
        }
    }
}

$groupes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
?>

<h2>Ajouter un donneur</h2>

<?php if ($erreur): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
<?php endif; ?>
<?php if ($succes): ?>
    <div class="alert alert-success"><?= htmlspecialchars($succes) ?></div>
<?php endif; ?>

<form method="post" class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nom</label>
        <input type="text" name="nom" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Prénom</label>
        <input type="text" name="prenom" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">CIN</label>
        <input type="text" name="cin" class="form-control" maxlength="8" required>
    </div>
    <div class="col-md-3">
        <label class="form-label">Groupe sanguin</label>
        <select name="groupe_sanguin" class="form-select" required>
            <?php foreach ($groupes as $g): ?>
                <option value="<?= $g ?>"><?= $g ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Ville</label>
        <input type="text" name="ville" class="form-control" required>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-danger">Enregistrer</button>
    </div>
</form>

<?php require 'footer.php'; ?>