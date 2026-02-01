<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Arrivages')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            
            <?php if(session('success')): ?>
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            
            <div class="mb-6">
                <a href="<?php echo e(route('arrivages.create')); ?>"
                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-medium">
                    + Nouvel arrivage
                </a>
            </div>

            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="<?php echo e(route('arrivages.index')); ?>"
                        class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <div>
                            <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-1">
                                Date début
                            </label>
                            <input type="date" name="date_debut" id="date_debut" value="<?php echo e($date_debut); ?>"
                                class="w-full rounded-md border-gray-300">
                        </div>
                        <div>
                            <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-1">
                                Date fin
                            </label>
                            <input type="date" name="date_fin" id="date_fin" value="<?php echo e($date_fin); ?>"
                                class="w-full rounded-md border-gray-300">
                        </div>
                        <div>
                            <label for="fournisseur_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Fournisseur
                            </label>
                            <select name="fournisseur_id" id="fournisseur_id" class="w-full rounded-md border-gray-300">
                                <option value="">-- Tous --</option>
                                <?php $__currentLoopData = $fournisseurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($f->id); ?>"
                                        <?php echo e($fournisseur_id == $f->id ? 'selected' : ''); ?>>
                                        <?php echo e($f->nom); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Filtrer
                        </button>
                    </form>
                </div>
            </div>

            
            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $arrivages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $arrivage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-start gap-4">
                                
                                <?php
                                    $firstPhoto = $arrivage->lignes->where('photo_path', '!=', null)->first();
                                ?>
                                <?php if($firstPhoto): ?>
                                    <div class="flex-shrink-0">
                                        <img src="<?php echo e(Storage::disk('public')->url($firstPhoto->photo_path)); ?>"
                                            alt="Photo"
                                            class="w-24 h-24 object-cover rounded-lg border border-gray-200">
                                    </div>
                                <?php else: ?>
                                    <div
                                        class="flex-shrink-0 w-24 h-24 bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center">
                                        <span class="text-gray-400 text-xs">Pas de photo</span>
                                    </div>
                                <?php endif; ?>

                                
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        <?php echo e($arrivage->fournisseur->nom); ?> -
                                        <?php echo e($arrivage->date_arrivage->format('d/m/Y')); ?>

                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        <strong>Lignes:</strong> <?php echo e($arrivage->lignes->count()); ?>

                                    </p>
                                    <?php if($arrivage->commentaire): ?>
                                        <p class="text-sm text-gray-600 mt-2">
                                            <strong>Commentaire:</strong> <?php echo e($arrivage->commentaire); ?>

                                        </p>
                                    <?php endif; ?>
                                </div>

                                
                                <div class="flex-shrink-0 flex gap-2">
                                    <a href="<?php echo e(route('arrivages.show', $arrivage)); ?>"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                                        Voir
                                    </a>
                                    <a href="<?php echo e(route('arrivages.edit', $arrivage)); ?>"
                                        class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 text-sm">
                                        Éditer
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center text-gray-500">
                            Aucun arrivage trouvé.
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            
            <div class="mt-6">
                <?php echo e($arrivages->links()); ?>

            </div>

        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\haccp.grolleau\haccp-app\resources\views\arrivages\index.blade.php ENDPATH**/ ?>