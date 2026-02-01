<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body class="font-sans antialiased touch-theme">
        <?php $slot = $slot ?? null; ?>
        <div class="touch-shell min-h-screen">
            <?php echo $__env->make('layouts.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <!-- Page Heading -->
            <?php if(isset($header)): ?>
                <header class="touch-page-header">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <?php echo e($header); ?>

                    </div>
                </header>
            <?php endif; ?>

            <!-- Page Content -->
            <main class="touch-main">
                
                <?php if(isset($slot)): ?>
                    <?php echo e($slot); ?>

                <?php endif; ?>
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>

        
        <script>
            let inactivityTimer;
            // Récupérer le délai depuis les paramètres (en minutes, converti en millisecondes)
            const INACTIVITY_TIMEOUT = <?php echo e(\App\Models\Setting::get('inactivity_timeout', 5)); ?> * 60 * 1000;

            function resetInactivityTimer() {
                clearTimeout(inactivityTimer);

                inactivityTimer = setTimeout(() => {
                    // Redirection vers la page de sélection employé
                    window.location.href = '<?php echo e(route("employe-session.index")); ?>';
                }, INACTIVITY_TIMEOUT);
            }

            // Événements à surveiller pour réinitialiser le timer
            ['mousedown', 'keypress', 'touchstart', 'click'].forEach(event => {
                document.addEventListener(event, resetInactivityTimer, true);
            });

            // Démarrer le timer au chargement
            resetInactivityTimer();
        </script>
    </body>
</html>
<?php /**PATH C:\laragon\www\haccp.grolleau\haccp-app\resources\views\layouts\app.blade.php ENDPATH**/ ?>