<?php
session_start();

// Vérification si l'utilisateur est bien connecté
function requireLogin() {
    if (!isset($_SESSION['user'])) {
        header('Location: connexion.php');
        exit;
    }
}

// Vérification que l'utilisateur est bien à sa place
function requireRole($role) {
    requireLogin();

    if ($_SESSION['user']['role'] !== $role) {
        http_response_code(403);
        exit('Accès interdit');
    }
}
