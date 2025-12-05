<?php
include_once 'config/config.php';
session_start();
require_once '../config/database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Vérifier que les mots de passe correspondent
    if ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas";
    } else {
        // Vérifier que l'email existe dans les contacts
        $stmt = $pdo->prepare("SELECT * FROM contacts WHERE email = ?");
        $stmt->execute([$email]);
        $contact = $stmt->fetch();

        if (!$contact) {
            $error = "Cet email n'est pas autorisé à créer un compte";
        } else {
            // Vérifier que le compte n'existe pas déjà
            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
            $stmt->execute([$email]);

            if ($stmt->fetch()) {
                $error = "Un compte existe déjà avec cet email";
            } else {
                // Créer le compte
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO utilisateurs (email, password, contact_id) VALUES (?, ?, ?)");

                if ($stmt->execute([$email, $hashed_password, $contact['id']])) {
                    $success = "Compte créé avec succès ! Vous pouvez maintenant vous connecter.";
                } else {
                    $error = "Erreur lors de la création du compte";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Client</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header>
    <h1>Inscription Client</h1>
</header>

<main>
    <div class="container">
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Email :</label>
            <input type="email" name="email" required>

            <label>Mot de passe :</label>
            <input type="password" name="password" required minlength="8">

            <label>Confirmer le mot de passe :</label>
            <input type="password" name="confirm_password" required>

            <button type="submit">S'inscrire</button>
        </form>

        <p style="margin-top: 20px;">
            Déjà un compte ? <a href="connexion.php">Se connecter</a>
        </p>
    </div>
</main>
</body>
</html>