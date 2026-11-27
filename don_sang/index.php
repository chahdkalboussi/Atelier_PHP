<?php
require 'header.php';

$nb_donneurs = (int)$pdo->query("SELECT COUNT(*) FROM donneurs")->fetchColumn();
$nb_dons_valides = (int)$pdo->query("SELECT COUNT(*) FROM dons WHERE statut = 'VALIDE'")->fetchColumn();
$nb_centres = (int)$pdo->query("SELECT COUNT(*) FROM centres_collecte")->fetchColumn();

$groupes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
$stock = array_fill_keys($groupes, 0);

$rows = $pdo->query("
    SELECT dn.groupe_sanguin, COUNT(*) AS total
    FROM dons d
    JOIN donneurs dn ON d.id_donneur = dn.id_donneur
    WHERE d.statut = 'VALIDE'
    GROUP BY dn.groupe_sanguin
")->fetchAll(PDO::FETCH_ASSOC);

foreach ($rows as $r) {
    $stock[$r['groupe_sanguin']] = (int)$r['total'];
}

$alertes = $pdo->query("
    SELECT groupe_sanguin, niveau_alerte
    FROM besoins
    WHERE niveau_alerte IN ('URGENT', 'CRITIQUE')
    ORDER BY niveau_alerte DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<h2 class="mb-4">Tableau de bord</h2>

<?php foreach ($alertes as $a): ?>
    <div class="alert <?= $a['niveau_alerte'] === 'CRITIQUE' ? 'alert-danger' : 'alert-warning' ?>">
        <strong><?= htmlspecialchars($a['niveau_alerte']) ?></strong> :
        besoin en sang du groupe <strong><?= htmlspecialchars($a['groupe_sanguin']) ?></strong>
    </div>
<?php endforeach; ?>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card text-bg-primary">
            <div class="card-body">
                <h6 class="card-title">Donneurs</h6>
                <p class="display-6 mb-0"><?= $nb_donneurs ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-success">
            <div class="card-body">
                <h6 class="card-title">Dons valides</h6>
                <p class="display-6 mb-0"><?= $nb_dons_valides ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-dark">
            <div class="card-body">
                <h6 class="card-title">Centres</h6>
                <p class="display-6 mb-0"><?= $nb_centres ?></p>
            </div>
        </div>
    </div>
</div>

<h4>État du stock (dons valides)</h4>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Groupe sanguin</th>
                <th>Quantité disponible</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stock as $groupe => $qte): ?>
                <tr>
                    <td><?= htmlspecialchars($groupe) ?></td>
                    <td><?= $qte ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require 'footer.php'; ?>