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

if ($mdpContactAttendu != Null && password_verify($password, $mdpContactAttendu['mdp']))
{
    header("Location: ../client/navbar.php");
}

else if ($mdpAdminAttendu != Null && password_verify($password, $mdpAdminAttendu['mdp']))
{
    header("Location: ../admin/navbar.php");
}

else
{
    header("Location: /ImmoForm/includes/connexion.php");
    echo "Identifiant ou mot de passe incorrect";
}
?>
