<?php
require 'header.php';
exiger_role(['ADMIN', 'MEDECIN']);

$erreur = '';
$succes = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_don = (int)($_POST['id_don'] ?? 0);
    $choix = $_POST['est_conforme'] ?? '';

    if ($id_don <= 0 || !in_array($choix, ['0', '1'], true)) {
        $erreur = "Données invalides.";
    } else {
        $est_conforme = (int)$choix;
        $nouveau_statut = $est_conforme ? 'VALIDE' : 'REJETÉ';

        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("UPDATE dons SET statut = ? WHERE id_don = ? AND statut = 'EN STOCK'");
            $stmt->execute([$nouveau_statut, $id_don]);

            if ($stmt->rowCount() === 1) {
                $stmt = $pdo->prepare("INSERT INTO tests_don (id_don, est_conforme) VALUES (?, ?)");
                $stmt->execute([$id_don, $est_conforme]);
                $pdo->commit();
                $succes = "Test enregistré. Le don est maintenant : $nouveau_statut.";
            } else {
                $pdo->rollBack();
                $erreur = "Ce don n'est plus en stock.";
            }
        } catch (PDOException $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            $erreur = "Erreur lors de l'enregistrement du test.";
        }
    }
}

$dons = $pdo->query("
    SELECT d.id_don, d.date_don, dn.nom, dn.prenom, dn.groupe_sanguin, c.nom AS centre
    FROM dons d
    JOIN donneurs dn ON d.id_donneur = dn.id_donneur
    JOIN centres_collecte c ON d.id_centre = c.id_centre
    WHERE d.statut = 'EN STOCK'
    ORDER BY d.date_don, d.id_don
")->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Validation des tests</h2>

<?php if ($erreur): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
<?php endif; ?>
<?php if ($succes): ?>
    <div class="alert alert-success"><?= htmlspecialchars($succes) ?></div>
<?php endif; ?>

<?php if (count($dons) === 0): ?>
    <div class="alert alert-info">Aucun don en attente de validation.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>N°</th>
                    <th>Donneur</th>
                    <th>Groupe</th>
                    <th>Centre</th>
                    <th>Date</th>
                    <th>Résultat du test</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dons as $don): ?>
                    <tr>
                        <td><?= (int)$don['id_don'] ?></td>
                        <td><?= htmlspecialchars($don['nom'] . ' ' . $don['prenom']) ?></td>
                        <td><?= htmlspecialchars($don['groupe_sanguin']) ?></td>
                        <td><?= htmlspecialchars($don['centre']) ?></td>
                        <td><?= htmlspecialchars($don['date_don']) ?></td>
                        <td>
                            <form method="post" class="d-flex gap-2">
                                <input type="hidden" name="id_don" value="<?= (int)$don['id_don'] ?>">
                                <select name="est_conforme" class="form-select form-select-sm" required>
                                    <option value="">-- Choisir --</option>
                                    <option value="1">Conforme</option>
                                    <option value="0">Non conforme</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-danger">Valider</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php require 'footer.php'; ?>