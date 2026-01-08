<?php include '../includes/header.php';

require '../includes/auth.php';

requireRole('admin');

include_once "../includes/config.php";

$pdo = new PDO("mysql:host=" . config::host . ";dbname=" . config::dbname, config::user, config::password);

$req = $pdo->prepare("SELECT * FROM demandeconseil");
$req->execute();

$conseils = $req->fetchAll();

$token = rand(0, 1000000);
$_SESSION['token'] = $token;

?>

<div class="container">
    <h1>Demandes des Clients :</h1>

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
        foreach ($conseils  as $conseil)
        {
            ?>
            <tr>
                <td><?php echo $conseil["Type"] ?></td>
                <td><?php echo $conseil["Description"] ?></td>
                <td><?php echo $conseil["Date"] ?></td>
                <td><?php if ($conseil["Statut"] == Null)  { echo "En attente"; } ?></td>
                <td><?php if ($conseil["Formateur_Id"] == Null) { echo "Non assigné"; }
                    else {
                        $req = $pdo->prepare("SELECT * FROM demandeconseil JOIN formateur ON Formateur_Id = formateur.Id WHERE demandeconseil.Id=:Id");
                        $req->bindParam(':Id', $conseil["Id"]);
                        $req->execute();
                        $format = $req->fetch();
                        echo $format["Nom"]." ".$format["Prenom"];
                    }
                    ?>
                </td>
                <td>
                    <a href="./creerConseil.php?id="<?php echo $conseil["Id"] ?> class="btn3">Créer un Nouveau Conseil</a>
                </td>
                <td>
                    <form action="../actions/acceptDemande.php" method="POST"">
                        <input type="hidden" name="formateur_id" value="<?php echo $_SESSION['user']['id']; ?>">
                        <input type="hidden" name="id" value="<?php echo $conseil["Id"] ?>">
                        <input type="hidden" name="token" value="<?php echo $token; ?>">
                        <input class="btn0" type="submit" value="Prendre en charge">
                    </form>
                </td>
                <td>
                    <form action="../actions/refuseDemande.php" method="POST"">
                        <input type="hidden" name="formateur_id" value="<?php echo $_SESSION['user']['id']; ?>">
                        <input type="hidden" name="id" value="<?php echo $conseil["Id"] ?>">
                        <input type="hidden" name="token" value="<?php echo $token; ?>">
                        <input class="btn0" type="submit" value="Rejeter">
                    </form>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>

    <a href="navbar.php" class='btn' >Accueil</a>
</div>

<?php  include '../includes/footer.php'?>