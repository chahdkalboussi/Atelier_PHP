<?php
$notes = [12, 15, 9, 14, 16];

function somme($notes)
{
    $s = 0;
    foreach ($notes as $n) {
        $s += $n;
    }
    return $s;
}

function moyenneNotes($notes)
{
    return somme($notes) / count($notes);
}

function maximum($notes)
{
    $max = $notes[0];
    foreach ($notes as $n) {
        if ($n > $max) {
            $max = $n;
        }
    }
    return $max;
}

function minimum($notes)
{
    $min = $notes[0];
    foreach ($notes as $n) {
        if ($n < $min) {
            $min = $n;
        }
    }
    return $min;
}

function compterSuperieurA10($notes)
{
    $c = 0;
    foreach ($notes as $n) {
        if ($n >= 10) {
            $c++;
        }
    }
    return $c;
}

echo "<p>Somme : " . somme($notes) . "</p>";
echo "<p>Moyenne : " . moyenneNotes($notes) . "</p>";
echo "<p>Maximum : " . maximum($notes) . "</p>";
echo "<p>Minimum : " . minimum($notes) . "</p>";
echo "<p>Notes >= 10 : " . compterSuperieurA10($notes) . "</p>";