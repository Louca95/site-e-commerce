


<?php include '../inc/header.php'; ?>

<h1><?php echo htmlspecialchars($product['name']); ?></h1>
<img src="<?php echo $baseUri."/public/img/".htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
<p>Description: <?php echo htmlspecialchars($product['description']); ?></p>
<p>Prix: <?php echo htmlspecialchars($product['price']); ?> €</p>
<a href="<?php echo $baseUri; ?>/cart/add?id=<?php echo htmlspecialchars($product['id']); ?>">Ajouter au panier</a>

<?php include '../inc/footer.php'; ?>
