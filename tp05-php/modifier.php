<?php
require_once __DIR__ . '/connexion.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id || $id <= 0) {
    exit("Identifiant d'étudiant invalide.");
}

$sqlSelect = "SELECT id, nom, prenom, age, formation, moyenne
              FROM etudiants
              WHERE id = :id";
$stmtSelect = $pdo->prepare($sqlSelect);
$stmtSelect->execute(['id' => $id]);
$etudiant = $stmtSelect->fetch();

if (!$etudiant) {
    exit("Aucun étudiant trouvé avec cet identifiant.");
}

$erreurs = [];
$succes = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $ageRaw = $_POST['age'] ?? '';
    $formation = trim($_POST['formation'] ?? '');
    $moyenneRaw = $_POST['moyenne'] ?? '';

    if ($nom === '') {
        $erreurs[] = "Le nom est obligatoire.";
    }
    if ($prenom === '') {
        $erreurs[] = "Le prénom est obligatoire.";
    }
    if ($formation === '') {
        $erreurs[] = "La formation est obligatoire.";
    }

    $ageFiltre = filter_var($ageRaw, FILTER_VALIDATE_INT);
    if ($ageFiltre === false || $ageFiltre < 16) {
        $erreurs[] = "L'âge doit être un entier supérieur ou égal à 16.";
    }

    if (!is_numeric($moyenneRaw)) {
        $erreurs[] = "La moyenne doit être numérique.";
    } else {
        $moyenneFiltre = (float) $moyenneRaw;
        if ($moyenneFiltre < 0 || $moyenneFiltre > 20) {
            $erreurs[] = "La moyenne doit être comprise entre 0 et 20.";
        }
    }

    if (empty($erreurs)) {
        $sqlUpdate = "UPDATE etudiants
                      SET nom = :nom, prenom = :prenom, age = :age, formation = :formation, moyenne = :moyenne
                      WHERE id = :id";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'age' => $ageFiltre,
            'formation' => $formation,
            'moyenne' => $moyenneFiltre,
            'id' => $id
        ]);

        $succes = "Modifications enregistrées avec succès.";
        $etudiant = [
            'id' => $id,
            'nom' => $nom,
            'prenom' => $prenom,
            'age' => $ageFiltre,
            'formation' => $formation,
            'moyenne' => $moyenneFiltre
        ];
    } else {
        $etudiant['nom'] = $nom;
        $etudiant['prenom'] = $prenom;
        $etudiant['age'] = $ageRaw;
        $etudiant['formation'] = $formation;
        $etudiant['moyenne'] = $moyenneRaw;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un étudiant</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Modifier un étudiant</h1>
    <p><a href="index.php">Accueil</a> | <a href="liste.php">Retour à la liste</a></p>

    <?php if ($succes !== ''): ?>
        <p style="color: green;"><?= htmlspecialchars($succes) ?></p>
    <?php endif; ?>

    <?php foreach ($erreurs as $erreur): ?>
        <p style="color: red;"><?= htmlspecialchars($erreur) ?></p>
    <?php endforeach; ?>

    <form method="POST">
        <div>
            <label for="nom">Nom : </label>
            <input id="nom" type="text" name="nom" value="<?= htmlspecialchars((string) $etudiant['nom']) ?>" required>
        </div>
        <div>
            <label for="prenom">Prénom : </label>
            <input id="prenom" type="text" name="prenom" value="<?= htmlspecialchars((string) $etudiant['prenom']) ?>" required>
        </div>
        <div>
            <label for="age">Âge : </label>
            <input id="age" type="number" name="age" min="16" max="100" value="<?= htmlspecialchars((string) $etudiant['age']) ?>" required>
        </div>
        <div>
            <label for="formation">Formation : </label>
            <input id="formation" type="text" name="formation" value="<?= htmlspecialchars((string) $etudiant['formation']) ?>" required>
        </div>
        <div>
            <label for="moyenne">Moyenne : </label>
            <input id="moyenne" type="number" name="moyenne" min="0" max="20" step="0.01" value="<?= htmlspecialchars((string) $etudiant['moyenne']) ?>" required>
        </div>
        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>