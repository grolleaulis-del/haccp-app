<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contrôle Complet</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; margin: 20px; }
        h1 { color: #2563eb; font-size: 16px; margin-bottom: 15px; margin-top: 0; }
        h2 { color: #1e40af; font-size: 13px; margin-top: 10px; margin-bottom: 8px; }
        h3 { color: #059669; font-size: 12px; margin-top: 10px; margin-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; font-size: 10px; }
        th { background-color: #f3f4f6; font-weight: bold; }
        .photo-cell { text-align: center; vertical-align: middle; }
        .photo-thumbnail { max-width: 60px; max-height: 60px; object-fit: cover; border: 1px solid #ddd; border-radius: 3px; }
        .summary { background-color: #eff6ff; padding: 10px; margin-bottom: 15px; border-radius: 5px; }
        .section { margin-top: 10px; }
        .badge { display: inline-block; padding: 2px 6px; border-radius: 3px; font-size: 9px; }
        .badge-cuisson { background-color: #fed7aa; color: #9a3412; }
        .badge-congelation { background-color: #bfdbfe; color: #1e3a8a; }
        .badge-usage { background-color: #bbf7d0; color: #166534; }
    </style>
</head>
<body>
    <h1>Contrôle Complet - Arrivages & Lots</h1>

    <div class="summary">
        <?php if($date_debut || $date_fin): ?>
            <strong>Période:</strong>
            <?php echo e($date_debut ? \Carbon\Carbon::parse($date_debut)->format('d/m/Y') : '...'); ?>

            au
            <?php echo e($date_fin ? \Carbon\Carbon::parse($date_fin)->format('d/m/Y') : '...'); ?>

            <br>
        <?php endif; ?>
        <strong>Total arrivages:</strong> <?php echo e($arrivages->count()); ?>

        <br>
        <strong>Total lots:</strong> <?php echo e($lots->count()); ?>

    </div>

    
    <?php if($lots->count() > 0): ?>
    <div class="section">
        <h2>📦 Lots d'utilisation (<?php echo e($lots->count()); ?>)</h2>

        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Produit</th>
                    <th>N° Lot</th>
                    <th>DLC</th>
                    <th>Employé</th>
                    <th>Photo</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $lots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($lot->started_at->format('d/m/Y H:i')); ?></td>
                        <td>
                            <?php if($lot->type_operation === 'cuisson'): ?>
                                <span class="badge badge-cuisson">Cuisson</span>
                            <?php elseif($lot->type_operation === 'congelation'): ?>
                                <span class="badge badge-congelation">Congélation</span>
                            <?php else: ?>
                                <span class="badge badge-usage">Usage</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($lot->produit->nom ?? 'N/A'); ?></td>
                        <td><?php echo e($lot->numero_lot ?? '-'); ?></td>
                        <td>
                            <?php if($lot->dlc): ?>
                                <?php echo e($lot->dlc->format('d/m/Y')); ?>

                                <?php if($lot->dlc < now()): ?>
                                    <strong style="color: #dc2626;">(Dépassée)</strong>
                                <?php endif; ?>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($lot->user->name ?? 'N/A'); ?></td>
                        <td class="photo-cell">
                            <?php if($lot->photo_etiquette): ?>
                                <img src="<?php echo e(public_path('storage/' . $lot->photo_etiquette)); ?>" class="photo-thumbnail" alt="Photo">
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    

    
    <?php if($arrivages->count() > 0): ?>
    <div class="section">
        <h2>📦 Arrivages (<?php echo e($arrivages->count()); ?>)</h2>

    <?php $__currentLoopData = $arrivages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $arrivage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <h3>Arrivage #<?php echo e($arrivage->id); ?> - <?php echo e($arrivage->fournisseur->nom); ?> (<?php echo e($arrivage->date_arrivage->format('d/m/Y')); ?>)</h3>

        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Famille</th>
                    <th>N° Lot</th>
                    <th>Photo</th>
                    <th>Commentaire</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $arrivage->lignes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ligne): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($ligne->produit->nom); ?></td>
                        <td><?php echo e($ligne->produit->famille); ?></td>
                        <td><?php echo e($ligne->numero_lot ?: '-'); ?></td>
                        <td class="photo-cell">
                            <?php if($ligne->photo_path): ?>
                                <img src="<?php echo e(public_path('storage/' . $ligne->photo_path)); ?>" class="photo-thumbnail" alt="Photo">
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($ligne->commentaire ?: '-'); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>

    <p style="margin-top: 30px; font-size: 9px; color: #666;">
        Document généré le <?php echo e(now()->format('d/m/Y à H:i')); ?>

    </p>
</body>
</html>
<?php /**PATH C:\laragon\www\haccp.grolleau\haccp-app\resources\views\controle\pdf-global.blade.php ENDPATH**/ ?>