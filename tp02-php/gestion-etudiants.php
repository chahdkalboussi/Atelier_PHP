<?php
require_once "fonctions.php";

$etudiants = getEtudiants();
$nomRecherche = isset($_GET['nom']) ? trim($_GET['nom']) : "";
$moyenneMin = (isset($_GET['min']) && is_numeric($_GET['min'])) ? (float) $_GET['min'] : null;
$meilleur = trouverMeilleurEtudiant($etudiants);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Gestion des étudiants</title>
</head>
<body>
<h1>Gestion des étudiants</h1>

<h2>Liste</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>Nom</th><th>Prénom</th><th>Âge</th>
        <th>Moyenne</th><th>Résultat</th><th>Appréciation</th>
    </tr>
    <?php foreach ($etudiants as $e): ?>
    <tr>
        <td><?php echo htmlspecialchars($e['nom']); ?></td>
        <td><?php echo htmlspecialchars($e['prenom']); ?></td>
        <td><?php echo $e['age']; ?></td>
        <td><?php echo $e['moyenne']; ?></td>
        <td><?php echo determinerResultat($e['moyenne']); ?></td>
        <td><?php echo appreciation($e['moyenne']); ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<h2>Statistiques</h2>
<p>Nombre d'étudiants : <?php echo count($etudiants); ?></p>
<p>Moyenne de la classe : <?php echo round(calculerMoyenneClasse($etudiants), 2); ?></p>
<p>Nombre d'admis : <?php echo count(obtenirAdmis($etudiants)); ?></p>
<p>Meilleur étudiant : <?php echo "{$meilleur['nom']} {$meilleur['prenom']} ({$meilleur['moyenne']})"; ?></p>

<h2>Recherche par nom</h2>
<form method="get">
    <input type="text" name="nom" placeholder="Nom" value="<?php echo htmlspecialchars($nomRecherche); ?>">
    <button type="submit">Rechercher</button>
</form>
<?php
if ($nomRecherche !== "") {
    $trouve = rechercherEtudiant($etudiants, $nomRecherche);
    if ($trouve !== null) {
        afficherEtudiant($trouve);
    } else {
        echo "<p>Étudiant introuvable.</p>";
    }
}
?>

<h2>Filtrer par moyenne minimale</h2>
<form method="get">
    <input type="number" step="0.01" name="min" placeholder="Moyenne minimale">
    <button type="submit">Filtrer</button>
</form>
<?php
if ($moyenneMin !== null) {
    $filtres = filtrerParMoyenne($etudiants, $moyenneMin);
    echo "<p>Étudiants avec moyenne >= $moyenneMin : " . count($filtres) . "</p>";
    foreach ($filtres as $f) {
        echo "<p>{$f['nom']} {$f['prenom']} ({$f['moyenne']})</p>";
    }
}
?>
</body>
</html>