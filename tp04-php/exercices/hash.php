<?php
$password = "123456";
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Hash : $hash<br>";

foreach (["123456", "abcdef"] as $test) {
    if (password_verify($test, $hash)) {
        echo "$test : Mot de passe correct.<br>";
    } else {
        echo "$test : Mot de passe incorrect.<br>";
    }
}