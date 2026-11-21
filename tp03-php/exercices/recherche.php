<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Recherche</title></head>
<body>
<h1>Recherche (GET)</h1>
<form method="GET">
    <input type="text" name="q" placeholder="Mot à chercher">
    <button type="submit">Rechercher</button>
</form>
<?php
if (isset($_GET['q']) && $_GET['q'] !== "") {
    echo "<p>Vous avez cherché : " . htmlspecialchars($_GET['q']) . "</p>";
}
?>
</body>
</html>