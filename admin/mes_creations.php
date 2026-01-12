<?php
include '../includes/header.php';

require '../includes/auth.php';
requireRole('admin');

// Connexion à la base de données
include_once "../includes/config.php";
$pdo = new PDO("mysql:host=" . config::host . ";dbname=" . config::dbname, config::user, config::password);

// Envoie de la requête SQL
$req = $pdo->prepare("SELECT conseil.Id AS conseilId, conseil.Titre, conseil.Description, conseil.Duree, conseil.Date, conseil.Lieu, conseil.Support, conseil.Cout, conseil.Commentaire, formateur.Nom, formateur.Prenom FROM conseil LEFT JOIN formateur ON conseil.formateur_id = formateur.id");
$req->execute();

$conseils = $req->fetchAll();

$req = $pdo->prepare("SELECT Id, Titre, Description, Duree, Niveau, Secteur, PlanningDebut, PlanningFin, Lieu, Capacite, Materiel, Cout, Modalite, Commentaire, Support FROM standard");
$req->execute();

$formationsS = $req->fetchAll();

$req = $pdo->prepare("SELECT * FROM online");
$req->execute();

$formations = $req->fetchAll();

?>

<div class="container">
    <h2>Mes Conseils :</h2>
    <table>
        <tr style="font-size: 10px">
            <th>Titre</th>
            <th>Description</th>
            <th>Durée</th>
            <th>Date</th>
            <th>Lieu</th>
            <th>Support</th>
            <th>Coût</th>
            <th>Commentaire</th>
            <th>Formateur</th>
        </tr>
        <?php
        foreach ($conseils as $conseil)
        {
            ?>
            <tr style="font-size: 10px">
                <td><?php echo $conseil["Titre"] ?></td>
                <td><?php echo $conseil["Description"] ?></td>
                <td><?php echo $conseil["Duree"] ?> minutes</td>
                <td><?php echo $conseil["Date"] ?></td>
                <td><?php echo $conseil["Lieu"] ?></td>
                <td><?php echo $conseil["Support"] ?></td>
                <td><?php echo $conseil["Cout"] ?> €</td>
                <td><?php echo $conseil["Commentaire"] ?></td>
                <td><?php echo $conseil["Nom"].' '.$conseil["Prenom"] ?></td>
                <td>
                    <a href="./modifierConseil.php?id=<?php echo $conseil["conseilId"] ?>" class="btn1">Modifier</a>
                </td>
                <td>
                    <a href="./supprimerConseil.php?id=<?php echo $conseil["conseilId"] ?>" class="btn2">Supprimer</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>

    <h2>Mes Formations Standard:</h2>
    <table>
        <tr style="font-size: 10px">
            <th>Titre</th>
            <th>Description</th>
            <th>Durée</th>
            <th>Niveau</th>
            <th>Secteur</th>
            <th>Date de début</th>
            <th>Date de fin</th>
            <th>Lieu</th>
            <th>Capacité d'accueil</th>
            <th>Formateurs</th>
            <th>Matériels</th>
            <th>Coûts</th>
            <th>Modalité d'inscription</th>
            <th>Commentaire</th>
            <th>Support de formation</th>
        </tr>
        <?php
        foreach ($formationsS as $formationS)
        {
            $reqLink = $pdo->prepare("SELECT formateur.Nom, formateur.Prenom FROM association_standard JOIN formateur ON association_standard.Formateur_id = formateur.Id WHERE association_standard.Standard_id = :Standard_id");
            $reqLink->bindParam( ':Standard_id', $formationS["Id"]);
            $reqLink->execute();

            $formateurs = $reqLink->fetchAll();
            ?>
            <tr style="font-size: 10px">
                <td><?php echo $formationS["Titre"] ?></td>
                <td><?php echo $formationS["Description"] ?></td>
                <td><?php echo $formationS["Duree"] ?></td>
                <td><?php echo $formationS["Niveau"] ?></td>
                <td><?php echo $formationS["Secteur"] ?></td>
                <td><?php echo $formationS["PlanningDebut"] ?></td>
                <td><?php echo $formationS["PlanningFin"] ?></td>
                <td><?php echo $formationS["Lieu"] ?></td>
                <td><?php echo $formationS["Capacite"] ?></td>
                <td>
                    <?php foreach ($formateurs as $formateur)
                    {
                        echo $formateur["Nom"].' '.$formateur["Prenom"].'<br>';
                    }
                    ?>
                </td>
                <td><?php echo $formationS["Materiel"] ?></td>
                <td><?php echo $formationS["Cout"] ?></td>
                <td><?php echo $formationS["Modalite"] ?></td>
                <td><?php echo $formationS["Commentaire"] ?></td>
                <td><?php echo $formationS["Support"] ?></td>
                <td>
                    <a href="./modifierFormation.php?id=<?php echo $formationS["Id"] ?>&standard=1" class="btn1">Modifier</a>
                </td>
                <td>
                    <a href="./supprimerFormation.php?id=<?php echo $formationS["Id"] ?>&standard=1" class="btn2">Supprimer</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>

    <h2>Mes Formations En ligne:</h2>
    <table>
        <tr style="font-size: 10px">
            <th>Titre</th>
            <th>Description</th>
            <th>Durée</th>
            <th>Niveau</th>
            <th>Secteur</th>
            <th>Horaire</th>
            <th>Lien</th>
            <th>Formateur</th>
        </tr>
        <?php
        foreach ($formations as $formation)
        {
            $req = $pdo->prepare("SELECT * FROM formateur WHERE Id = :formateur_id");
            $req->bindParam(':formateur_id', $formation["Formateur_Id"]);
            $req->execute();

            $formateur = $req->fetchAll();
            ?>
            <tr style="font-size: 10px">
                <td><?php echo $formation["Titre"] ?></td>
                <td><?php echo $formation["Description"] ?></td>
                <td><?php echo $formation["Duree"] ?></td>
                <td><?php echo $formation["Niveau"] ?></td>
                <td><?php echo $formation["Secteur"] ?></td>
                <td><?php echo $formation["DateHeure"] ?></td>
                <td><?php echo $formation["URL"] ?></td>
                <td><?php echo $formateur[0]["Nom"].' '.$formateur[0]["Prenom"] ?></td>
                <td>
                    <a href="./modifierFormation.php?id=<?php echo $formation["Id"] ?>&standard=0" class="btn1">Modifier</a>
                </td>
                <td>
                    <a href="./supprimerFormation.php?id=<?php echo $formation["Id"] ?>&standard=0" class="btn2">Supprimer</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
    <tr>
        <td>
            <a href="./navbar.php" class='btn' >Accueil</a>
        </td>
    </tr>
</div>

<?php  include '../includes/footer.php'?>