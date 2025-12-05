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
$confirm_password = filter_input(INPUT_POST, 'confirm_password', FILTER_DEFAULT);

include_once "/ImmoForm/includes/config.php";
$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

$req = $pdo->prepare("SELECT * FROM contact WHERE Email = :email");
$req->bindParam(':email', $email);
$req->execute();

$emailExiste = $req->fetchAll();

if ($emailExiste[0]["Email"] == $email && $password == $confirm_password && $emailExiste[0]["mdp"] == NULL)
{
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $req = $pdo->prepare("UPDATE contact SET mdp = :password WHERE Email = :email");
    $req->bindParam(':password', $hashedPassword);
    $req->bindParam(':email', $emailExiste[0]["Email"]);
    $req->execute();


    header("Location: /ImmoForm/index.php"); // à changer, et mettre la page post-connection
}

else
{
    header("Location: /ImmoForm/includes/inscription.php");
    echo "Identifiant ou mot de passe non valide ou incorrect";
}