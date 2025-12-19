<?php include '../includes/header.php';

require '../includes/auth.php';

requireRole('admin');

?>

<main>
    <div class="container3">
        <a class='btn' href="gererDemandes.php">Gérer les Demandes</a>
        <a class='btn' href="mes_creations.php">Voir mes Formations et mes Conseils</a>
    </div>
</main>

<?php include '../includes/footer.php'?>
