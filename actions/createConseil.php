<?php

session_start();

$tokenServeur = $_SESSION['token'];
$tokenRecu = filter_input(INPUT_POST, 'token', FILTER_DEFAULT);

if ($tokenRecu != $tokenServeur) {
    die("Erreur de token. Vas mourir vilain hacker");
}

$Titre = filter_input(INPUT_POST, 'titre', FILTER_DEFAULT);
$Description = filter_input(INPUT_POST, 'description', FILTER_DEFAULT);
$Demande_Id = filter_input(INPUT_POST, 'Demande_Id', FILTER_DEFAULT);
$Duree = filter_input(INPUT_POST, 'duree', FILTER_DEFAULT);
$Date = date("Y-m-d-H-m-s");
$Formateur_Id = filter_input(INPUT_POST, 'Formateur_Id', FILTER_DEFAULT);
$Cout = filter_input(INPUT_POST, 'cout', FILTER_DEFAULT);
$Commentaire = filter_input(INPUT_POST, 'commentaire', FILTER_DEFAULT);
$Support = filter_input(INPUT_POST, 'support', FILTER_DEFAULT);
$Lieu = filter_input(INPUT_POST, 'lieu', FILTER_DEFAULT);

include "../includes/config.php";
$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

$req=$pdo->prepare("INSERT INTO conseil (Titre, Description, Demande_Id, Duree, Date, Formateur_Id, Cout, Commentaire, Support, Lieu) VALUES (:Titre, :Description, :Demande_Id, :Duree, :Date, :Formateur_Id, :Cout, :Commentaire, :Support, :Lieu)");
$req->bindParam(':Titre', $Titre);
$req->bindParam(':Description', $Description);
$req->bindParam(':Demande_Id', $Demande_Id);
$req->bindParam(':Duree', $Duree);
$req->bindParam(':Date', $Date);
$req->bindParam(':Formateur_Id', $Formateur_Id);
$req->bindParam(':Cout', $Cout);
$req->bindParam(':Commentaire', $Commentaire);
$req->bindParam(':Support', $Support);
$req->bindParam(':Lieu', $Lieu);

$req->execute();

header("Location: ../admin/mes_creations.php");
