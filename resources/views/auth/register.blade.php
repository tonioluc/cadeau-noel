<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>

    <form method="POST" action="#">
        <?php echo csrf_field(); ?>
        <div>
            <label for="nom">Nom d'utilisateur</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        <div>
            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
        </div>
        <div>
            <button type="submit">Créer le compte</button>
        </div>
    </form>

    <p>Déjà un compte ? <a href="<?php echo e(route('login.show')); ?>">Se connecter</a></p>
</body>
</html>
