<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edition paramètre - <?php echo e($parametre->code); ?></title>
</head>
<body>
    <h1>Modifier le paramètre: <strong><?php echo e($parametre->code); ?></strong></h1>

    <?php if(session('success')): ?>
        <p style="color: green;"><?php echo e(session('success')); ?></p>
    <?php endif; ?>
    <?php if(session('info')): ?>
        <p style="color: #555;"><?php echo e(session('info')); ?></p>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div style="color: red;">
            <ul>
                <?php foreach($errors->all() as $error): ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('admin.parametres.update', $parametre->code)); ?>">
        <?php echo csrf_field(); ?>
        <div>
            <label>Code</label>
            <input type="text" value="<?php echo e($parametre->code); ?>" disabled>
        </div>
        <div style="margin-top: 0.5rem;">
            <label>Valeur actuelle</label>
            <input type="text" value="<?php echo e($parametre->valeur); ?>" disabled>
        </div>
        <div style="margin-top: 0.5rem;">
            <label>Nouvelle valeur</label>
            <input name="valeur" type="text" value="<?php echo e(old('valeur', $parametre->valeur)); ?>" required>
        </div>
        <div style="margin-top: 1rem;">
            <button type="submit">Enregistrer</button>
            <a href="<?php echo e(url()->previous()); ?>" style="margin-left: 0.5rem;">Annuler</a>
        </div>
    </form>
</body>
</html>
