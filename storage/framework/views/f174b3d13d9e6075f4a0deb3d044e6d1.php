

<?php $__env->startSection('content'); ?>
<div class="w-full px-2 py-4">
    <h1 class="text-4xl font-bold text-gray-800 mb-6">Gérer les tâches</h1>

    <?php if(session('success')): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-4 rounded mb-6 text-lg">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <a href="<?php echo e(route('nettoyage.taches.create')); ?>" class="inline-block w-full mb-6 bg-green-500 text-white px-6 py-4 rounded text-lg font-bold text-center" style="background:#22c55e;color:#fff;">
        ➕ Nouvelle tâche
    </a>

    <div class="bg-white rounded-lg shadow-md p-4">
        <?php if($taches->isEmpty()): ?>
            <p class="text-gray-600 text-lg">Aucune tâche créée.</p>
        <?php else: ?>
            <div class="space-y-3">
                <?php $__currentLoopData = $taches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tache): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border-2 border-gray-300 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800"><?php echo e($tache->nom); ?></h3>
                                <div class="mt-2">
                                    <?php if($tache->actif): ?>
                                        <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full font-bold" style="background:#dcfce7;color:#166534;">
                                            ✓ Actif
                                        </span>
                                    <?php else: ?>
                                        <span class="bg-gray-100 text-gray-800 px-4 py-2 rounded-full font-bold" style="background:#f3f4f6;color:#374151;">
                                            Inactif
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <a href="<?php echo e(route('nettoyage.taches.edit', $tache)); ?>" class="w-full bg-blue-500 text-white px-4 py-3 rounded text-lg font-bold text-center" style="background:#2563eb;color:#fff;">
                                Éditer
                            </a>
                            <form action="<?php echo e(route('nettoyage.taches.destroy', $tache)); ?>" method="POST" onsubmit="return confirm('Supprimer cette tâche ?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="w-full bg-red-500 text-white px-4 py-3 rounded text-lg font-bold" style="background:#ef4444;color:#fff;">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mt-6">
        <a href="<?php echo e(route('nettoyage.index')); ?>" class="inline-block bg-gray-600 text-white px-6 py-3 rounded text-lg font-bold" style="background:#4b5563;color:#fff;">
            ← Retour au nettoyage
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\haccp.grolleau\haccp-app\resources\views\nettoyage\taches\index.blade.php ENDPATH**/ ?>