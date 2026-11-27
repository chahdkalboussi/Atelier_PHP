<?php
require 'header.php';
exiger_role(['ADMIN']);

$erreur = '';
$succes = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_don = (int)($_POST['id_don'] ?? 0);
    $hopital = trim($_POST['hopital_recepteur'] ?? '');
    $date = $_POST['date_transfusion'] ?? '';

    if ($id_don <= 0 || $hopital === '' || $date === '') {
        $erreur = "Tous les champs sont obligatoires.";
    } elseif (!DateTime::createFromFormat('Y-m-d', $date)) {
        $erreur = "Date invalide.";
    } else {
        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("UPDATE dons SET statut = 'UTILISÉ' WHERE id_don = ? AND statut = 'VALIDE'");
            $stmt->execute([$id_don]);

            if ($stmt->rowCount() === 1) {
                $stmt = $pdo->prepare("INSERT INTO transfusions (id_don, hopital_recepteur, date_transfusion) VALUES (?, ?, ?)");
                $stmt->execute([$id_don, $hopital, $date]);
                $pdo->commit();
                $succes = "Transfusion enregistrée. Le don est maintenant : UTILISÉ.";
            } else {
                $pdo->rollBack();
                $erreur = "Ce don n'est pas disponible (statut différent de VALIDE).";
            }
        } catch (PDOException $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            $erreur = "Erreur lors de l'enregistrement de la transfusion.";
        }
    }
}

$dons = $pdo->query("
    SELECT d.id_don, d.date_don, dn.nom, dn.prenom, dn.groupe_sanguin, c.nom AS centre
    FROM dons d
    JOIN donneurs dn ON d.id_donneur = dn.id_donneur
    JOIN centres_collecte c ON d.id_centre = c.id_centre
    WHERE d.statut = 'VALIDE'
    ORDER BY d.date_don, d.id_don
")->fetchAll(PDO::FETCH_ASSOC);

$historique = $pdo->query("
    SELECT t.date_transfusion, t.hopital_recepteur, d.id_don, dn.nom, dn.prenom, dn.groupe_sanguin
    FROM transfusions t
    JOIN dons d ON t.id_don = d.id_don
    JOIN donneurs dn ON d.id_donneur = dn.id_donneur
    ORDER BY t.id_transfusion DESC
    LIMIT 10
")->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Traçabilité / Transfusions</h2>

<?php if ($erreur): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
<?php endif; ?>
<?php if ($succes): ?>
    <div class="alert alert-success"><?= htmlspecialchars($succes) ?></div>
<?php endif; ?>

<h4>Dons validés disponibles</h4>

<?php if (count($dons) === 0): ?>
    <div class="alert alert-info">Aucun don validé disponible.</div>
<?php else: ?>
    <div class="table-responsive mb-5">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>N°</th>
                    <th>Donneur</th>
                    <th>Groupe</th>
                    <th>Centre</th>
                    <th>Date</th>
                    <th>Utilisation</th>
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
                            <form method="post" class="row g-1">
                                <input type="hidden" name="id_don" value="<?= (int)$don['id_don'] ?>">
                                <div class="col-md-5">
                                    <input type="text" name="hopital_recepteur" class="form-control form-control-sm" placeholder="Hôpital" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" name="date_transfusion" class="form-control form-control-sm" value="<?= date('Y-m-d') ?>" required>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-sm btn-danger w-100">Utiliser</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<h4>Dernières transfusions</h4>

<?php if (count($historique) === 0): ?>
    <div class="alert alert-info">Aucune transfusion enregistrée.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>N° don</th>
                    <th>Donneur</th>
                    <th>Groupe</th>
                    <th>Hôpital</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historique as $t): ?>
                    <tr>
                        <td><?= (int)$t['id_don'] ?></td>
                        <td><?= htmlspecialchars($t['nom'] . ' ' . $t['prenom']) ?></td>
                        <td><?= htmlspecialchars($t['groupe_sanguin']) ?></td>
                        <td><?= htmlspecialchars($t['hopital_recepteur']) ?></td>
                        <td><?= htmlspecialchars($t['date_transfusion']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php require 'footer.php'; ?>