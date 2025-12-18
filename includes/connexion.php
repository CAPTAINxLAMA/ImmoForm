<?php include 'header.php';

session_start();

$token = rand(0, 1000000);
$_SESSION['token'] = $token;

?>

<main>
    <div class="container">
        <form action="../actions/connection.php" method="POST">
            <label>Email :</label>
            <input type="email" name="email" required>

            <label>Mot de passe :</label>
            <input type="password" name="password" required minlength="8">

            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <button class="btn3" type="submit">Se connecter</button>
        </form>

        <a class='btn' href="oublieMDP.php">Mot de passe oublié ?</a>

        <p style="margin-top: 20px;">
            Pas encore de compte ? <a class='btn' href="inscription.php">Créer un compte</a>
        </p>
    </div>
</main>

<?php include 'footer.php'?>
