<?php include 'header.php'?>

<main>
    <div class="container">
        <form method="POST">
            <label>Email :</label>
            <input type="email" name="email" required>

            <label>Mot de passe :</label>
            <input type="password" name="password" required>

            <label>Confirmer le mot de passe :</label>
            <input type="password" name="confirm_password" required>

            <button type="submit">S'inscrire</button>
        </form>

        <p style="margin-top: 20px;">
            Déjà un compte ? <a href="connexion.php">Se connecter</a>
        </p>
    </div>
</main>

<?php include 'footer.php'?>