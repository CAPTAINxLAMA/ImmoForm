<?php include '../includes/header.php';

require 'includes/auth.php';

requireRole('admin');

?>

<main>
    <div class="container">
        <a class='btn' href="gerer_demandes.php">Gérer les Demandes</a>
        <a class='btn' href="creation_conseil.php">Créer une Formation ou un Conseil</a>
        <a class='btn' href="mes_creation.php">Voir mes Formations et mes Conseils</a>
    </div>
</main>

<?php include '../includes/footer.php'?>
