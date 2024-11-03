<?php
session_start();

if (!isset($_POST['token']) || $_POST['token'] != $_SESSION['csrf_token_article_add']) {
    die('<p>Token CSRF invalide</p>');
}

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];

    require_once './BDD/bdd.php';

    try {
        $supprimerArticle = $connexion_BDD->prepare('DELETE FROM article WHERE id = :id');
        $supprimerArticle->execute(['id' => $id]);

        if ($supprimerArticle->rowCount() > 0) {
            echo '<p>Article supprimé</p>';
            header('Location: ./indexAdmin.php');
        } else {
            echo '<p>Erreur lors de la suppression</p>';
        }
    } catch (PDOException $e) {
        echo 'Erreur SQL : ' . $e->getMessage();
    }
} else {
    echo '<p>ID de l\'article manquant</p>';
}
?>