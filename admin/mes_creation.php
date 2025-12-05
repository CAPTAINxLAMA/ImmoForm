<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un compte</title>
</head>
<body>

<h2>Créer un compte</h2>

<form action="inscription_traitement.php" method="POST">
    <label for="nom">Nom :</label><br>
    <input type="text" id="nom" name="nom" required><br><br>

    <label for="email">Email :</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Mot de passe :</label><br>
    <input type="password" id="password" name="password" required><br><br>

    <label for="confirm">Confirmer le mot de passe :</label><br>
    <input type="password" id="confirm" name="confirm" required><br><br>

    <button type="submit">Créer mon compte</button>
</form>

</body>
</html>

