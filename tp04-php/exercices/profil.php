<?php
session_start();
if (isset($_SESSION['nom'])) {
    echo "<p>Nom : " . htmlspecialchars($_SESSION['nom']) . "</p>";
    echo "<p>Prénom : " . htmlspecialchars($_SESSION['prenom']) . "</p>";
    echo "<p>Formation : " . htmlspecialchars($_SESSION['formation']) . "</p>";
    echo "<p>Âge : " . htmlspecialchars($_SESSION['age']) . "</p>";
    echo "<p>Email : " . htmlspecialchars($_SESSION['email']) . "</p>";
} else {
    echo "Aucune session.";
}