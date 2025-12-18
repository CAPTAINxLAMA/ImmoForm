<?php

session_start();
$tokenServeur= $_SESSION['token'];
$tokenRecu=filter_input(INPUT_POST, 'token', FILTER_DEFAULT);

//je vérifie la cohérence des tokens
if($tokenRecu != $tokenServeur){
    die("Erreur de token. Va mourir vilain hacker.");
}

$Id=filter_input(INPUT_POST, 'Id', FILTER_VALIDATE_INT);

include "../includes/config.php";
$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

$req=$pdo->prepare("delete from conseil where Id=:Id");
$req->bindParam(':Id', $Id);

$req->execute();

//retour à la page d'accueil
header("Location: ../Admin/mes_creations.php");
