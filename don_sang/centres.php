<?php
require 'header.php';
exiger_role(['ADMIN']);

$erreur = '';
$succes = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $ville = trim($_POST['ville'] ?? '');

    if ($nom === '' || $ville === '') {
        $erreur = "Tous les champs sont obligatoires.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO centres_collecte (nom, ville) VALUES (?, ?)");
        $stmt->execute([$nom, $ville]);
        $succes = "Centre ajouté avec succès.";
    }
}

$centres = $pdo->query("SELECT id_centre, nom, ville FROM centres_collecte ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Gestion des centres</h2>

<?php if ($erreur): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
<?php endif; ?>
<?php if ($succes): ?>
    <div class="alert alert-success"><?= htmlspecialchars($succes) ?></div>
<?php endif; ?>

<form method="post" class="row g-3 mb-4">
    <div class="col-md-5">
        <label class="form-label">Nom du centre</label>
        <input type="text" name="nom" class="form-control" required>
    </div>
    <div class="col-md-5">
        <label class="form-label">Ville</label>
        <input type="text" name="ville" class="form-control" required>
    </div>
    <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-danger w-100">Ajouter</button>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>N°</th>
                <th>Nom</th>
                <th>Ville</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($centres as $c): ?>
                <tr>
                    <td><?= (int)$c['id_centre'] ?></td>
                    <td><?= htmlspecialchars($c['nom']) ?></td>
                    <td><?= htmlspecialchars($c['ville']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require 'footer.php'; ?>