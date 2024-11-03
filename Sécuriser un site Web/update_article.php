<?php
session_start();

if (!isset($_POST['token']) || $_POST['token'] != $_SESSION['csrf_token_article_add']) {
    die('<p>Token CSRF invalide</p>');
}

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];

    require_once './BDD/bdd.php';

    try {
        $recupArticle = $connexion_BDD->prepare('SELECT * FROM article WHERE id = :id');
        $recupArticle->execute(['id' => $id]);
        $article = $recupArticle->fetch(PDO::FETCH_ASSOC);

        if ($article === false) {
            echo '<p>Aucun article trouvé avec cet ID</p>';
        } else {
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Mettre à jour l'article</title>
            </head>
            <body>
                <h1>Mettre à jour l'article</h1>
                <form action="./back/back_update_article.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $article['id']; ?>">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['csrf_token_article_add']; ?>">
                    <label for="title">Titre</label>
                    <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($article['title']); ?>">
                    <br/>
                    <label for="content">Contenu :</label>
                    <textarea name="content" id="content" cols="30" rows="10"><?php echo htmlspecialchars($article['content']); ?></textarea>
                    <br/>
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" id="slug" value="<?php echo htmlspecialchars($article['slug']); ?>">
                    <br/>
                    <input type="submit" value="Mettre à jour">
                </form>
            </body>
            </html>
            <?php
        }
    } catch (PDOException $e) {
        echo 'Erreur SQL : ' . $e->getMessage();
    }
} else {
    echo '<p>ID de l\'article manquant</p>';
}
?>