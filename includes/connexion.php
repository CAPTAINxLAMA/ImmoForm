<?php include 'header.php';

session_start(); //permet d'initialiser un session pour enregistrer côté serveur le token envoyé à l'utilisateur

$token = rand(0, 1000000); //génération d'un token aléatoire
$_SESSION['token'] = $token; //stockage d'u token généré

?>

<main>
    <div class="container">
        <form action="/ImmoForm/actions/connection.php" method="POST">
            <label>Email :</label>
            <input type="email" name="email" required>

            <label>Mot de passe :</label>
            <input type="password" name="password" required minlength="8">

            <input type="hidden" name="token" value="<?php echo $token; ?>"><!--envoi d'un token caché dans le formulaire afin d'éviter un envoi de requet automatique-->
            <button type="submit">Se connecter</button>
        </form>

        <p style="margin-top: 20px;">
            Pas encore de compte ? <a class='btn' href="inscription.php">Créer un compte</a>
        </p>
    </div>
</main>

<?php include 'footer.php'?>
