<?php
session_start();

if (!isset($_SESSION['csrf_token_article_add'])) {
    die('<p>Token CSRF manquant</p>');
}

if(!isset($_POST['token']) || $_POST['token'] != $_SESSION['csrf_token_article_add'])
{
    echo 'Token reçu : ' . htmlspecialchars($_POST['token']) . '<br>';
    echo 'Token attendu : ' . htmlspecialchars($_SESSION['csrf_token_article_add']) . '<br>';
    die('<p>Token invalide</p>');
}


//Renouveller le token
unset($_SESSION['csrf_token_article_add']);

if(isset($_POST['title']) && !empty($_POST['title']))
{
    $title = htmlspecialchars(string: $_POST['title']);
}
else
{
    echo '<p>Le titre est obligatoire</p>';
}

if(isset($_POST['content']) && !empty($_POST['content']))
{
    $content = htmlspecialchars(string: $_POST['content']);
}
else
{
    echo '<p>Le contenu est obligatoire</p>';
}

if(isset($_POST['slug']) && !empty($_POST['slug']))
{
    $slug = htmlspecialchars(string: $_POST['slug']);
}
else
{
    echo "<p>Le slug est obligatoire</p>";
}



if(isset($title) && isset($content) && isset($slug))
{
    // Pas d'erreur donc sauvegarde dans la base de données
    require_once '../BDD/bdd.php';

    $sauvegarde = $connexion_BDD->prepare(
        query: 'INSERT INTO article(title, content, slug) VALUES(:title, :content, :slug)'
    );
    $sauvegarde->execute(params:[
        'title' => $title,
        'content' => $content,
        'slug' => $slug
    ]);

    if($sauvegarde->rowCount() > 0)
    {
        echo '<p>Article sauvegardé</p>';
        header('Location: ../indexAdmin.php');
    }
    else
    {
        echo '<p>Erreur lors de la sauvegarde</p>';
    }
}

?>