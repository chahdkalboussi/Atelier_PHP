<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Table de multiplication</title></head>
<body>
<h1>Table de multiplication</h1>
<form method="get">
    <input type="number" name="n" placeholder="Nombre">
    <button type="submit">Afficher</button>
</form>
<?php
if (isset($_GET['n']) && is_numeric($_GET['n'])) {
    $n = (int) $_GET['n'];
    echo "<table border='1' cellpadding='5'>";
    for ($i = 1; $i <= 10; $i++) {
        $r = $n * $i;
        echo "<tr><td>$n × $i</td><td>= $r</td></tr>";
    }
    echo "</table>";
}
?>
</body>
</html>