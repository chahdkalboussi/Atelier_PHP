<?php
function resultat($moyenne)
{
    return $moyenne >= 10 ? "Admis" : "Ajourné";
}

function getEtudiants()
{
    return [
        ["nom" => "Khediri",   "prenom" => "Ahmed",   "age" => 20, "formation" => "Informatique", "moyenne" => 14.5],
        ["nom" => "Ali",       "prenom" => "Sami",    "age" => 21, "formation" => "Informatique", "moyenne" => 11.5],
        ["nom" => "Ben Salah", "prenom" => "Nour",    "age" => 19, "formation" => "Informatique", "moyenne" => 16],
        ["nom" => "Trabelsi",  "prenom" => "Amine",   "age" => 22, "formation" => "Informatique", "moyenne" => 8.5],
        ["nom" => "Gharbi",    "prenom" => "Mariem",  "age" => 20, "formation" => "Informatique", "moyenne" => 12.75]
    ];
}

function rechercherParNom($etudiants, $nom)
{
    $trouves = [];
    foreach ($etudiants as $e) {
        if (str_contains(mb_strtolower($e["nom"] . " " . $e["prenom"]), mb_strtolower($nom))) {
            $trouves[] = $e;
        }
    }
    return $trouves;
}

function validerEtudiant($nom, $prenom, $age, $formation, $moyenne)
{
    $erreurs = [];
    if ($nom === "") {
        $erreurs[] = "Le nom est obligatoire.";
    }
    if ($prenom === "") {
        $erreurs[] = "Le prénom est obligatoire.";
    }
    if ($age === "" || !is_numeric($age) || $age < 16 || $age > 40) {
        $erreurs[] = "L'âge doit être compris entre 16 et 40 ans.";
    }
    if ($formation === "") {
        $erreurs[] = "La formation est obligatoire.";
    }
    if ($moyenne === "" || !is_numeric($moyenne) || $moyenne < 0 || $moyenne > 20) {
        $erreurs[] = "La moyenne doit être comprise entre 0 et 20.";
    }
    return $erreurs;
}

function afficherTableau($etudiants)
{
    echo "<table>";
    echo "<tr><th>Nom</th><th>Prénom</th><th>Âge</th><th>Formation</th><th>Moyenne</th><th>Résultat</th></tr>";
    foreach ($etudiants as $e) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($e['nom']) . "</td>";
        echo "<td>" . htmlspecialchars($e['prenom']) . "</td>";
        echo "<td>{$e['age']}</td>";
        echo "<td>" . htmlspecialchars($e['formation']) . "</td>";
        echo "<td>{$e['moyenne']}</td>";
        echo "<td>" . resultat($e['moyenne']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}