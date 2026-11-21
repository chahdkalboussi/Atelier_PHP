<?php
$note = 13;

if ($note < 10) {
    echo "<p>Ajourné</p>";
} else {
    echo "<p>Admis</p>";
}

if ($note < 10) {
    $mention = "Ajourné";
} elseif ($note < 12) {
    $mention = "Passable";
} elseif ($note < 14) {
    $mention = "Assez bien";
} elseif ($note < 16) {
    $mention = "Bien";
} else {
    $mention = "Très bien";
}
echo "<p>Note : $note - Mention :
 $mention</p>"; 