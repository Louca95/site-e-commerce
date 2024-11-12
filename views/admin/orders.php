

 <?php
    session_start();
    include '../inc/header.php';

    if (!isset($_SESSION['admin'])) {
        header("Location: " . $baseUri . "/admin/login");
        exit();
    }

    if (!isset($orders)) {
        echo "<p>Erreur : aucune commande à afficher.</p>";
        exit();
    }
?>

<h2 class="ordres-title">Liste des commandes</h2>

<table class="table-orders">
    <thead>
        <tr>
            <th>Numéro de commande</th>
            <th>Nom du client</th>
            <th>Email du client</th>
            <th>Nom de l'article</th>
            <th>Quantité</th>
            <th>Total</th>
            <!-- <th>Date</th>
            <th>Status</th> -->
            <th>Détails</th> 
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                <td><?php echo htmlspecialchars($order['client_name']); ?></td>
                <td><?php echo htmlspecialchars($order['client_email']); ?></td>
                <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                <td><?php echo htmlspecialchars($order['total_price']); ?> €</td>
                <!-- <td><?php echo htmlspecialchars($order['order_date']); ?></td> -->
                <!-- <td><?php echo htmlspecialchars($order['status']); ?></td> -->
                <td><a href="<?php echo $baseUri . "/admin/orders/view?id=" . htmlspecialchars($order['id']); ?>">Voir</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="<?php echo $baseUri; ?>/admin/dashboard">Retour au tableau de bord</a>

<?php include '../inc/footer.php'; ?>
