<?php
    session_start();
    include '../inc/header.php';
?>

<?php if (!empty($errors)): ?>
    <div class="errors">
        <?php foreach ($errors as $error): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<h2>Valider votre commande</h2>
<form action="<?php echo htmlspecialchars($baseUri); ?>/checkout" method="POST">
    <label for="client_name">Nom :</label>
    <input type="text" name="client_name" id="client_name" required>

    <label for="client_email">Email :</label>
    <input type="email" name="client_email" id="client_email" required>

    <input type="submit" name="checkout" value="Confirmer la commande" >
</form>

<?php if (isset($_GET['success'])): ?>
    <p>Merci pour votre commande ! Un email de confirmation a été envoyé.</p>
<?php endif; ?>

<?php include '../inc/footer.php'; ?>