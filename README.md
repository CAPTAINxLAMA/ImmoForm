# Page de garde
- Page de connection (formulaire)
- Page d'inscription (formulaire)

## Client
- formulaire de demande de formation ou de conseil
- bouton permettant d'afficher l'historique des ses demandes
- avec la possibilité de modifier ou annuler une demande
- bouton pour changer ses informations

## Admin
- visu sur la liste des demandes (avec choix)
- bouton changement statut demande
- formulaire de création de formation ou conseil (personnalisé)
- visu sur liste formation et conseil créé


## De jolie petits graphs ...

### Structure de fichier :

```mermaid
flowchart TB
    ROOT["Projet ImmoFrom"]

    subgraph includes_group["INCLUDES"]
        inscription["inscription.php"]
        header["header.php"]
        footer["footer.php"]
        connexion["connexion.php"]
        config["config.php"]
        auth["auth.php"]
    end

    subgraph css_group["CSS"]
        css["style.css"]
    end

    subgraph client_group["CLIENT"]
        navbarClient["navbar.php"]
        creerDemande["creerDemande.php"]
        mesDemandes["mes_demandes.php"]
        modifierDemande["modifierDemande.php"]
        supprimerDemande["supprimerDemande.php"]
        demandeValidee["demande_validee.php"]
    end
    
    subgraph admin_group["ADMIN"]
        navbarAdmin["navbar.php"]
        creerConseil["CreerConseil.php"]
        mesCreations["mes_creations.php"]
        modifierConseil["modifierConseil.php"]
        supprimerConseil["supprimerConseil.php"]
        gererDemandes["gererDemandes.php"]
    end
    
    subgraph actions_group["ACTIONS"]
        createAccount["createAccount.php"]
        connection["connection.php"]
        createDemande["createDemande.php"]
        updateDemande["updateDemande.php"]
        deleteDemande["deleteDemande.php"]
        acceptDemande["acceptDemande.php"]
        refuseDemande["refuseDemande.php"]
        createConseil["createConseil.php"]
        updateConseil["updateConseil.php"]
        deleteConseil["deleteConseil.php"]
    end
    
    subgraph bdd_group["BDD"]
        sql["immoform1.sql"]
    end

ROOT --> includes_group
ROOT --> css_group
ROOT --> client_group
ROOT --> admin_group
ROOT --> actions_group
ROOT --> bdd_group
```

### Liens avec les actions :

```mermaid
flowchart LR
    subgraph includes_group["INCLUDES"]
        inscription["inscription.php"]
        connexion["connexion.php"]
    end

    subgraph client_group["CLIENT"]
        creerDemande["creerDemande.php"]
        modifierDemande["modifierDemande.php"]
        supprimerDemande["supprimerDemande.php"]
        demandeValidee["demande_validee.php"]
    end

    subgraph admin_group["ADMIN"]
        creerConseil["CreerConseil.php"]
        mesCreations["mes_creations.php"]
        modifierConseil["modifierConseil.php"]
        supprimerConseil["supprimerConseil.php"]
        gererDemandes["gererDemandes.php"]
    end

    subgraph actions_group["ACTIONS"]
        createAccount["createAccount.php"]
        connection["connection.php"]
        createDemande["createDemande.php"]
        updateDemande["updateDemande.php"]
        deleteDemande["deleteDemande.php"]
        acceptDemande["acceptDemande.php"]
        refuseDemande["refuseDemande.php"]
        createConseil["createConseil.php"]
        updateConseil["updateConseil.php"]
        deleteConseil["deleteConseil.php"]
    end

    inscription --> createAccount
    connexion --> connection
    creerDemande --> createDemande
    modifierDemande --> updateDemande
    supprimerDemande --> deleteDemande
    demandeValidee --> acceptDemande
    gererDemandes --> refuseDemande
    creerConseil --> createConseil
    modifierConseil --> updateConseil
    supprimerConseil --> deleteConseil
```