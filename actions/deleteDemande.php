
<?php
session_start();
$tokenServeur= $_SESSION['token'];
$tokenRecu=filter_input(INPUT_POST, 'token', FILTER_DEFAULT);

//je vérifie la cohérence des tokens
if($tokenRecu != $tokenServeur){
    die("Erreur de token. Va mourir vilain hacker.");//je stoppe tout
}

//on récupère les données du POST
$Type=filter_input(INPUT_POST, 'Type', FILTER_DEFAULT);
$Description=filter_input(INPUT_POST, 'Description', FILTER_DEFAULT);
$Id=filter_input(INPUT_POST, 'Id', FILTER_VALIDATE_INT);

include "../includes/config.php";
$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//on prépare la requête avec des bindParam pour éviter les injections SQL
$req=$pdo->prepare("delete from  demandeconseil where Id=:Id");
$req->bindParam(':Id', $Id);

$req->execute();

//retour à la page d'accueil
header("Location: ../client/mes_demandes.php");
