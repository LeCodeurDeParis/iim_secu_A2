<?php
session_start();
if (!isset($_SESSION['csrf_token_article_add']) || empty($_SESSION['csrf_token_article_add'])) {
    $_SESSION['csrf_token_article_add'] = bin2hex(random_bytes(32));
}

if(!isset($_GET['s']) || empty($_GET['s']))
{
    die('Article introuvable');
}

require_once './BDD/bdd.php';

$getArticle = $connexion_BDD->prepare(
    query: 'SELECT title, content FROM article WHERE slug = :slug LIMIT 1'
);
$getArticle->execute(params:[
    'slug' => htmlspecialchars($_GET['s'])
]);

if($getArticle->rowCount() == 1)
{
    $article = $getArticle->fetch();
    echo '<h1>'.$article['title'].'</h1>';
    echo '<p>'.$article['content'].'</p>';
}
else
{
    echo '<p>Article introuvable</p>';
}