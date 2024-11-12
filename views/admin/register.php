<?php
    include '../inc/header.php';
?>

    <h2>Inscription</h2>
    <?php if (!empty($errors)): ?>
        <div class="errors">
            <?php foreach ($errors as $error): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="<?php echo $baseUri; ?>/admin/register" method="POST">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
        
        <label for="email">E-mail :</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
        
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password">
        
        <input type="submit" name="register" value="S'inscrire">
    </form>

<?php include '../inc/footer.php'; ?> 