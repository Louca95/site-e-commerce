<?php include 'inc/header.php'; ?>

<h1>Bienvenue dans notre boutique</h1>
<div class="products">
    
<?php if (!empty($products)): ?> 
    <?php foreach ($products as $product): ?> 
        <div class="product">
            <?php global $baseUri; ?>
            <h2><?php echo htmlspecialchars($product['name_product']); ?></h2>
            <img src="<?php echo  htmlspecialchars($product['picture']); ?>" alt="<?php echo htmlspecialchars($product['description']); ?>" />
            <p>Prix: <?php echo htmlspecialchars($product['price']); ?> €</p>
            <a href="<?php echo $baseUri; ?>/product?id=<?php echo htmlspecialchars($product['id']); ?>">Voir détails</a>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Aucun produit à afficher pour le moment.</p> <!-- Message if no products available -->
<?php endif; ?>
</div>


<?php include 'inc/footer.php'; ?>
