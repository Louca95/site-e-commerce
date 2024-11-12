<?php
session_start();
include '../inc/header.php';

if (isset($_SESSION['admin'])) {
    $admin = $_SESSION['admin'];
}

// Assurez-vous que `$products` a été passé par le contrôleur
if (!isset($products)) {
    echo "<p>Erreur : aucun produit à afficher.</p>";
    exit();
}

?>

<h2>Tableau de bord admin</h2>

<div>
    <h3>Bonjour <?php echo htmlspecialchars($admin); ?></h3>
</div>

<div>
    <a href="<?php echo $baseUri; ?>/admin/orders">Voir les commandes</a> <!-- Lien vers la page des commandes -->
</div>

<div class="products">
    <?php foreach ($products as $product): ?>
        <div class="product">
            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
            <img src="<?php echo $baseUri . "/public/img/" . htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
            <p>Prix: <?php echo htmlspecialchars($product['price']); ?> €</p>
            <a href="edit.php?id=<?php echo htmlspecialchars($product['id']); ?>">Modifier</a>
        </div>
    <?php endforeach; ?>
</div>

<a href="<?php echo $baseUri; ?>/admin/logout">Se déconnecter</a>

<?php include '../inc/footer.php'; ?>


