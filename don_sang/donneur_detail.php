<?php
require 'header.php';
exiger_role(['ADMIN', 'SECRETAIRE']);

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM donneurs WHERE id_donneur = ?");
$stmt->execute([$id]);
$donneur = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$donneur) {
    echo '<div class="alert alert-danger">Donneur introuvable.</div>';
    require 'footer.php';
    exit;
}

$stmt = $pdo->prepare("
    SELECT d.id_don, d.date_don, d.statut, c.nom AS centre
    FROM dons d
    JOIN centres_collecte c ON d.id_centre = c.id_centre
    WHERE d.id_donneur = ?
    ORDER BY d.date_don DESC
");
$stmt->execute([$id]);
$dons = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Détails du donneur</h2>
    <a href="donneurs.php" class="btn btn-secondary">Retour</a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <p><strong>Nom :</strong> <?= htmlspecialchars($donneur['nom']) ?></p>
        <p><strong>Prénom :</strong> <?= htmlspecialchars($donneur['prenom']) ?></p>
        <p><strong>CIN :</strong> <?= htmlspecialchars($donneur['cin']) ?></p>
        <p><strong>Groupe sanguin :</strong> <?= htmlspecialchars($donneur['groupe_sanguin']) ?></p>
        <p class="mb-0"><strong>Ville :</strong> <?= htmlspecialchars($donneur['ville']) ?></p>
    </div>
</div>

<h4>Historique des dons</h4>

<?php if (count($dons) === 0): ?>
    <div class="alert alert-info">Aucun don enregistré pour ce donneur.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>N° don</th>
                    <th>Date</th>
                    <th>Centre</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dons as $don): ?>
                    <tr>
                        <td><?= (int)$don['id_don'] ?></td>
                        <td><?= htmlspecialchars($don['date_don']) ?></td>
                        <td><?= htmlspecialchars($don['centre']) ?></td>
                        <td><?= htmlspecialchars($don['statut']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php require 'footer.php'; ?>