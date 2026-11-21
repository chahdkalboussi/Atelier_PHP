<?php
require_once __DIR__ . "/../fonctions.php";

$etudiants = getEtudiants();

echo "<h2>Tous les étudiants</h2>";
foreach ($etudiants as $etudiant) {
    afficherEtudiant($etudiant);
    echo "<hr>";
}

echo "<h2>Moyenne de la classe</h2>";
echo "<p>" . round(calculerMoyenneClasse($etudiants), 2) . "</p>";

echo "<h2>Recherche : Khediri</h2>";
$e = rechercherEtudiant($etudiants, "Khediri");
if ($e !== null) {
    afficherEtudiant($e);
} else {
    echo "<p>Étudiant introuvable.</p>";
}

echo "<h2>Admis</h2>";
foreach (obtenirAdmis($etudiants) as $a) {
    echo "<p>{$a['nom']} {$a['prenom']} ({$a['moyenne']})</p>";
}

echo "<h2>Moyenne >= 14</h2>";
foreach (filtrerParMoyenne($etudiants, 14) as $b) {
    echo "<p>{$b['nom']} {$b['prenom']} ({$b['moyenne']})</p>";
}

echo "<h2>Meilleur étudiant</h2>";
$m = trouverMeilleurEtudiant($etudiants);
echo "<p>{$m['nom']} {$m['prenom']} ({$m['moyenne']})</p>";