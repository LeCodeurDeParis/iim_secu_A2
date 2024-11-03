<?php
session_start();
if (!isset($_SESSION['csrf_token_article_add']) || empty($_SESSION['csrf_token_article_add'])) {
    $_SESSION['csrf_token_article_add'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sécurisé un site web</title>
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
    <header>
        <h1>Formulaire d'inscription et de connexion</h1>
    </header>
    <div class="container">
        <div class="form_inscription">
            <h2>Inscription</h2>
            <form action="./back/back_inscription.php" method="POST">
                <label for="pseudo">Pseudo</label>
                <input type="text" name="pseudo" id="pseudo" placeholder="Pseudo">
                <br/>
                <label for="password1">Mot de passe</label>
                <input type="password" name="password1" id="password1" placeholder="Mot de passe">
                <br/>
                <label for="password2">Confirmer mot de passe</label>
                <input type="password" name="password2" id="password2" placeholder="Confirmer Mot de passe">
                <br/>
                <input type="hidden" name="token" value="<?php echo $_SESSION['csrf_token_article_add']; ?>">
                <input type="hidden" name="form" value="signup">
                <input type="submit" name="inscription" value="S'inscrire">
            </form>
        </div>
        <div class="form_connexion">
            <h2>Connexion</h2>
            <form action="./back/back_connexion.php" method="POST">
                <label for="pseudoCo">Pseudo</label>
                <input type="text" name="pseudoCo" id="pseudoCo" placeholder="Pseudo">
                <br/>
                <label for="passwordCo">Mot de passe</label>
                <input type="password" name="passwordCo" id="passwordCo" placeholder="Mot de passe">
                <br/>
                <input type="hidden" name="token" value="<?php echo $_SESSION['csrf_token_article_add']; ?>">
                <input type="hidden" name="form" value="signin">
                <input type="submit" name="connexion" value="Se connecter">
            </form>
        </div>
    </div>
    <footer>
        <p> Sécuriser un site web</p>
    </footer>
</body>
</html>