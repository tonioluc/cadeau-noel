<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil Utilisateur</title>
</head>

<body>
    @if (session('success'))
        <div style="color: green; margin-bottom: 1em;">
            {{ session('success') }}
        </div>
    @endif
    <h1>Bonjour <strong><?php echo e($utilisateur->nom); ?></strong></h1>
    <p>Solde actuel : <strong><?php echo e($utilisateur->solde); ?> Ar</strong></p>
    <p><a href="<?php echo e(route('depot.show')); ?>">Faire un dépôt</a></p>
    <p><a href="<?php echo e(route('utilisateur.form-entrer-nbr-enfants')); ?>">Générer des cadeaux</a></p>
    <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin-top: 1rem;">
        <?php echo csrf_field(); ?>
        <button type="submit">Se déconnecter</button>
    </form>
</body>

</html>