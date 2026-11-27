<?php
require 'header.php';
exiger_role(['ADMIN', 'SECRETAIRE']);

$groupes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];

$groupe = $_GET['groupe_sanguin'] ?? '';
$ville = trim($_GET['ville'] ?? '');
$page = max(1, (int)($_GET['page'] ?? 1));
$par_page = 5;

$where = " WHERE 1=1";
$params = [];

if ($groupe !== '') {
    $where .= " AND groupe_sanguin = ?";
    $params[] = $groupe;
}
if ($ville !== '') {
    $where .= " AND ville LIKE ?";
    $params[] = "%$ville%";
}

$stmt = $pdo->prepare("SELECT COUNT(*) FROM donneurs" . $where);
$stmt->execute($params);
$total = (int)$stmt->fetchColumn();
$nb_pages = max(1, (int)ceil($total / $par_page));
$page = min($page, $nb_pages);
$offset = ($page - 1) * $par_page;

$stmt = $pdo->prepare("SELECT * FROM donneurs" . $where . " ORDER BY nom, prenom LIMIT $par_page OFFSET $offset");
$stmt->execute($params);
$donneurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Liste des donneurs</h2>
    <a href="donneur_ajout.php" class="btn btn-danger">Ajouter un donneur</a>
</div>

<form method="get" class="row g-2 mb-3">
    <div class="col-md-3">
        <select name="groupe_sanguin" class="form-select">
            <option value="">Tous les groupes</option>
            <?php foreach ($groupes as $g): ?>
                <option value="<?= $g ?>" <?= $groupe === $g ? 'selected' : '' ?>><?= $g ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-4">
        <input type="text" name="ville" class="form-control" placeholder="Ville" value="<?= htmlspecialchars($ville) ?>">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-secondary w-100">Filtrer</button>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>CIN</th>
                <th>Groupe</th>
                <th>Ville</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($donneurs as $d): ?>
                <tr>
                    <td><?= htmlspecialchars($d['nom']) ?></td>
                    <td><?= htmlspecialchars($d['prenom']) ?></td>
                    <td><?= htmlspecialchars($d['cin']) ?></td>
                    <td><?= htmlspecialchars($d['groupe_sanguin']) ?></td>
                    <td><?= htmlspecialchars($d['ville']) ?></td>
                    <td><a href="donneur_detail.php?id=<?= (int)$d['id_donneur'] ?>" class="btn btn-sm btn-outline-danger">Détails</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if ($nb_pages > 1): ?>
<nav>
    <ul class="pagination">
        <?php for ($i = 1; $i <= $nb_pages; $i++): ?>
            <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                <a class="page-link" href="?<?= htmlspecialchars(http_build_query(['groupe_sanguin' => $groupe, 'ville' => $ville, 'page' => $i])) ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>
<?php endif; ?>

<?php if (count($donneurs) === 0): ?>
    <div class="alert alert-info">Aucun donneur trouvé.</div>
<?php endif; ?>

<?php require 'footer.php'; ?>