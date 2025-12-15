<?php

session_start();
$tokenServeur = $_SESSION['token'];
$tokenRecu = filter_input(INPUT_POST, 'token', FILTER_DEFAULT);

//Je vérifie la cohérence des tokens
if ($tokenRecu != $tokenServeur) {
    die("Erreur de token. Vas mourir vilain hacker");//je stop tout
}

// Récupération des données de login
$email = filter_input(INPUT_POST, 'email', FILTER_DEFAULT);
$password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);

// Interrogation de la base de donnée
include_once "/ImmoForm/includes/config.php";
$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

$reqContact = $pdo->prepare("SELECT mdp FROM contact WHERE Email = :email");
$reqAdmin = $pdo->prepare("SELECT mdp FROM formateur WHERE Email = :email");
$reqContact->bindParam(':email', $email);
$reqAdmin->bindParam(':email', $email);
$reqContact->execute();
$reqAdmin->execute();

$mdpContactAttendu = $reqContact->fetch();
$mdpAdminAttendu = $reqAdmin->fetch();

$tokenAccueil = rand(0, 1000000); //génération d'un token aléatoire
$_SESSION['tokenAccueil'] = $tokenAccueil; //stockage d'un token généré pour l'accueil
var_dump($mdpContactAttendu);
if (password_verify($password, $mdpContactAttendu['mdp']))
{
    ?>
    <!--Formulaire d'envoi d'un token de vérification, si la connection a fonctionnée-->
    <form action="../client/navbar.php" method="post" id="autoForm">
        <input type="hidden" name="tokenAccueil" value="<?php echo $tokenAccueil ?>">
    </form>
    <?php
}

else if (password_verify($password, $mdpAdminAttendu['mdp']))
{
    ?>
    <!--Formulaire d'envoi d'un token de vérification, si la connection a fonctionnée-->
    <form action="../admin/navbar.php" method="post" id="autoForm">
        <input type="hidden" name="tokenAccueil" value="<?php echo $tokenAccueil ?>">
    </form>
    <script>
        document.getElementById('autoForm').submit(); // permet l'auto envoie du formulaire. A ne pas tenir compte, c'est du JS
    </script>
    <?php
}

else
{
    echo "Identifiant ou mot de passe incorrect";
}
?>
