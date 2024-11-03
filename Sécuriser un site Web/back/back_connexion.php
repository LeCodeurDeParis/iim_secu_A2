<?php
session_start();
if (!isset($_SESSION['csrf_token_article_add']) || empty($_SESSION['csrf_token_article_add'])) {
    $_SESSION['csrf_token_article_add'] = bin2hex(random_bytes(32));
}
if(isset($_POST['pseudoCo']) && !empty($_POST['pseudoCo']))
{
    $pseudo = htmlspecialchars(string: $_POST['pseudoCo']);
}
else
{
    die('<p>Le pseudo est obligatoire</p>');
}

if(isset($_POST['passwordCo']) && !empty($_POST['passwordCo']))
{
    $password = $_POST['passwordCo'];
}
else
{
    die('<p>Le mot de passe est obligatoire</p>');
}

if (!isset($_POST['token']) || $_POST['token'] != $_SESSION['csrf_token_article_add']) {
    die('<p>Token CSRF invalide</p>');
}
if (isset($pseudo) && isset($password))
{
    require_once '../BDD/bdd.php';

    try {
        $recupUser = $connexion_BDD->prepare(
            'SELECT * FROM user WHERE userPseudo = :pseudo'
        );
        $recupUser->execute([
            'pseudo' => $pseudo
        ]);

        $user = $recupUser->fetch();

        if ($user === false) {
            echo '<p>Aucun utilisateur trouvé avec ce pseudo</p>';
        } else {
            if (password_verify($password, $user['userPassword'])) {
                echo '<p>Connexion réussie</p>';
                $_SESSION['csrf_token_article_add'] = bin2hex(random_bytes(32));
                if ($user['isAdmin'] == 1) {
                    echo '<p>Vous êtes administrateur</p>';
                    header('Location: ../indexAdmin.php');
                    exit();
                } else {
                    echo '<p>Vous n\'êtes pas administrateur</p>';
                    echo '<p>Connexion réussie</p>';
                    $_SESSION['csrf_token_article_add'] = bin2hex(random_bytes(32));
                    header('Location: ../indexUser.php');
                }
            } else {
                echo '<p>Le mot de passe est invalide</p>';
            }
        }
    } catch (PDOException $e) {
        echo 'Erreur SQL : ' . $e->getMessage();
    }
}

?>