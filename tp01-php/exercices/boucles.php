<?php
echo "<h3>1 à 20</h3>";
for ($i = 1; $i <= 20; $i++) {
    echo "<p>$i</p>";
}

echo "<h3>Nombres pairs</h3>";
for ($i = 1; $i <= 20; $i++) {
    if ($i % 2 == 0) {
        echo "<p>$i</p>";
    }
}

echo "<h3>Table de 5</h3>";
for ($i = 1; $i <= 10; $i++) {
    $r = 5 * $i;
    echo "<p>5 × $i = $r</p>";
}

echo "<h3>10 à 1</h3>";
for ($i = 10; $i >= 1; $i--) {
    echo "<p>$i</p>";
}