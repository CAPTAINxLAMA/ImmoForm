<?php include '../includes/header.php';

require '../includes/auth.php';

requireRole('client');

?>

<main>
    <div class="container1">
        <a class='btn' href="./creerDemande.php">Créer une Demande de Conseil</a>
        <a class='btn' href="./mes_demandes.php">Voir mes Demandes</a>
        <a class='btn' href="./informations_personnelles.php">Informations Personnelles</a>
    </div>
</main>

<?php  include '../includes/footer.php'?>