<?php
$classe = [
    ["nom" => "Khediri",   "prenom" => "Ahmed",   "age" => 20, "formation" => "Informatique", "moyenne" => 14.5],
    ["nom" => "Ali",       "prenom" => "Sami",    "age" => 21, "formation" => "Informatique", "moyenne" => 11.5],
    ["nom" => "Ben Salah", "prenom" => "Nour",    "age" => 19, "formation" => "Informatique", "moyenne" => 16],
    ["nom" => "Trabelsi",  "prenom" => "Amine",   "age" => 22, "formation" => "Informatique", "moyenne" => 8.5],
    ["nom" => "Gharbi",    "prenom" => "Mariem",  "age" => 20, "formation" => "Informatique", "moyenne" => 12.75],
    ["nom" => "Jlassi",    "prenom" => "Yassine", "age" => 21, "formation" => "Informatique", "moyenne" => 9.5],
    ["nom" => "Mansouri",  "prenom" => "Salma",   "age" => 20, "formation" => "Informatique", "moyenne" => 15.25],
    ["nom" => "Hamdi",     "prenom" => "Karim",   "age" => 23, "formation" => "Informatique", "moyenne" => 10],
    ["nom" => "Ayari",     "prenom" => "Rim",     "age" => 19, "formation" => "Informatique", "moyenne" => 17.5],
    ["nom" => "Zouari",    "prenom" => "Walid",   "age" => 21, "formation" => "Informatique", "moyenne" => 7.75]
];

function afficherTous($classe)
{
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Nom</th><th>Prénom</th><th>Âge</th><th>Formation</th><th>Moyenne</th></tr>";
    foreach ($classe as $e) {
        echo "<tr><td>{$e['nom']}</td><td>{$e['prenom']}</td><td>{$e['age']}</td><td>{$e['formation']}</td><td>{$e['moyenne']}</td></tr>";
    }
    echo "</table>";
}

function moyenneClasse($classe)
{
    $s = 0;
    foreach ($classe as $e) {
        $s += $e['moyenne'];
    }
    return $s / count($classe);
}

function compterAdmis($classe)
{
    $c = 0;
    foreach ($classe as $e) {
        if ($e['moyenne'] >= 10) {
            $c++;
        }
    }
    return $c;
}

function chercherNom($classe, $nom)
{
    foreach ($classe as $e) {
        if ($e['nom'] === $nom) {
            return $e;
        }
    }
    return null;
}

function filtrerMoyenneMin($classe, $min)
{
    $r = [];
    foreach ($classe as $e) {
        if ($e['moyenne'] >= $min) {
            $r[] = $e;
        }
    }
    return $r;
}

function meilleureMoyenne($classe)
{
    $max = $classe[0]['moyenne'];
    foreach ($classe as $e) {
        if ($e['moyenne'] > $max) {
            $max = $e['moyenne'];
        }
    }
    return $max;
}

function plusFaibleMoyenne($classe)
{
    $min = $classe[0]['moyenne'];
    foreach ($classe as $e) {
        if ($e['moyenne'] < $min) {
            $min = $e['moyenne'];
        }
    }
    return $min;
}

function pourcentageAdmis($classe)
{
    return compterAdmis($classe) * 100 / count($classe);
}

echo "<h1>Gestion d'une classe</h1>";
afficherTous($classe);
echo "<p>Moyenne de la classe : " . round(moyenneClasse($classe), 2) . "</p>";
echo "<p>Nombre d'admis : " . compterAdmis($classe) . "</p>";

$e = chercherNom($classe, "Ayari");
echo "<p>Recherche Ayari : " . ($e ? "{$e['nom']} {$e['prenom']}" : "introuvable") . "</p>";

echo "<p>Étudiants avec moyenne >= 14 : " . count(filtrerMoyenneMin($classe, 14)) . "</p>";
echo "<p>Meilleure moyenne : " . meilleureMoyenne($classe) . "</p>";
echo "<p>Plus faible moyenne : " . plusFaibleMoyenne($classe) . "</p>";
echo "<p>Pourcentage d'admis : " . pourcentageAdmis($classe) . " %</p>";