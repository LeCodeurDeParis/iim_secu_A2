<?php
    session_start();
    if(!isset($_SESSION['csrf_token_article_add']) || empty($_SESSION['csrf_token_article_add']))
    {
        $_SESSION['csrf_token_article_add'] = bin2hex(string: random_bytes(length: 32));
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sécurisé un site web</title>
    <link rel="stylesheet" href="./css/indexAdmin.css">
</head>
<body>
    <?php
    require_once './BDD/bdd.php';

    try{
        $recupArticle = $connexion_BDD->prepare(
            query: 'SELECT * FROM article'
        );
        $recupArticle->execute();
        $articles = $recupArticle->fetchAll();
    }catch(PDOException $e){
        echo 'Erreur SQL : ' . $e->getMessage();
    }
    ?>
    <header>
        <h1>Liste des articles</h1>
    </header>
    <main>
        <div class="container">
            <?php if (!empty($articles)): ?>
                <?php foreach ($articles as $article): ?>
                    <div class="article">
                        <h2><a href="article.php?s=<?php echo htmlspecialchars($article['slug']); ?>"><?php echo htmlspecialchars($article['title']); ?></a></h2>
                        <p><?php echo htmlspecialchars($article['content']); ?></p>
                        <p class="slug"><strong>Slug:</strong> <?php echo htmlspecialchars($article['slug']); ?></p>
                        <form action="supprimer_article.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $article['id']; ?>">
                            <input type="hidden" name="token" value="<?php echo $_SESSION['csrf_token_article_add']; ?>">
                            <input type="submit" value="Supprimer">
                        </form>
                        <form action="update_article.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $article['id']; ?>">
                            <input type="hidden" name="token" value="<?php echo $_SESSION['csrf_token_article_add']; ?>">
                            <input type="submit" value="Mettre à jour">
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun article trouvé.</p>
            <?php endif; ?>
        </div>
            <div class="ajout_article">
                <h2>Ajouter un article</h2>
                <form action="./back/traitement.php" method="POST">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['csrf_token_article_add']; ?>">
                    <label for="title">Titre</label>
                    <input type="text" name="title" id="title" placeholder="Article 1">
                    <br/>
                    <label for="content">Contenu :</label>
                    <textarea name="content" id="content" cols="30" rows="10" placeholder="Contenu de l'article"></textarea>
                    <br/>
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" id="slug" placeholder="article-1">
                    <br/>
                    <input type="submit" name="ajouter" value="Ajouter">
                </form>
            </div>
    </main>
    <footer>
        <p> Sécuriser un site web</p>
    </footer>
</body>
</html>