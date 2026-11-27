<?php
require 'auth.php';
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Don de Sang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Don de Sang</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Tableau de bord</a></li>

                <?php if (in_array($role, ['ADMIN', 'SECRETAIRE'])): ?>
                    <li class="nav-item"><a class="nav-link" href="donneurs.php">Donneurs</a></li>
                    <li class="nav-item"><a class="nav-link" href="dons.php">Dons</a></li>
                <?php endif; ?>

                <?php if (in_array($role, ['ADMIN', 'MEDECIN'])): ?>
                    <li class="nav-item"><a class="nav-link" href="tests.php">Tests</a></li>
                <?php endif; ?>

                <?php if ($role === 'ADMIN'): ?>
                    <li class="nav-item"><a class="nav-link" href="transfusions.php">Transfusions</a></li>
                    <li class="nav-item"><a class="nav-link" href="utilisateurs.php">Utilisateurs</a></li>
                    <li class="nav-item"><a class="nav-link" href="centres.php">Centres</a></li>
                <?php endif; ?>
            </ul>
            <span class="navbar-text me-3"><?= htmlspecialchars($role) ?></span>
            <a href="logout.php" class="btn btn-light btn-sm">Déconnexion</a>
        </div>
    </div>
</nav>
<div class="container mt-4">