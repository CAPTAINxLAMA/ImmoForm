<?php
session_start();
$tokenServeur= $_SESSION['token'];
$tokenRecu=filter_input(INPUT_POST, 'token', FILTER_DEFAULT);

//je vérifie la cohérence des tokens
if($tokenRecu != $tokenServeur){
    die("Erreur de token. Va mourir vilain hacker.");//je stoppe tout
}

$Id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$Rejet = filter_input(INPUT_POST, 'formateur_id', FILTER_DEFAULT);

include "../includes/config.php";

$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

$req=$pdo->prepare('update demandeconseil set Statut="Refusé", Formateur_Id=:Rejet where Id=:Id');
$req->bindParam(':Id', $Id);
$req->bindParam(':Rejet', $Rejet);

$req->execute();

header("Location: ../admin/gererDemandes.php");
