<?php
setcookie("langue", "fr", time() + 3600);
setcookie("nom", "Ahmed", time() + 3600);
setcookie("theme", "sombre", time() + 3600);
echo "Cookies créés.<br>";

foreach (["langue", "nom", "theme"] as $c) {
    if (isset($_COOKIE[$c])) {
        echo "$c : " . htmlspecialchars($_COOKIE[$c]) . "<br>";
    } else {
        echo "$c : cookie absent.<br>";
    }
}