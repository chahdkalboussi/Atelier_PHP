<?php
function afficherBonjour($nom = "")
{
    echo "Bonjour " . $nom;
}

function additionner($a, $b)
{
    return $a + $b;
}

function calculerMoyenne($note1, $note2, $note3)
{
    return ($note1 + $note2 + $note3) / 3;
}

function determinerResultat($moyenne)
{
    if ($moyenne >= 10) {
        return "Admis";
    }
    return "Ajourné";
}

function appreciation($moyenne)
{
    if ($moyenne < 10) {
        return "Insuffisant";
    } elseif ($moyenne < 12) {
        return "Passable";
    } elseif ($moyenne < 14) {
        return "Assez bien";
    } elseif ($moyenne < 16) {
        return "Bien";
    }
    return "Très bien";
}

function afficherEtudiant($etudiant)
{
    echo "<p>Nom : {$etudiant['nom']}</p>";
    echo "<p>Prénom : {$etudiant['prenom']}</p>";
    echo "<p>Âge : {$etudiant['age']}</p>";
    echo "<p>Moyenne : {$etudiant['moyenne']}</p>";
    echo "<p>Résultat : " . determinerResultat($etudiant['moyenne']) . "</p>";
    echo "<p>Appréciation : " . appreciation($etudiant['moyenne']) . "</p>";
}

function calculerMoyenneClasse($etudiants)
{
    if (count($etudiants) === 0) {
        return 0;
    }
    $somme = 0;
    foreach ($etudiants as $etudiant) {
        $somme += $etudiant["moyenne"];
    }
    return $somme / count($etudiants);
}

function rechercherEtudiant($etudiants, $nom)
{
    foreach ($etudiants as $etudiant) {
        if (strtolower($etudiant["nom"]) === strtolower($nom)) {
            return $etudiant;
        }
    }
    return null;
}

function obtenirAdmis($etudiants)
{
    $admis = [];
    foreach ($etudiants as $etudiant) {
        if ($etudiant["moyenne"] >= 10) {
            $admis[] = $etudiant;
        }
    }
    return $admis;
}

function filtrerParMoyenne($etudiants, $moyenneMinimale)
{
    $resultat = [];
    foreach ($etudiants as $etudiant) {
        if ($etudiant["moyenne"] >= $moyenneMinimale) {
            $resultat[] = $etudiant;
        }
    }
    return $resultat;
}

function trouverMeilleurEtudiant($etudiants)
{
    if (count($etudiants) === 0) {
        return null;
    }
    $meilleur = $etudiants[0];
    foreach ($etudiants as $etudiant) {
        if ($etudiant["moyenne"] > $meilleur["moyenne"]) {
            $meilleur = $etudiant;
        }
    }
    return $meilleur;
}

function getEtudiants()
{
    return [
        ["nom" => "Khediri",   "prenom" => "Ahmed",   "age" => 20, "moyenne" => 14.5],
        ["nom" => "Ali",       "prenom" => "Sami",    "age" => 21, "moyenne" => 11.5],
        ["nom" => "Ben Salah", "prenom" => "Nour",    "age" => 19, "moyenne" => 16],
        ["nom" => "Trabelsi",  "prenom" => "Amine",   "age" => 22, "moyenne" => 8.5],
        ["nom" => "Gharbi",    "prenom" => "Mariem",  "age" => 20, "moyenne" => 12.75],
        ["nom" => "Jlassi",    "prenom" => "Yassine", "age" => 21, "moyenne" => 9.5]
    ];
}