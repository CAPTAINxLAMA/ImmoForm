<?php include 'header.php';

session_start();

$token = rand(0, 1000000);
$_SESSION['token'] = $token;

?>

<main>
    <div class="container">
        <form action="../actions/createAccount.php" method="POST">
            <label>Email :</label>
            <input type="email" name="email" required>

            <label>Mot de passe :</label>
            <input type="password" name="password"  required minlength="8">

            <label>Confirmer le mot de passe :</label>
            <input type="password" name="confirm_password"  required minlength="8">

            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <button class="btn3" type="submit">S'inscrire</button>
        </form>

        <p style="margin-top: 20px;">
            Déjà un compte ? <a class='btn' href="connexion.php">Se connecter</a>
        </p>
    </div>
</main>

<?php include 'footer.php'?>