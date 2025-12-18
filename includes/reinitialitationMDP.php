<?php include 'header.php';

session_start();

$token = rand(0, 1000000);
$_SESSION['token'] = $token;

?>

<main>
    <div class="container">
        <form action="../actions/forgetPassword.php" method="POST">

            <label>Mot de passe :</label>
            <input type="password" name="password"  required minlength="8">

            <label>Confirmer le mot de passe :</label>
            <input type="password" name="confirm_password"  required minlength="8">

            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <button class="btn3" type="submit">Réinitialiser</button>
        </form>

        <a class='btn' href="../index.php">Accueil</a>
    </div>
</main>

<?php include 'footer.php'?>
