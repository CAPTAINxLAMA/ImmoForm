<?php include 'header.php';

session_start();

$token = rand(0, 1000000);
$_SESSION['token'] = $token;

?>

<main>
    <div class="container">
        <form action="../actions/forgetPassword.php" method="POST">
            <label>Email :</label>
            <input type="email" name="email" required>

            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <button class="btn3" type="submit">Envoyer un email de vérification</button>
        </form>

        <a class='btn' href="../index.php">Accueil</a>
    </div>
</main>

<?php include 'footer.php'?>
