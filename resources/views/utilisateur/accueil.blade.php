<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil Utilisateur</title>
</head>
<body>
    <h1>Accueil Utilisateur</h1>

    <?php if(session()->has('id_utilisateur')): ?>
        <p>Votre ID utilisateur: <strong><?php echo e(session('id_utilisateur')); ?></strong></p>
        <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin-top: 1rem;">
            <?php echo csrf_field(); ?>
            <button type="submit">Se déconnecter</button>
        </form>
    <?php else: ?>
        <p>Aucun utilisateur en session.</p>
    <?php endif; ?>

    <p><a href="<?php echo e(route('utilisateur.accueil')); ?>">Revenir à l'accueil utilisateur</a></p>
</body>
</html>
