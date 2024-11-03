<?php
session_start();

if (!isset($_SESSION['csrf_token_inscription']) || empty($_SESSION['csrf_token_inscription'])) {
    $_SESSION['csrf_token_inscription'] = bin2hex(random_bytes(32));
}
if(isset($_POST['pseudo']) && !empty($_POST['pseudo']))
{
    $pseudo = htmlspecialchars(string: $_POST['pseudo']);
}
else
{
    echo '<p>Le pseudo est obligatoire</p>';
}

if(isset($_POST['password1']) && !empty($_POST['password1']))
{
    $password1 = $_POST['password1'];
}
else
{
    echo '<p>Le mot de passe est obligatoire</p>';
}

if(isset($_POST['password2']) && !empty($_POST['password2']))
{
    $password2 = $_POST['password2'];
}
else
{
    echo '<p>La confirmation du mot de passe est obligatoire</p>';
}

if($password1 != $password2)
{
    echo '<p>Les mots de passe ne correspondent pas</p>';
}

if(isset($pseudo) && isset($password1) && isset($password2))
{
    // Pas d'erreur donc sauvegarde dans la base de données
    require_once '../BDD/bdd.php';

    $sauvegarde = $connexion_BDD->prepare(
        query: 'INSERT INTO user(userPseudo, userPassword) VALUES(:pseudo, :password)'
    );
    $sauvegarde->execute(params:[
        'pseudo' => $pseudo,
        'password' => password_hash($password1, PASSWORD_BCRYPT, [])
    ]);

    if($sauvegarde->rowCount() > 0)
    {
        echo '<p>Utilisateur sauvegardé</p>';
    }
    else
    {
        echo '<p>Erreur lors de la sauvegarde</p>';
    }
}
?>