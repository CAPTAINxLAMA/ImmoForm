<?php
session_start();
$tokenServeur = $_SESSION['token'];
$tokenRecu = filter_input(INPUT_POST, 'token', FILTER_VALIDATE_INT);

// Vérification la cohérence des tokens
if($tokenRecu != $tokenServeur)
{
    die("Erreur de token. Va mourir vilain hacker.");
}

// Récupération des données de login
$email = filter_input(INPUT_POST, 'email', FILTER_DEFAULT);
$password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);

// Connexion à la base de données
include_once "../includes/config.php";
$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

// Envoie de la requête SQL
$reqContact = $pdo->prepare("SELECT mdp, Id FROM contact WHERE Email = :email");
$reqAdmin = $pdo->prepare("SELECT mdp, Id FROM formateur WHERE Email = :email");
$reqContact->bindParam(':email', $email);
$reqAdmin->bindParam(':email', $email);
$reqContact->execute();
$reqAdmin->execute();

$ContactAttendu = $reqContact->fetchAll();
$AdminAttendu = $reqAdmin->fetchAll();

if ($ContactAttendu != Null && password_verify($password, $ContactAttendu[0]['mdp']))
{
    session_regenerate_id(true); // cette ligne permet de générer un nouvel id de session à chaque connection, limite les attaques

    $_SESSION['user'] = ['id' => $ContactAttendu[0]['Id'], 'email' => $email, 'role' => "client"];

    header("Location: ../client/navbar.php");
}

else if ($AdminAttendu != Null && password_verify($password, $AdminAttendu[0]['mdp']))
{
    session_regenerate_id(true); // cette ligne permet de générer un nouvel id de session à chaque connection, limite les attaques

    $_SESSION['user'] = ['id' => $AdminAttendu[0]['Id'], 'email' => $email, 'role' => "admin"];

    header("Location: ../admin/navbar.php");
}

else
{
    header("Location: /ImmoForm/includes/connexion.php");
    echo "Identifiant ou mot de passe incorrect";
}
?>
