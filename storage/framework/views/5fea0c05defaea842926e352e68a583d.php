

<?php $__env->startSection('content'); ?>
<div class="w-full px-2 py-4">
    <h1 class="text-4xl font-bold text-gray-800 mb-6">Modifier un nettoyage</h1>

    <?php if($errors->any()): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-4 rounded mb-6 text-lg">
            <ul class="list-disc list-inside">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-lg shadow-md p-4">
        <form action="<?php echo e(route('nettoyage.update', $nettoyage)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>

            <!-- Sélection de la tâche -->
            <div class="mb-6">
                <label class="block text-gray-700 font-bold text-lg mb-3">Tâche de nettoyage <span class="text-red-500">*</span></label>
                <select name="tache_nettoyage_id" required class="w-full border-2 border-gray-300 rounded px-4 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Sélectionner une tâche --</option>
                    <?php $__currentLoopData = $taches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tache): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($tache->id); ?>" <?php echo e($nettoyage->tache_nettoyage_id == $tache->id ? 'selected' : ''); ?>>
                            <?php echo e($tache->nom); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['tache_nettoyage_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-lg mt-2"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Date et heure -->
            <div class="mb-6">
                <label class="block text-gray-700 font-bold text-lg mb-3">Date et heure <span class="text-red-500">*</span></label>
                <input type="datetime-local" name="done_at" required
                    value="<?php echo e($nettoyage->done_at->format('Y-m-d\TH:i')); ?>"
                    class="w-full border-2 border-gray-300 rounded px-4 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <?php $__errorArgs = ['done_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-lg mt-2"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Commentaire -->
            <div class="mb-6">
                <label class="block text-gray-700 font-bold text-lg mb-3">Commentaire (optionnel)</label>
                <textarea name="commentaire" rows="4" class="w-full border-2 border-gray-300 rounded px-4 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo e($nettoyage->commentaire); ?></textarea>
                <?php $__errorArgs = ['commentaire'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-lg mt-2"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Informations -->
            <div class="mb-6 bg-gray-100 p-4 rounded text-lg text-gray-700">
                <p><strong>Créé par :</strong> <?php echo e($nettoyage->user->name ?? 'N/A'); ?> le <?php echo e($nettoyage->created_at->format('d/m/Y H:i')); ?></p>
            </div>

            <!-- Boutons -->
            <div class="flex flex-col gap-3">
                <button type="submit" class="w-full bg-blue-500 text-white px-6 py-4 rounded font-bold text-lg" style="background:#2563eb;color:#fff;">
                    ✓ Mettre à jour
                </button>
                <a href="<?php echo e(route('nettoyage.index')); ?>" class="w-full bg-gray-500 text-white px-6 py-4 rounded font-bold text-lg text-center" style="background:#6b7280;color:#fff;">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\haccp.grolleau\haccp-app\resources\views\nettoyage\edit.blade.php ENDPATH**/ ?>