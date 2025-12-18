<?php

session_start();

include_once "../includes/config.php";

$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

$tokenmail = filter_input(INPUT_GET, 'token', FILTER_DEFAULT);

$req = $pdo->prepare("SELECT id, email, reset_token FROM users WHERE reset_token = :reset_token AND reset_token_expiry > NOW()");
$req->bindParam(':reset_token', $tokenmail);

$req->execute();

if ($req->fetch()) {
    $token = filter_input(INPUT_POST, 'token', FILTER_DEFAULT);
    $password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);
    $confirm_password = filter_input(INPUT_POST, 'confirm_password', FILTER_DEFAULT);
    $email = $req->fetchAll()[0]["email"];
    // Vérifications
    if ($password !== $confirm_password) {
        header("Location: ../includes/reinitialisationMDP.php?token=" . $tokenmail);
    }
    else
    {
        // Vérifier le token
        $reqContact = $pdo->prepare("SELECT * FROM contact WHERE Email = :email");
        $reqAdmin = $pdo->prepare("SELECT * FROM formateur WHERE Email = :email");
        $reqContact->bindParam(':email', $email);
        $reqAdmin->bindParam(':email', $email);
        $reqContact->execute();
        $reqAdmin->execute();

        $emailContactExiste = $reqContact->fetchAll();
        $emailAdminExiste = $reqAdmin->fetchAll();

        if ($emailContactExiste[0]["Email"] == $email && $password == $confirm_password && $emailContactExiste[0]["mdp"] == NULL)
        {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $req = $pdo->prepare("UPDATE contact SET mdp = :password WHERE Email = :email");
            $req->bindParam(':password', $hashedPassword);
            $req->bindParam(':email', $emailContactExiste[0]["Email"]);
            $req->execute();

            header("Location: /ImmoForm/includes/connexion.php");
        }
        else if ($emailAdminExiste[0]["Email"] == $email && $password == $confirm_password && $emailAdminExiste[0]["mdp"] == NULL)
        {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $req = $pdo->prepare("UPDATE formateur SET mdp = :password WHERE Email = :email");
            $req->bindParam(':password', $hashedPassword);
            $req->bindParam(':email', $emailAdminExiste[0]["Email"]);
            $req->execute();

            header("Location: /ImmoForm/includes/connexion.php");
        }
        else
        {
            header("Location: ../includes/reinitialisationMDP.php?token=" . $tokenmail);
        }
    }
}