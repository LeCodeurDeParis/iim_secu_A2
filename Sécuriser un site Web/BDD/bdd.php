<?php
require_once __DIR__.'/../.env.php';

try
    {
        $connexion_BDD = new PDO(dsn: "mysql:host=$db_host;dbname=$db_name", username:$db_username, password:$db_password);
    }
catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }
?>