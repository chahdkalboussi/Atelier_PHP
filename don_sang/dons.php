<?php
require 'header.php';
exiger_role(['ADMIN', 'SECRETAIRE']);

$erreur = '';
$succes = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_donneur = (int)($_POST['id_donneur'] ?? 0);
    $id_centre = (int)($_POST['id_centre'] ?? 0);
    $date_don = $_POST['date_don'] ?? '';

    if ($id_donneur <= 0 || $id_centre <= 0 || $date_don === '') {
        $erreur = "Tous les champs sont obligatoires.";
    } elseif (!DateTime::createFromFormat('Y-m-d', $date_don)) {
        $erreur = "Date invalide.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO dons (id_donneur, id_centre, date_don) VALUES (?, ?, ?)");
            $stmt->execute([$id_donneur, $id_centre, $date_don]);
            $succes = "Don enregistré avec succès (statut : EN STOCK).";
        } catch (PDOException $e) {
            $erreur = "Donneur ou centre invalide.";
        }
    }
}

$donneurs = $pdo->query("SELECT id_donneur, nom, prenom, groupe_sanguin FROM donneurs ORDER BY nom, prenom")->fetchAll(PDO::FETCH_ASSOC);
$centres = $pdo->query("SELECT id_centre, nom FROM centres_collecte ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);

$derniers = $pdo->query("
    SELECT d.id_don, d.date_don, d.statut, dn.nom, dn.prenom, c.nom AS centre
    FROM dons d
    JOIN donneurs dn ON d.id_donneur = dn.id_donneur
    JOIN centres_collecte c ON d.id_centre = c.id_centre
    ORDER BY d.id_don DESC
    LIMIT 10
")->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Enregistrer un don</h2>

<?php if ($erreur): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
<?php endif; ?>
<?php if ($succes): ?>
    <div class="alert alert-success"><?= htmlspecialchars($succes) ?></div>
<?php endif; ?>

<form method="post" class="row g-3 mb-5">
    <div class="col-md-4">
        <label class="form-label">Donneur</label>
        <select name="id_donneur" class="form-select" required>
            <option value="">-- Choisir --</option>
            <?php foreach ($donneurs as $d): ?>
                <option value="<?= (int)$d['id_donneur'] ?>">
                    <?= htmlspecialchars($d['nom'] . ' ' . $d['prenom'] . ' (' . $d['groupe_sanguin'] . ')') ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Centre de collecte</label>
        <select name="id_centre" class="form-select" required>
            <option value="">-- Choisir --</option>
            <?php foreach ($centres as $c): ?>
                <option value="<?= (int)$c['id_centre'] ?>"><?= htmlspecialchars($c['nom']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Date du don</label>
        <input type="date" name="date_don" class="form-control" value="<?= date('Y-m-d') ?>" required>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-danger">Enregistrer le don</button>
    </div>
</form>

<h4>Derniers dons</h4>

<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>N°</th>
                <th>Donneur</th>
                <th>Centre</th>
                <th>Date</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($derniers as $don): ?>
                <tr>
                    <td><?= (int)$don['id_don'] ?></td>
                    <td><?= htmlspecialchars($don['nom'] . ' ' . $don['prenom']) ?></td>
                    <td><?= htmlspecialchars($don['centre']) ?></td>
                    <td><?= htmlspecialchars($don['date_don']) ?></td>
                    <td><?= htmlspecialchars($don['statut']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require 'footer.php'; ?>