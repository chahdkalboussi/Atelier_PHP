<?php
require_once __DIR__ . "/../fonctions.php";

$erreurs = [];
$valide = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $age = trim($_POST['age'] ?? '');
    $formation = trim($_POST['formation'] ?? '');
    $moyenne = trim($_POST['moyenne'] ?? '');

    $erreurs = validerEtudiant($nom, $prenom, $age, $formation, $moyenne);
    $valide = count($erreurs) === 0;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Inscription</title></head>
<body>
<h1>Inscription (POST)</h1>

<?php foreach ($erreurs as $erreur): ?>
    <p style="color:red"><?= htmlspecialchars($erreur) ?></p>
<?php endforeach; ?>

<form method="POST">
    <p><label>Nom : <input type="text" name="nom" value="<?= htmlspecialchars($nom ?? '') ?>"></label></p>
    <p><label>Prénom : <input type="text" name="prenom" value="<?= htmlspecialchars($prenom ?? '') ?>"></label></p>
    <p><label>Âge : <input type="text" name="age" value="<?= htmlspecialchars($age ?? '') ?>"></label></p>
    <p><label>Formation : <input type="text" name="formation" value="<?= htmlspecialchars($formation ?? '') ?>"></label></p>
    <p><label>Moyenne : <input type="text" name="moyenne" value="<?= htmlspecialchars($moyenne ?? '') ?>"></label></p>
    <button type="submit">Enregistrer</button>
</form>

<?php if ($valide): ?>
    <h2>Étudiant enregistré</h2>
    <p>Nom : <?= htmlspecialchars($nom) ?></p>
    <p>Prénom : <?= htmlspecialchars($prenom) ?></p>
    <p>Âge : <?= htmlspecialchars($age) ?> ans</p>
    <p>Formation : <?= htmlspecialchars($formation) ?></p>
    <p>Moyenne : <?= htmlspecialchars($moyenne) ?> / 20</p>
    <p>Résultat : <?= resultat((float) $moyenne) ?></p>
<?php endif; ?>
</body>
</html>