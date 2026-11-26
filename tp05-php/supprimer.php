<?php
require_once __DIR__ . '/connexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit("Méthode non autorisée.");
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id || $id <= 0) {
    exit("Identifiant d'étudiant invalide.");
}

$sql = "DELETE FROM etudiants WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);

if ($stmt->rowCount() === 0) {
    $message = "Aucun étudiant trouvé avec l'identifiant #" . (int) $id . ".";
} else {
    $message = "Étudiant supprimé avec succès.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Suppression d'un étudiant</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Suppression</h1>
    <p><?= htmlspecialchars($message) ?></p>
    <p><a href="liste.php">Retour à la liste</a></p>
</body>
</html>