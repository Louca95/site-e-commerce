
<?php

try {
    $conn = new PDO('mysql:host=localhost;dbname=boutique', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'set NAMES utf8'
    ]);
    echo "Connexion réussie !"; // Message de succès si la connexion est établie

} catch (PDOException $e) {
    die('Erreur de connexion à la base de données: ' . $e->getMessage()); // Affiche l'erreur de connexion

}

?>
