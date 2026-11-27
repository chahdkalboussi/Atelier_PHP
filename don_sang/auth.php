<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['id_utilisateur'])) {
    header('Location: login.php');
    exit;
}

function exiger_role(array $roles) {
    if (!in_array($_SESSION['role'], $roles)) {
        http_response_code(403);
        die("Accès refusé.");
    }
}