<?php include '../includes/header.php';

session_start();

if (!isset($_SESSION['user'])) { // si la session utilisateur n'est pas définie, il l'éjecte
    header('Location: ../includes/connexion.php');
}

?>

<main>
    <div class="container">
        <a class='btn' href="nouvelle_demande.php">Créer une Demande ou un Conseil</a>
        <a class='btn' href="mes_demandes.php">Voir mes Demandes</a>
    </div>
</main>

<?php  include '../includes/footer.php'?>