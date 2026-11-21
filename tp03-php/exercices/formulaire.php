<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Formulaire GET</title></head>
<body>
<form method="GET">
    <p><label>Nom : <input type="text" name="nom"></label></p>
    <p><label>Prénom : <input type="text" name="prenom"></label></p>
    <p><label>Âge : <input type="number" name="age"></label></p>
    <p><label>Formation : <input type="text" name="formation"></label></p>
    <button type="submit">Envoyer</button>
</form>

<?php
if (isset($_GET['nom'], $_GET['prenom'], $_GET['age'], $_GET['formation'])) {
    echo "Nom : " . htmlspecialchars($_GET['nom']) . "<br>";
    echo "Prénom : " . htmlspecialchars($_GET['prenom']) . "<br>";
    echo "Âge : " . htmlspecialchars($_GET['age']) . "<br>";
    echo "Formation : " . htmlspecialchars($_GET['formation']);
} else {
    echo "<p>Veuillez remplir le formulaire.</p>";
}
?>
</body>
</html>