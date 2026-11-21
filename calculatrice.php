<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Calculatrice</title></head>
<body>
<h1>Calculatrice</h1>
<form method="get">
    <input type="number" step="any" name="a" placeholder="Nombre 1">
    <input type="number" step="any" name="b" placeholder="Nombre 2">
    <button type="submit">Calculer</button>
</form>
<?php
if (isset($_GET['a'], $_GET['b']) && is_numeric($_GET['a']) && is_numeric($_GET['b'])) {
    $a = $_GET['a'];
    $b = $_GET['b'];
    echo "<p>Somme : " . ($a + $b) . "</p>";
    echo "<p>Différence : " . ($a - $b) . "</p>";
    echo "<p>Produit : " . ($a * $b) . "</p>";
    if ($b == 0) {
        echo "<p>Quotient et reste : division par zéro impossible.</p>";
    } else {
        echo "<p>Quotient : " . ($a / $b) . "</p>";
        echo "<p>Reste : " . ($a % $b) . "</p>";
    }
}
?>
</body>
</html>