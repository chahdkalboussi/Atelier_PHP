<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Moyenne</title></head>
<body>
<h1>Calcul de la moyenne</h1>
<form method="get">
    <input type="number" step="0.01" name="note1" placeholder="Note 1">
    <input type="number" step="0.01" name="note2" placeholder="Note 2">
    <input type="number" step="0.01" name="note3" placeholder="Note 3">
    <button type="submit">Calculer</button>
</form>
<?php
if (isset($_GET['note1'], $_GET['note2'], $_GET['note3'])
    && is_numeric($_GET['note1']) && is_numeric($_GET['note2']) && is_numeric($_GET['note3'])) {
    $moyenne = ($_GET['note1'] + $_GET['note2'] + $_GET['note3']) / 3;

    if ($moyenne < 10) {
        $appreciation = "Insuffisant";
    } elseif ($moyenne < 12) {
        $appreciation = "Passable";
    } elseif ($moyenne < 14) {
        $appreciation = "Assez bien";
    } elseif ($moyenne < 16) {
        $appreciation = "Bien";
    } else {
        $appreciation = "Très bien";
    }
    echo "<p>Moyenne : " . round($moyenne, 2) . "</p>";
    echo "<p>Appréciation : $appreciation</p>";
}
?>
</body>
</html>