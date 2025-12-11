<?php

session_start();
$tokenServeur = $_SESSION['token'];
$tokenRecu = filter_input(INPUT_POST, 'token', FILTER_DEFAULT);

//Je vérifie la cohérence des tokens
if ($tokenRecu != $tokenServeur) {
    die("Erreur de token. Vas mourir vilain hacker");//je stop tout
}

$email = filter_input(INPUT_POST, 'email', FILTER_DEFAULT);
$password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);

include_once "/ImmoForm/includes/config.php";
$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

$req = $pdo->prepare("SELECT mdp FROM contact WHERE Email = :email");
$req->bindParam(':email', $email);
$req->execute();

$mdpAttendu = $req->fetch();

if (password_verify($password, $mdpAttendu['mdp']))
{
    $tokenAccueil = rand(0, 1000000); //génération d'un token aléatoire
    $_SESSION['tokenAccueil'] = $tokenAccueil; //stockage d'un token généré pour l'accueil
    ?>
    <form action="/ImmoForm/client/navbar.php" method="post" id="autoForm">
        <input type="hidden" name="tokenAccueil" value="<?php echo $tokenAccueil ?>">
    </form>

    <script>
        document.getElementById('autoForm').submit(); // permet l'auto envoie du formulaire. A ne pas tenir compte, c'est du JS
    </script>

    <?php
}

else
{
    header("Location: /ImmoForm/includes/connexion.php");
    echo "Identifiant ou mot de passe incorrect";
}