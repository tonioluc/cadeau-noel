<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <!-- Pas de CSS pour l'instant -->
</head>

<body>
    <h1>Inscription</h1>

    <form method="POST" action="<?php echo e(route('register.store')); ?>">
        <?php echo csrf_field(); ?>

        <div>
            <label for="nom">Nom d'utilisateur</label>
            <input type="text" id="nom" name="nom" value="<?php echo e(old('nom')); ?>" required>
            <?php $__errorArgs = ['nom']; $__bag = $errors->getBag('default'); if ($__bag->has($__errorArgs[0])) : if (isset($message)) { $__messageOriginal = $message; } $message = $__bag->first($__errorArgs[0]); ?>
                <div style="color:red;"><?php echo e($message); ?></div>
            <?php unset($message); if (isset($__messageOriginal)) { $message = $__messageOriginal; } endif; unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            <?php $__errorArgs = ['mot_de_passe']; $__bag = $errors->getBag('default'); if ($__bag->has($__errorArgs[0])) : if (isset($message)) { $__messageOriginal = $message; } $message = $__bag->first($__errorArgs[0]); ?>
                <div style="color:red;"><?php echo e($message); ?></div>
            <?php unset($message); if (isset($__messageOriginal)) { $message = $__messageOriginal; } endif; unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <button type="submit">Créer le compte</button>
        </div>
    </form>

    <p>Déjà un compte ? <a href="<?php echo e(route('login.show')); ?>">Se connecter</a></p>
</body>

</html>
