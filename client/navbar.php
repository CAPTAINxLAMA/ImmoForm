<?php include '../includes/header.php';

require 'includes/auth.php';

requireRole('client');

?>

<main>
    <div class="container">
        <a class='btn' href="nouvelle_demande.php">Créer une Demande ou un Conseil</a>
        <a class='btn' href="mes_demandes.php">Voir mes Demandes</a>
    </div>
</main>

<?php  include '../includes/footer.php'?>