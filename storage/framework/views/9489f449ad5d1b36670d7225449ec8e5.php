

<?php $__env->startSection('content'); ?>
<div class="w-full px-2 py-4">
    <h1 class="text-4xl font-bold text-gray-800 mb-6">Nettoyage HACCP</h1>

    <?php if(session('success')): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-4 rounded mb-6 text-lg">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Boutons d'action principaux -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-6">
        <a href="<?php echo e(route('nettoyage.create')); ?>" class="bg-blue-500 text-white px-6 py-4 rounded text-lg font-bold text-center" style="background:#2563eb;color:#fff;">
            ➕ Enregistrer un nettoyage
        </a>
        <a href="<?php echo e(route('nettoyage.taches')); ?>" class="bg-gray-600 text-white px-6 py-4 rounded text-lg font-bold text-center" style="background:#4b5563;color:#fff;">
            ⚙️ Gérer les tâches
        </a>
    </div>

    <!-- Filtre par date -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <label class="text-gray-700 font-bold text-lg">Date :</label>
            <input type="date" name="date" value="<?php echo e($date); ?>" class="border-2 border-gray-300 rounded px-4 py-2 text-lg flex-grow">
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded text-lg font-bold" style="background:#2563eb;color:#fff;">Filtrer</button>
        </form>
    </div>

    <!-- État des tâches du jour -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">État des tâches - <?php echo e(\Carbon\Carbon::parse($date)->format('d/m/Y')); ?></h2>

        <?php if($taches->isEmpty()): ?>
            <p class="text-gray-600 text-lg">Aucune tâche active.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                <?php $__currentLoopData = $taches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tache): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $completed = $tache->nettoyages->count() > 0;
                    ?>
                    <div class="border-4 rounded-lg p-5 text-center <?php echo e($completed ? 'border-green-500 bg-green-50' : 'border-gray-300 bg-gray-50'); ?>">
                        <div class="font-bold text-lg mb-3"><?php echo e($tache->nom); ?></div>
                        <?php if($completed): ?>
                            <div class="text-green-600 font-bold text-2xl mb-3">✓ Complétée</div>
                            <form method="POST" action="<?php echo e(route('nettoyage.quick', $tache)); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full bg-gray-400 text-white px-4 py-3 rounded text-lg font-bold" style="background:#9ca3af;color:#fff;">
                                    Nouvelle validation
                                </button>
                            </form>
                        <?php else: ?>
                            <form method="POST" action="<?php echo e(route('nettoyage.quick', $tache)); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full bg-green-500 text-white px-4 py-4 rounded text-xl font-bold" style="background:#22c55e;color:#fff;">
                                    ✓ VALIDER
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Historique du jour -->
    <div class="bg-white rounded-lg shadow-md p-4">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Historique du jour</h2>

        <?php if($historique->isEmpty()): ?>
            <p class="text-gray-600 text-lg">Aucun enregistrement pour cette date.</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border-2 px-4 py-3 text-left font-bold text-lg">Heure</th>
                            <th class="border-2 px-4 py-3 text-left font-bold text-lg">Tâche</th>
                            <th class="border-2 px-4 py-3 text-left font-bold text-lg">Utilisateur</th>
                            <th class="border-2 px-4 py-3 text-left font-bold text-lg">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $historique; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-100">
                                <td class="border-2 px-4 py-3 text-lg"><?php echo e($record->done_at->format('H:i')); ?></td>
                                <td class="border-2 px-4 py-3 font-semibold text-lg"><?php echo e($record->tache->nom); ?></td>
                                <td class="border-2 px-4 py-3 text-lg"><?php echo e($record->user->name); ?></td>
                                <td class="border-2 px-4 py-3">
                                    <div class="flex flex-col gap-2">
                                        <a href="<?php echo e(route('nettoyage.edit', $record)); ?>" class="bg-blue-500 text-white px-4 py-2 rounded text-center font-bold" style="background:#2563eb;color:#fff;">
                                            Éditer
                                        </a>
                                        <form action="<?php echo e(route('nettoyage.destroy', $record)); ?>" method="POST" onsubmit="return confirm('Supprimer ?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="w-full bg-red-500 text-white px-4 py-2 rounded font-bold" style="background:#ef4444;color:#fff;">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                <?php echo e($historique->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\haccp.grolleau\haccp-app\resources\views\nettoyage\index.blade.php ENDPATH**/ ?>