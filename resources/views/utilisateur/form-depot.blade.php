<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php if($errors->any()): ?>
        <div style="color:red;">
            <ul>
                <?php foreach($errors->all() as $error): ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php if(session('success')): ?>
        <div style="color:green;">
            <?php echo e(session('success')); ?>
        </div>
    <?php endif; ?>
    <form action="<?php echo e(route('depot.store')); ?>" method="post">
        <?php echo csrf_field(); ?>
        <div>
            <label for="montant">Montant du dépôt</label>
            <input type="number" id="montant" name="montant" step="0.01" min="0.01" required>
            <button type="submit">Déposer</button>
        </div>
    </form>
    <p><a href="<?php echo e(route('utilisateur.accueil')); ?>">Revenir à l'accueil utilisateur</a></p>
    <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin-top: 1rem;">
        <?php echo csrf_field(); ?>
        <button type="submit">Se déconnecter</button>
    </form>
</body>

</html>