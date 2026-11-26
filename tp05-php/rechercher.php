<?php
require_once __DIR__ . '/connexion.php';

$nomRecherche = trim($_GET['nom'] ?? '');
$etudiants = [];

if ($nomRecherche !== '') {
    $sql = "SELECT id, nom, prenom, age, formation, moyenne
            FROM etudiants
            WHERE nom LIKE :nom
            ORDER BY nom, prenom";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nom' => '%' . $nomRecherche . '%'
    ]);
    $etudiants = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rechercher un étudiant</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Rechercher un étudiant</h1>
    <p><a href="index.php">Accueil</a> | <a href="liste.php">Voir la liste</a></p>

    <form method="GET">
        <label for="nom">Nom à rechercher : </label>
        <input id="nom" type="text" name="nom" value="<?= htmlspecialchars($nomRecherche) ?>">
        <button type="submit">Rechercher</button>
    </form>

    <?php if ($nomRecherche !== ''): ?>
        <?php if (count($etudiants) > 0): ?>
            <table border="1" cellpadding="8">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Âge</th>
                        <th>Formation</th>
                        <th>Moyenne</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($etudiants as $etudiant): ?>
                        <tr>
                            <td><?= (int) $etudiant['id'] ?></td>
                            <td><?= htmlspecialchars($etudiant['nom']) ?></td>
                            <td><?= htmlspecialchars($etudiant['prenom']) ?></td>
                            <td><?= (int) $etudiant['age'] ?></td>
                            <td><?= htmlspecialchars($etudiant['formation']) ?></td>
                            <td><?= htmlspecialchars((string) $etudiant['moyenne']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun étudiant ne correspond à la recherche « <?= htmlspecialchars($nomRecherche) ?> ».</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
