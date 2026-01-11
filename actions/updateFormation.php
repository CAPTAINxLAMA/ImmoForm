<?php
session_start();
$tokenServeur= $_SESSION['token'];
$tokenRecu=filter_input(INPUT_POST, 'token', FILTER_DEFAULT);

//je vérifie la cohérence des tokens
if($tokenRecu != $tokenServeur){
    die("Erreur de token. Va mourir vilain hacker.");//je stoppe tout
}

// Connexion à la base de données
include "../includes/config.php";
$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

// champs communs au deux formations
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$standard = filter_input(INPUT_POST, 'standard', FILTER_VALIDATE_INT);
$titre = filter_input(INPUT_POST, 'titre', FILTER_DEFAULT);
$description = filter_input(INPUT_POST, 'description', FILTER_DEFAULT);
$duree = filter_input(INPUT_POST, 'duree', FILTER_VALIDATE_INT);
$niveau = filter_input(INPUT_POST, 'niveau', FILTER_DEFAULT);
$secteur = filter_input(INPUT_POST, 'secteur', FILTER_DEFAULT);

if ($standard === 1) {
    $datedebut = filter_input(INPUT_POST, 'datedebut', FILTER_DEFAULT);
    $datefin = filter_input(INPUT_POST, 'datefin', FILTER_DEFAULT);
    $lieu = filter_input(INPUT_POST, 'lieu', FILTER_DEFAULT);
    $capacite = filter_input(INPUT_POST, 'capacite', FILTER_VALIDATE_INT);
    $materiel = filter_input(INPUT_POST, 'materiel', FILTER_DEFAULT);
    $cout = filter_input(INPUT_POST, 'cout', FILTER_DEFAULT);
    $modalite = filter_input(INPUT_POST, 'modalite', FILTER_DEFAULT);
    $commentaire = filter_input(INPUT_POST, 'commentaire', FILTER_DEFAULT);
    $support = filter_input(INPUT_POST, 'support', FILTER_DEFAULT);

    // formateurs multiples
    $formateurs = $_POST['formateur_id'] ?? [];

    if (!is_array($formateurs) || count($formateurs) < 2) {
        die("Une formation standard doit avoir au moins deux formateurs.");
    }

    /* Insertion formation standard */
    $req = $pdo->prepare("UPDATE standard SET Titre = :titre, Description = :description, Duree = :duree, Niveau = :niveau, Secteur = :secteur, PlanningDebut = :datedebut, PlanningFin = :datefin, Lieu = :lieu, Capacite = :capacite, Materiel = :materiel, Cout = :cout, Modalite = :modalite, Commentaire = :commentaire, Support = :support WHERE ID = :id");
    $req->bindParam(':id', $id);
    $req->bindParam(':titre', $titre);
    $req->bindParam(':description', $description);
    $req->bindParam(':duree', $duree);
    $req->bindParam(':niveau', $niveau);
    $req->bindParam(':secteur', $secteur);
    $req->bindParam(':datedebut', $datedebut);
    $req->bindParam(':datefin', $datefin);
    $req->bindParam(':lieu', $lieu);
    $req->bindParam(':capacite', $capacite);
    $req->bindParam(':materiel', $materiel);
    $req->bindParam(':cout', $cout);
    $req->bindParam(':modalite', $modalite);
    $req->bindParam(':commentaire', $commentaire);
    $req->bindParam(':support', $support);
    $req->execute();

    /* Liaison formateurs */
    $reqLink = $pdo->prepare("DELETE FROM association_standard WHERE Standard_Id = :formation_id");
    $reqLink->bindParam(':formation_id', $id);
    $reqLink->execute();

    $reqLink = $pdo->prepare("INSERT INTO association_standard (Standard_id, Formateur_id) VALUES (:formation_id, :formateur_id)");

    foreach ($formateurs as $formateurId) {
        $formateurId = intval($formateurId);
        $reqLink->bindParam(':formation_id', $id);
        $reqLink->bindParam(':formateur_id', $formateurId);
        $reqLink->execute();
    }
}

else {
    $dateheure = filter_input(INPUT_POST, 'dateheure', FILTER_DEFAULT);
    $url = filter_input(INPUT_POST, 'url', FILTER_DEFAULT);
    $formateur  = filter_input(INPUT_POST, 'formateur_id', FILTER_VALIDATE_INT);

    $req = $pdo->prepare("UPDATE online SET Titre = :titre, Description = :description, Duree = :duree, Niveau = :niveau, DateHeure = :dateheure, URL = :url, Formateur_Id = :formateur_id, Secteur = :secteur WHERE Id = :id");
    $req->bindParam(':id', $id);
    $req->bindParam(':titre', $titre);
    $req->bindParam(':description', $description);
    $req->bindParam(':duree', $duree);
    $req->bindParam(':niveau', $niveau);
    $req->bindParam(':secteur', $secteur);
    $req->bindParam(':dateheure', $dateheure);
    $req->bindParam(':url', $url);
    $req->bindParam(':formateur_id', $formateur);
    $req->execute();
}

header("Location: ../admin/mes_creations.php");