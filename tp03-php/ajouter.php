<?php
require_once "fonctions.php";
$nom = $prenom = $age = $formation = $moyenne = "";
$erreurs = [];
$etudiant = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $age = trim($_POST['age'] ?? '');
    $formation = trim($_POST['formation'] ?? '');
    $moyenne = trim($_POST['moyenne'] ?? '');


    $erreurs = validerEtudiant($nom, $prenom, $age, $formation, $moyenne);

    if (count($erreurs) === 0) {
        $etudiant = [
            "nom" => $nom,
            "prenom" => $prenom,
            "age" => (int) $age,
            "formation" => $formation,
            "moyenne" => (float) $moyenne
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Ajouter un étudiant</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav><a href="index.php">Liste</a> <a href="ajouter.php">Ajouter</a> <a href="rechercher.php">Rechercher</a></nav>
<h1>Ajouter un étudiant</h1>

<?php foreach ($erreurs as $erreur): ?>
    <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
<?php endforeach; ?>

<form method="POST">
    <label>Nom : <input type="text" name="nom" value="<?= htmlspecialchars($nom) ?>"></label>
    <label>Prénom : <input type="text" name="prenom" value="<?= htmlspecialchars($prenom) ?>"></label>
    <label>Âge : <input type="text" name="age" value="<?= htmlspecialchars($age) ?>"></label>
    <label>Formation : <input type="text" name="formation" value="<?= htmlspecialchars($formation) ?>"></label>
    <label>Moyenne : <input type="text" name="moyenne" value="<?= htmlspecialchars($moyenne) ?>"></label>
    <p><button type="submit">Ajouter</button></p>
</form>

<?php if ($etudiant !== null): ?>
<div class="fiche">
    <h2>Étudiant enregistré</h2>
    <p>Nom : <?= htmlspecialchars($etudiant['nom']) ?></p>
    <p>Prénom : <?= htmlspecialchars($etudiant['prenom']) ?></p>
    <p>Âge : <?= $etudiant['age'] ?> ans</p>
    <p>Formation : <?= htmlspecialchars($etudiant['formation']) ?></p>
    <p>Moyenne : <?= $etudiant['moyenne'] ?> / 20</p>
    <p>Résultat : <?= resultat($etudiant['moyenne']) ?></p>
</div>
<?php endif; ?>
</body>
</html>