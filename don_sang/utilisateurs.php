<?php
require 'header.php';
exiger_role(['ADMIN']);

$message = '';

// 1. Si le formulaire est envoyé
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom_utilisateur'];
    $mdp = $_POST['mot_de_passe'];
    $role = $_POST['role'];
    $centre = $_POST['id_centre'];

    // 2. Chiffrer le mot de passe
    $hash = password_hash($mdp, PASSWORD_DEFAULT);

    // 3. Insérer dans la base (requête préparée)
    try {
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom_utilisateur, mot_de_passe, role, id_centre) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nom, $hash, $role, $centre]);
        $message = "Utilisateur ajouté.";
    } catch (PDOException $e) {
        $message = "Erreur : nom d'utilisateur déjà utilisé.";
    }
}

// 4. Lire les centres et les utilisateurs
$centres = $pdo->query("SELECT * FROM centres_collecte")->fetchAll();
$users = $pdo->query("SELECT * FROM utilisateurs")->fetchAll();
?>

<h2>Utilisateurs</h2>

<?php if ($message): ?>
    <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="post" class="row g-2 mb-4">
    <div class="col-md-3">
        <input name="nom_utilisateur" class="form-control" placeholder="Utilisateur" required>
    </div>
    <div class="col-md-3">
        <input type="password" name="mot_de_passe" class="form-control" placeholder="Mot de passe" required>
    </div>
    <div class="col-md-2">
        <select name="role" class="form-select">
            <option>ADMIN</option>
            <option>MEDECIN</option>
            <option>SECRETAIRE</option>
        </select>
    </div>
    <div class="col-md-3">
        <select name="id_centre" class="form-select">
            <?php foreach ($centres as $c): ?>
                <option value="<?= $c['id_centre'] ?>"><?= htmlspecialchars($c['nom']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-1">
        <button class="btn btn-danger w-100">OK</button>
    </div>
</form>

<table class="table table-striped table-bordered">
    <tr><th>Utilisateur</th><th>Rôle</th></tr>
    <?php foreach ($users as $u): ?>
        <tr>
            <td><?= htmlspecialchars($u['nom_utilisateur']) ?></td>
            <td><?= htmlspecialchars($u['role']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require 'footer.php'; ?>