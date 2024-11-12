<?php

include '../inc/header.php';

?>

<h2>Se connecter</h2>

<?php if (!empty($errors)): ?>
    <div class="error-messages">
        <?php foreach ($errors as $error): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="POST" action="<?php echo $baseUri; ?>/admin/login">
    <label for="email">Email:</label>
    <input type="text" id="email" name="email" required>
    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password" required>
    <input type="submit" name="login" value="Se connecter" />
</form>

<?php include '../inc/footer.php'; ?>
