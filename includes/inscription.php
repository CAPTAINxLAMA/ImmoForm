<?php include 'header.php';

session_start(); //permet d'initialiser un session pour enregistrer côté serveur le token envoyé à l'utilisateur

$token = rand(0, 1000000); //génération d'un token aléatoire
$_SESSION['token'] = $token; //stockage d'u token généré

?>

<main>
    <div class="container">
        <form action="/ImmoForm/actions/createAccount.php" method="POST">
            <label>Email :</label>
            <input type="email" name="email" required>

            <label>Mot de passe :</label>
            <input type="password" name="password"  required minlength="8">

            <label>Confirmer le mot de passe :</label>
            <input type="password" name="confirm_password"  required minlength="8">

            <input type="hidden" name="token" value="<?php echo $token; ?>"><!--envoi d'un token caché dans le formulaire afin d'éviter un envoi de requet automatique-->
            <button type="submit">S'inscrire</button>
        </form>

        <p style="margin-top: 20px;">
            Déjà un compte ? <a class='btn' href="connexion.php">Se connecter</a>
        </p>
    </div>
</main>

<?php include 'footer.php'?>