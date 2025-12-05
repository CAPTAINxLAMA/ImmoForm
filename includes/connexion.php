<?php include 'header.php'?>

<main>
    <div class="container">
        <form method="POST">
            <label>Email :</label>
            <input type="email" name="email" required>

            <label>Mot de passe :</label>
            <input type="password" name="password" required minlength="8">

            <button type="submit">Se connecter</button>
        </form>

        <p style="margin-top: 20px;">
            Pas encore de compte ? <a href="inscription.php">Créer un compte</a>
        </p>
    </div>
</main>

<?php include 'footer.php'?>
