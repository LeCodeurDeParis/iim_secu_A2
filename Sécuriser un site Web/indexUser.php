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
    <link rel="stylesheet" href="./css/indexUser.css">
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
                    </div>
                <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun article trouvé.</p>
        <?php endif; ?>
    </div>
    </main>
    <footer>
        <p> Sécuriser un site web</p>
    </footer>
</body>
</html>