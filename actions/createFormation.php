<?php
session_start();
$tokenServeur = $_SESSION['token'];
$tokenRecu = filter_input(INPUT_POST, 'token', FILTER_VALIDATE_INT);

// Vérification la cohérence des tokens
if($tokenRecu != $tokenServeur)
{
    die("Erreur de token. Va mourir vilain hacker.");
}

// Connexion à la base de données
include "../includes/config.php";
$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

// champs communs au deux formations
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
    $req = $pdo->prepare("INSERT INTO standard(Titre, Description, Duree, Niveau, Secteur, PlanningDebut, PlanningFin, Lieu, Capacite, Materiel, Cout, Modalite, Commentaire, Support) VALUES (:titre, :description, :duree, :niveau, :secteur, :datedebut, :datefin, :lieu, :capacite, :materiel, :cout, :modalite, :commentaire, :support)");
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

    // Récupération de l'id de la dernière requete
    $formationId = intval($pdo->lastInsertId());

    /* Liaison formateurs */
    $reqLink = $pdo->prepare("INSERT INTO association_standard (Standard_id, Formateur_id) VALUES (:formation_id, :formateur_id)");

    foreach ($formateurs as $formateurId) {
        $formateurId = intval($formateurId);
        $reqLink->bindParam(':formation_id', $formationId);
        $reqLink->bindParam(':formateur_id', $formateurId);
        $reqLink->execute();
    }
}

else {
    $dateheure = filter_input(INPUT_POST, 'dateheure', FILTER_DEFAULT);
    $url = filter_input(INPUT_POST, 'url', FILTER_DEFAULT);
    $formateur  = filter_input(INPUT_POST, 'formateur_id', FILTER_VALIDATE_INT);

    $req = $pdo->prepare("INSERT INTO online(Titre, Description, Duree, Niveau, Secteur, DateHeure, URL, Formateur_Id) VALUES (:titre, :description, :duree, :niveau, :secteur, :dateheure, :url, :formateur_id)");
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