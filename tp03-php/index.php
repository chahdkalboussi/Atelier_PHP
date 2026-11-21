<?php
require_once "fonctions.php";
$etudiants = getEtudiants();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Gestion des étudiants</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<h1>Gestion des étudiants</h1>
<nav>
    <a href="index.php">[ Liste des étudiants ]</a>
    <a href="ajouter.php">[ Ajouter un étudiant ]</a>
    <a href="rechercher.php">[ Rechercher un étudiant ]</a>
</nav>

<h2>Liste</h2>
<?php afficherTableau($etudiants); ?>
<p>Nombre d'étudiants : <?= count($etudiants) ?></p>
</body>
</html>