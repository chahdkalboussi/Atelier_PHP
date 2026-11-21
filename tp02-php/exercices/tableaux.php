<?php

$etudiants = ["Ahmed", "Sami", "Nour", "Amine"];
echo "<p>Index 2 : $etudiants[2]</p>";


for ($i = 0; $i < count($etudiants); $i++) {
    echo "<p>$etudiants[$i]</p>";
}
foreach ($etudiants as $etudiant) {
    echo "<p>$etudiant</p>";
}

$liste = ["Ahmed", "Sami", "Nour", "Amine", "Yassine"];
$liste[] = "Mariem";
array_pop($liste);
echo "<p>Nombre final : " . count($liste) . "</p>";
foreach ($liste as $e) {
    echo "<p>$e</p>";
}


$nomRecherche = "Nour";
if (in_array($nomRecherche, $etudiants)) {
    echo "<p>Étudiant trouvé</p>";
} else {
    echo "<p>Étudiant non trouvé</p>";
}

$etudiant = [
    "nom" => "Khedirii",
    "prenom" => "Ahmed",
    "age" => 20,
    "formation" => "Informatique",
    "moyenne" => 14.5,
    "telephone" => "20123656",
    "ville" => "Kébili",
    "niveau" => "2ème année"
];
foreach ($etudiant as $cle => $valeur) {
    echo "<p>$cle : $valeur</p>";
}

$tous = [
    ["nom" => "Khediri",   "prenom" => "Ahmed", "age" => 20, "moyenne" => 14.5],
    ["nom" => "Ali",       "prenom" => "Sami",  "age" => 21, "moyenne" => 11.5],
    ["nom" => "Ben Salah", "prenom" => "Nour",  "age" => 19, "moyenne" => 16]
];
foreach ($tous as $e) {
    echo "<p>{$e['nom']} {$e['prenom']} - {$e['age']} ans - moyenne {$e['moyenne']}</p>";
}


echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Nom</th><th>Prénom</th><th>Âge</th><th>Moyenne</th></tr>";
foreach ($tous as $e) {
    echo "<tr><td>{$e['nom']}</td><td>{$e['prenom']}</td><td>{$e['age']}</td><td>{$e['moyenne']}</td></tr>";
}
echo "</table>";