<?php
session_start();

if (!isset($_POST['token']) || $_POST['token'] != $_SESSION['csrf_token_article_add']) {
    die('<p>Token CSRF invalide</p>');
}

if (isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['title']) && !empty($_POST['title']) && isset($_POST['content']) && !empty($_POST['content']) && isset($_POST['slug']) && !empty($_POST['slug'])) {
    $id = $_POST['id'];
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    $slug = htmlspecialchars($_POST['slug']);

    require_once '../BDD/bdd.php';

    try {
        $updateArticle = $connexion_BDD->prepare('UPDATE article SET title = :title, content = :content, slug = :slug WHERE id = :id');
        $updateArticle->execute([
            'title' => $title,
            'content' => $content,
            'slug' => $slug,
            'id' => $id
        ]);

        if ($updateArticle->rowCount() > 0) {
            echo '<p>Article mis à jour</p>';
            header('Location: ../indexAdmin.php');
        } else {
            echo '<p>Erreur lors de la mise à jour</p>';
        }
        exit();
    } catch (PDOException $e) {
        echo 'Erreur SQL : ' . $e->getMessage();
    }
} else {
    echo '<p>Informations manquantes pour la mise à jour</p>';
}
?>