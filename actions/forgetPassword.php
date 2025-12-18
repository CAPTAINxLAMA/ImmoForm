<?php

session_start();
$tokenServeur = $_SESSION['token'];
$tokenRecu = filter_input(INPUT_POST, 'token', FILTER_DEFAULT);

//Je vérifie la cohérence des tokens
if ($tokenRecu != $tokenServeur) {
    die("Erreur de token. Vas mourir vilain hacker");//je stop tout
}

$email = filter_input(INPUT_POST, 'email', FILTER_DEFAULT);

include_once "../includes/config.php";

$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

$reqContact = $pdo->prepare("SELECT * FROM contact WHERE Email = :email");
$reqAdmin = $pdo->prepare("SELECT * FROM formateur WHERE Email = :email");
$reqContact->bindParam(':email', $email);
$reqAdmin->bindParam(':email', $email);
$reqContact->execute();
$reqAdmin->execute();

if ($reqAdmin->fetch())
{
    // Générer un token sécurisé
    $token = rand(0, 1000000);
    $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

    // Enregistrer le token en DB
    $req = $pdo->prepare("UPDATE formateur SET reset_token = :reset_token, reset_token_expiry = :reset_token_expiry WHERE email = :email");
    $req->bindParam(':reset_token', $token);
    $req->bindParam(':reset_token_expiry', $expiry);
    $req->bindParam(':email', $email);
    $req->execute();

    // Préparer l'email
    $reset_link = "http://localhost:63342/ImmoForm/includes/reinitialisationMDP.php?token=" . $token;
    $subject = "Réinitialisation de votre mot de passe";
    $message = "Bonjour,\n\n";
    $message .= "Vous avez demandé la réinitialisation de votre mot de passe.\n";
    $message .= "Cliquez sur ce lien pour réinitialiser votre mot de passe :\n\n";
    $message .= $reset_link . "\n\n";
    $message .= "Ce lien expire dans 1 heure.\n";
    $message .= "Si vous n'avez pas fait cette demande, ignorez cet email.";

    $headers = "From: admin@io\r\n";

    // Envoyer l'email
    mail($email, $subject, $message, $headers);
}

else if ($reqContact->fetch())
{
    // Générer un token sécurisé
    $token = rand(0, 1000000);
    $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

    // Enregistrer le token en DB
    $req = $pdo->prepare("UPDATE contact SET reset_token = :reset_token, reset_token_expiry = :reset_token_expiry WHERE email = :email");
    $req->bindParam(':reset_token', $token);
    $req->bindParam(':reset_token_expiry', $expiry);
    $req->bindParam(':email', $email);
    $req->execute();


    // Préparer l'email
    $reset_link = "http://localhost:63342/ImmoForm/includes/reinitialisationMDP.php?token=" . $token;
    $subject = "Réinitialisation de votre mot de passe";
    $message = "Bonjour,\n\n";
    $message .= "Vous avez demandé la réinitialisation de votre mot de passe.\n";
    $message .= "Cliquez sur ce lien pour réinitialiser votre mot de passe :\n\n";
    $message .= $reset_link . "\n\n";
    $message .= "Ce lien expire dans 1 heure.\n";
    $message .= "Si vous n'avez pas fait cette demande, ignorez cet email.";

    $headers = "From: admin@io\r\n";

    // Envoyer l'email
    mail($email, $subject, $message, $headers);
}

else
{
    header("Location: ../includes/forgetPassword.php");
}