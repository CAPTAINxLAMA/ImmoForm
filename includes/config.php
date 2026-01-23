<?php
//Initialisation de la connection à la base de donnée
class config
{
    const host = "localhost"; // 172.16.119.130
    const user = "root"; // immoform_user
    const password = ""; // azerty
    const dbname = "immoform1"; // immoform
}

// test de connection
try
{
    $pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);
    $req = $pdo->prepare("SELECT * FROM agence");
    $req->execute();
}
catch (PDOException $e)
{
    die("Erreur de connexion : " . $e->getMessage());
}
