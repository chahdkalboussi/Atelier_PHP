<?php
require_once "fonctions.php";

$q = trim($_GET['q'] ?? '');
$trouves = [];
if ($q !== "") {
    $trouves = rechercherParNom(getEtudiants(), $q);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Rechercher</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav><a href="index.php">Liste</a> <a href="ajouter.php">Ajouter</a> <a href="rechercher.php">Rechercher</a></nav>
<h1>Rechercher un étudiant</h1>

<form method="GET">
    <input type="text" name="nom_recherche" style="display:none">
    <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Nom ou prénom">
    <button type="submit">Rechercher</button>
</form>

<?php
if ($q !== "") {
    if (count($trouves) > 0) {
        afficherTableau($trouves);
    } else {
        echo "<p>Aucun étudiant trouvé.</p>";
    }
}
?>
</body>
</html>