<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>

    <form method="POST" action="<?php echo e(route('login.store')); ?>">
        <?php echo csrf_field(); ?>
        <div>
            <label for="nom">Nom d'utilisateur</label>
            <input type="text" id="nom" name="nom" value="<?php echo e(old('nom')); ?>" required>
        </div>
        <div>
            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
        </div>
        <?php if($errors->has('credentials')): ?>
            <div style="color:red;">
                <?php echo e($errors->first('credentials')); ?>
            </div>
        <?php endif; ?>
        <div>
            <button type="submit">Se connecter</button>
        </div>
    </form>

    <p>Pas de compte ? <a href="<?php echo e(route('register.show')); ?>">Créer un compte</a></p>
</body>
</html>
