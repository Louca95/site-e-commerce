<?php
// utilisée car soucis d'erreur affichée comme quoi une session est déjà active malgré la déconnexion de l'admin
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    global $baseUri; // Déclarer la variable comme globale
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/public/css/style.css">
    <title>Boutique</title>
</head>
<body>
    <header>
        <h1>Boutique Décorations à thèmes</h1>
        <nav>
            <a href="<?php echo $baseUri; ?>/">Accueil</a>

            <?php if (!isset($_SESSION['admin'])): ?>
                <a href="<?php echo $baseUri; ?>/admin/register">S'inscrire</a>
                <a href="<?php echo $baseUri; ?>/admin/login">Se connecter</a>
            <?php else: ?>
                <a href="<?php echo $baseUri; ?>/admin/dashboard">Admin</a>
            <?php endif; ?>

            <a href="<?php echo $baseUri; ?>/cart">Panier</a>
        </nav>
    </header>
    <main> 