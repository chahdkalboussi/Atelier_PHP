<?php
$prenom = "Chahd";
$nom = "kalboussi";
$age = 20;
$formation = "Informatique";
$annee = 2;
$moyenne = 14.5;

if ($moyenne >= 10) {
    $resultat = "Année validée";
} else {
    $resultat = "Année non validée";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Profil étudiant</title>
</head>
<body>
<h1>Profil étudiant</h1>
<p>Nom complet : <?php echo "$prenom $nom"; ?></p>
<p>Âge : <?php echo $age; ?> ans</p>
<p>Formation : <?php echo $formation; ?></p>
<p>Année : <?php echo $annee; ?>ème année</p>
<p>Moyenne : <?php echo $moyenne; ?></p>
<p>Résultat : <?php echo $resultat; ?></p>
</body>
</html>