<?php
class config
{
    const host = "localhost";
    const user = "root";
    const password = "";
    const dbname = "immoform1";
}

try {
    $pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);
    $req = $pdo->prepare("SELECT * FROM agence");
    $req->execute();
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
