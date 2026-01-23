<?php
include '../includes/header.php';

require '../includes/auth.php';
requireRole('admin');

$token = rand(0, 1000000);
$_SESSION['token'] = $token;

// Connexion à la base de données
include_once "../includes/config.php";
$pdo = new PDO("mysql:host=" . config::host . ";dbname=" . config::dbname, config::user, config::password);

// Envoie de la requête SQL
$req = $pdo->prepare("SELECT * FROM demandes");
$req->execute();

$demandes = $req->fetchAll();
?>

<div class="container">
    <h1>Demandes des clients :</h1>
    <table>
        <tr>
            <th>Type</th>
            <th>Description</th>
            <th>Date</th>
            <th>Statut</th>
            <th>Prise en charge</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <?php
        foreach ($demandes as $demande)
        {
            ?>
            <tr>
                <td><?php echo $demande["Type"] ?></td>
                <td><?php echo $demande["Description"] ?></td>
                <td><?php echo $demande["Date"] ?></td>
                <td><?php echo $demande["Statut"]; ?></td>
                <td><?php if ($demande["Formateur_id"] == Null) { echo "Non assigné"; }
                    else {
                        // Envoie de la requête SQL
                        $req = $pdo->prepare("SELECT * FROM demandes JOIN formateur ON Formateur_Id = formateur.Id WHERE demandes.Id=:id");
                        $req->bindParam(':id', $demande["Id"]);
                        $req->execute();

                        $format = $req->fetch();

                        echo $format["Nom"]." ".$format["Prenom"];
                    }
                    ?>
                </td>
                <td>
                    <?php if ($demande["Type"] == "Conseil") {
                        echo '<a href="./creerConseil.php?id="'.$demande["Id"].' class="btn3">Créer un Nouveau Conseil</a>';
                    }
                    else if ($demande["Type"] == "Formation") {
                        echo '<a href="./creerFormation.php?id='.$demande["Id"].'&standard=1" class="btn3">Créer une Nouvelle Formation</a>';
                    }
                    ?>
                </td>
                <td>
                    <form action="../actions/acceptDemande.php" method="POST">
                        <input type="hidden" name="formateur_id" value="<?php echo $_SESSION['user']['id']; ?>">
                        <input type="hidden" name="id" value="<?php echo $demande["Id"] ?>">
                        <input type="hidden" name="token" value="<?php echo $token; ?>">
                        <input class="btn0" type="submit" value="Prendre en charge">
                    </form>
                </td>
                <td>
                    <form action="../actions/refuseDemande.php" method="POST">
                        <input type="hidden" name="formateur_id" value="<?php echo $_SESSION['user']['id']; ?>">
                        <input type="hidden" name="id" value="<?php echo $demande["Id"] ?>">
                        <input type="hidden" name="token" value="<?php echo $token; ?>">
                        <input class="btn0" type="submit" value="Rejeter">
                    </form>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
    <a href="./navbar.php" class='btn' >Accueil</a>
</div>

<?php  include '../includes/footer.php'?>