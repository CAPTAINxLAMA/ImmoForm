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
    $token = rand(0, 1000000); //génération d'un token aléatoire
    $_SESSION['tokenAccueil'] = $token; //stockage d'un token généré pour l'accueil

    header("Location: /ImmoForm/client/navbar.php"); // à changer, et mettre la page post-connection
}

else
{
    header("Location: /ImmoForm/includes/connexion.php");
    echo "Identifiant ou mot de passe incorrect";
}