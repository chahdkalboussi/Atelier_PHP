<?php
require_once __DIR__ . '/connexion.php';

$moyenneMinRaw = $_GET['moyenne_min'] ?? '';
$moyenneMin = null;

if ($moyenneMinRaw !== '' && is_numeric($moyenneMinRaw)) {
    $val = (float) $moyenneMinRaw;
    if ($val >= 0 && $val <= 20) {
        $moyenneMin = $val;
    }
}

$tri = $_GET['tri'] ?? 'moyenne';
$ordre = strtoupper($_GET['ordre'] ?? 'DESC');

$colonnesAutorisees = [
    'nom' => 'nom',
    'moyenne' => 'moyenne'
];
$colonneSql = $colonnesAutorisees[$tri] ?? 'moyenne';
$ordreSql = in_array($ordre, ['ASC', 'DESC'], true) ? $ordre : 'DESC';

if ($moyenneMin !== null) {
    $sql = "SELECT id, nom, prenom, age, formation, moyenne
            FROM etudiants
            WHERE moyenne >= :moyenne_min
            ORDER BY $colonneSql $ordreSql, nom ASC, prenom ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['moyenne_min' => $moyenneMin]);
} else {
    $sql = "SELECT id, nom, prenom, age, formation, moyenne
            FROM etudiants
            ORDER BY $colonneSql $ordreSql, nom ASC, prenom ASC";
    $stmt = $pdo->query($sql);
}
$etudiants = $stmt->fetchAll();

$sqlStats = "SELECT
                COUNT(*) AS nombre_etudiants,
                AVG(moyenne) AS moyenne_classe,
                MAX(moyenne) AS meilleure_moyenne,
                MIN(moyenne) AS plus_faible_moyenne
             FROM etudiants";
$stats = $pdo->query($sqlStats)->fetch();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des étudiants</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Liste des étudiants</h1>
    <p>
        <a href="index.php">Accueil</a> |
        <a href="ajouter.php">Ajouter un étudiant</a> |
        <a href="rechercher.php">Rechercher</a>
    </p>

    <h2>Statistiques de la promotion</h2>
    <ul>
        <li>Nombre total d'étudiants : <strong><?= (int) $stats['nombre_etudiants'] ?></strong></li>
        <li>
            Moyenne de la classe :
            <strong>
                <?= $stats['moyenne_classe'] !== null ? number_format((float) $stats['moyenne_classe'], 2) : 'N/A' ?>
            </strong>
        </li>
        <li>
            Meilleure moyenne :
            <strong>
                <?= $stats['meilleure_moyenne'] !== null ? htmlspecialchars((string) $stats['meilleure_moyenne']) : 'N/A' ?>
            </strong>
        </li>
        <li>
            Plus faible moyenne :
            <strong>
                <?= $stats['plus_faible_moyenne'] !== null ? htmlspecialchars((string) $stats['plus_faible_moyenne']) : 'N/A' ?>
            </strong>
        </li>
    </ul>

    <h2>Filtrer et trier</h2>
    <form method="GET">
        <label for="moyenne_min">Moyenne minimale : </label>
        <input
            id="moyenne_min"
            type="number"
            name="moyenne_min"
            min="0"
            max="20"
            step="0.01"
            value="<?= htmlspecialchars((string) $moyenneMinRaw) ?>"
        >

        <label for="tri">Trier par : </label>
        <select id="tri" name="tri">
            <option value="moyenne" <?= $colonneSql === 'moyenne' ? 'selected' : '' ?>>Moyenne</option>
            <option value="nom" <?= $colonneSql === 'nom' ? 'selected' : '' ?>>Nom</option>
        </select>

        <select name="ordre" aria-label="Ordre de tri">
            <option value="DESC" <?= $ordreSql === 'DESC' ? 'selected' : '' ?>>Décroissant</option>
            <option value="ASC" <?= $ordreSql === 'ASC' ? 'selected' : '' ?>>Croissant</option>
        </select>

        <button type="submit">Appliquer</button>
        <a href="liste.php">Réinitialiser</a>
    </form>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Âge</th>
                <th>Formation</th>
                <th>Moyenne</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($etudiants) > 0): ?>
                <?php foreach ($etudiants as $etudiant): ?>
                    <tr>
                        <td><?= (int) $etudiant['id'] ?></td>
                        <td><?= htmlspecialchars($etudiant['nom']) ?></td>
                        <td><?= htmlspecialchars($etudiant['prenom']) ?></td>
                        <td><?= (int) $etudiant['age'] ?></td>
                        <td><?= htmlspecialchars($etudiant['formation']) ?></td>
                        <td><?= htmlspecialchars((string) $etudiant['moyenne']) ?></td>
                        <td>
                            <a href="modifier.php?id=<?= (int) $etudiant['id'] ?>">Modifier</a>
                            <form action="supprimer.php" method="POST" style="display:inline;" onsubmit="return confirm('Confirmer la suppression de cet étudiant ?');">
                                <input type="hidden" name="id" value="<?= (int) $etudiant['id'] ?>">
                                <button type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Aucun étudiant ne correspond aux critères sélectionnés.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>