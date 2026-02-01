<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélection Employé - HACCP</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gradient-to-br from-blue-500 to-blue-700 min-h-screen">
    <div class="container mx-auto px-4 py-8">

        
        <div class="mb-12">
            
            <div class="flex items-center gap-4 mb-8">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Huitres Grolleau-Its" class="h-24 w-24 drop-shadow-2xl">
                <div>
                    <h1 class="text-5xl font-bold text-white">🍴 HACCP</h1>
                </div>
            </div>
            <p class="text-2xl text-white text-center">Sélectionnez votre nom pour commencer</p>
        </div>

        
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php $__currentLoopData = $employes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('employe-session.select', $employe)); ?>"
                       class="group block bg-white rounded-2xl shadow-2xl hover:shadow-3xl transform hover:scale-105 transition-all duration-300 p-8 text-center">

                        
                        <div class="mb-4 flex justify-center">
                            <div class="w-24 h-24 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white text-4xl font-bold group-hover:from-green-400 group-hover:to-green-600 transition-all duration-300">
                                <?php echo e(strtoupper(substr($employe->name, 0, 1))); ?>

                            </div>
                        </div>

                        
                        <h3 class="text-xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors">
                            <?php echo e($employe->name); ?>

                        </h3>

                        
                        <?php if($employe->email): ?>
                            <p class="text-sm text-gray-500 mt-2"><?php echo e($employe->email); ?></p>
                        <?php endif; ?>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        
        <div class="text-center mt-12">
            <p class="text-white text-sm">
                © <?php echo e(date('Y')); ?> Système HACCP - Tous droits réservés
            </p>
        </div>

    </div>

    
    <script>
        // Rafraîchir la page toutes les heures si aucune activité
        setTimeout(() => {
            location.reload();
        }, 3600000); // 1 heure
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\haccp.grolleau\haccp-app\resources\views\employe-session\index.blade.php ENDPATH**/ ?>