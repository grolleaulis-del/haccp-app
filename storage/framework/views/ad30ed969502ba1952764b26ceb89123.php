<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Étiquettes - <?php echo e($lot->produit->nom); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: white;
        }

        .etiquette-page {
            page-break-after: always;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .etiquette {
            width: 55mm;
            height: 29mm;
            border: none;
            padding: 0;
            background: white;
        }

        .jour-box {
            background: #000 !important;
            color: white;
            text-align: center;
            padding: 2mm 0;
            min-height: 10mm;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-bottom: 0;
        }

        .jour-lettre {
            font-size: 32px;
            font-weight: 900;
            line-height: 0.9;
            color: white;
        }

        .jour-nom {
            font-size: 8px;
            font-weight: bold;
            margin-top: -0.5mm;
            color: white;
        }

        .content {
            padding: 1.5mm;
        }

        .produit-nom {
            font-size: 11px;
            font-weight: 900;
            text-align: center;
            margin-bottom: 1mm;
            text-transform: uppercase;
            border-bottom: 1px solid #000;
            padding-bottom: 0.5mm;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1mm;
            margin-bottom: 1mm;
        }

        .info-box {
            border: 1px solid #000;
            padding: 1mm;
            text-align: center;
        }

        .info-label {
            font-size: 6px;
            font-weight: bold;
            margin-bottom: 0.5mm;
        }

        .info-value {
            font-size: 8px;
            font-weight: 900;
        }

        .dlc-box {
            border: 2px solid #000;
            padding: 1mm;
            text-align: center;
            background: #fff;
        }

        .dlc-label {
            font-size: 6px;
            font-weight: bold;
            margin-bottom: 0.5mm;
        }

        .dlc-value {
            font-size: 10px;
            font-weight: 900;
        }

            @media print {
                .return-btn {
                    display: none;
                }

                .etiquette-page {
                page-break-after: always;
                min-height: 0;
                height: auto;
            }

            body {
                background: white;
            }

            .etiquette {
                box-shadow: none;
            }

            .jour-box {
                background: #000 !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }

            .jour-lettre,
            .jour-nom {
                color: white !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }

            @page {
                size: 55mm 29mm;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="return-btn" style="padding: 20px; text-align: center;">
        <a href="<?php echo e(route('cuisson-refroidissement.index')); ?>"
           style="display: inline-block; padding: 12px 24px; background-color: #f97316; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px;">
            ← Retour à la cuisson/refroidissement
        </a>
    </div>

    <script>
        // Imprimer automatiquement
        window.onload = function() {
            window.print();
        };
    </script>

<?php
    $joursDeLaSemaine = ['D', 'L', 'M', 'M', 'J', 'V', 'S'];
    $nomsJours = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
    $jourDLC = $lot->dlc->dayOfWeek;
    $lettreJour = $joursDeLaSemaine[$jourDLC];
    $nomJour = $nomsJours[$jourDLC];
    $joursRestants = now()->diffInDays($lot->dlc, false);
?>

<?php for($i = 1; $i <= $nombre; $i++): ?>
    <div class="etiquette-page">
        <div class="etiquette">
            <div class="jour-box">
                <div class="jour-lettre"><?php echo e($lettreJour); ?></div>
                <div class="jour-nom"><?php echo e($nomJour); ?></div>
            </div>

            <div class="content">
                <div class="produit-nom"><?php echo e($lot->produit->nom); ?></div>

                <div class="info-grid">
                    <div class="info-box">
                        <div class="info-label">DATE DLC</div>
                        <div class="info-value"><?php echo e($lot->dlc->format('d/m/Y')); ?></div>
                    </div>
                    <div class="info-box">
                        <div class="info-label">JOURS DLC</div>
                        <div class="info-value"><?php echo e($joursRestants); ?> J</div>
                    </div>
                </div>

                <div class="dlc-box">
                    <div class="dlc-label">PRODUIT LE</div>
                    <div class="dlc-value"><?php echo e($lot->date_production->format('d/m/Y H:i')); ?></div>
                </div>
            </div>
        </div>
    </div>
<?php endfor; ?>

</body>
</html>
<?php /**PATH C:\laragon\www\haccp.grolleau\haccp-app\resources\views\cuisson-refroidissement\print-labels.blade.php ENDPATH**/ ?>