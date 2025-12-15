<?php

session_start();

if (!isset($_SESSION['user'])) { // si la session utilisateur n'est pas définie, il l'éjecte
    header('Location: ../includes/connexion.php');
    exit;
}

