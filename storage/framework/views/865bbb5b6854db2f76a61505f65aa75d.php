<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Arrivage #<?php echo e($arrivage->id); ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { color: #2563eb; font-size: 18px; margin-bottom: 20px; }
        h2 { color: #1e40af; font-size: 14px; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f3f4f6; font-weight: bold; }
        .info-grid { display: table; width: 100%; margin-bottom: 20px; }
        .info-row { display: table-row; }
        .info-label { display: table-cell; font-weight: bold; width: 150px; padding: 5px; }
        .info-value { display: table-cell; padding: 5px; }
    </style>
</head>
<body>
    <h1>Arrivage #<?php echo e($arrivage->id); ?> - <?php echo e($arrivage->date_arrivage->format('d/m/Y')); ?></h1>

    <div class="info-grid">
        <div class="info-row">
            <div class="info-label">Fournisseur:</div>
            <div class="info-value"><?php echo e($arrivage->fournisseur->nom); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Date:</div>
            <div class="info-value"><?php echo e($arrivage->date_arrivage->format('d/m/Y')); ?></div>
        </div>
        <?php if($arrivage->bl_path): ?>
        <div class="info-row">
            <div class="info-label">Bon de livraison:</div>
            <div class="info-value">Disponible</div>
        </div>
        <?php endif; ?>
        <?php if($arrivage->commentaire): ?>
        <div class="info-row">
            <div class="info-label">Commentaire:</div>
            <div class="info-value"><?php echo e($arrivage->commentaire); ?></div>
        </div>
        <?php endif; ?>
    </div>

    <h2>Produits reçus (<?php echo e($arrivage->lignes->count()); ?>)</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Produit</th>
                <th>Famille</th>
                <th>N° Lot</th>
                <th>Photo</th>
                <th>Commentaire</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $arrivage->lignes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $ligne): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($ligne->produit->nom); ?></td>
                    <td><?php echo e($ligne->produit->famille); ?></td>
                    <td><?php echo e($ligne->numero_lot ?: '-'); ?></td>
                    <td><?php echo e($ligne->photo_path ? 'Oui' : 'Non'); ?></td>
                    <td><?php echo e($ligne->commentaire ?: '-'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <p style="margin-top: 30px; font-size: 10px; color: #666;">
        Document généré le <?php echo e(now()->format('d/m/Y à H:i')); ?>

    </p>
</body>
</html>
<?php /**PATH C:\laragon\www\haccp.grolleau\haccp-app\resources\views\controle\pdf.blade.php ENDPATH**/ ?>