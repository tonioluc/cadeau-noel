<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Validation des Dépôts : </h1>
    <?php if($depots->isEmpty()): ?>
        <p>Aucun dépôt en attente.</p>
    <?php else: ?>
        <table border="1" cellpadding="6" cellspacing="0">
            <tr>
                <th>Id Dépot</th>
                <th>Montant demandé</th>
                <th>Commission appliquée</th>
                <th>Montant crédité</th>
                <th>Statut</th>
                <th>Utilisateur</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($depots as $depot): ?>
                <tr>
                    <td><?php echo e($depot->id_depot); ?></td>
                    <td><?php echo e($depot->montant_demande); ?> Ar</td>
                    <td><?php echo e($depot->commission_applique); ?> %</td>
                    <td><?php echo e($depot->montant_credit); ?> Ar</td>
                    <td><?php echo e(optional($depot->statut)->libelle ?? 'N/A'); ?></td>
                    <td><?php echo e(optional($depot->utilisateur)->nom ?? 'N/A'); ?></td>
                    <td>
                        <form method="POST" action="<?php echo e(route('depot.valider')); ?>" style="display:inline">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="id_depot" value="<?php echo e($depot->id_depot); ?>">
                            <button type="submit">Valider</button>
                        </form>
                        <form method="POST" action="<?php echo e(route('depot.rejeter')); ?>" style="display:inline; margin-left:0.5rem;">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="id_depot" value="<?php echo e($depot->id_depot); ?>">
                            <button type="submit">Refuser</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>

</html>