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
            🔥 NOUVEAU FORMULAIRE - <?php echo e($produit->nom); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    
                    <div class="mb-6 p-4 bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg border-2 border-orange-300">
                        <h3 class="font-semibold text-gray-900 mb-2 text-xl"><?php echo e($produit->nom); ?></h3>
                        <p class="text-sm text-gray-700">
                            <strong>Famille:</strong> <?php echo e($produit->famille); ?>

                        </p>
                        <?php if($produit->dlc_cuisson_defaut_jours): ?>
                            <p class="text-sm text-orange-700 font-semibold mt-1">
                                📅 DLC par défaut: <?php echo e($produit->dlc_cuisson_defaut_jours); ?> jours
                            </p>
                        <?php endif; ?>
                    </div>

                    
                    <form method="POST" action="<?php echo e(route('cuisson-refroidissement.store')); ?>" class="space-y-6">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="produit_id" value="<?php echo e($produit->id); ?>">

                        
                        <?php if (isset($component)) { $__componentOriginal071b46241508c66a1c84114f4aaa7e25 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal071b46241508c66a1c84114f4aaa7e25 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.camera-capture','data' => ['name' => 'photo','label' => '📸 Photo de l\'étiquette','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('camera-capture'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'photo','label' => '📸 Photo de l\'étiquette','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal071b46241508c66a1c84114f4aaa7e25)): ?>
<?php $attributes = $__attributesOriginal071b46241508c66a1c84114f4aaa7e25; ?>
<?php unset($__attributesOriginal071b46241508c66a1c84114f4aaa7e25); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal071b46241508c66a1c84114f4aaa7e25)): ?>
<?php $component = $__componentOriginal071b46241508c66a1c84114f4aaa7e25; ?>
<?php unset($__componentOriginal071b46241508c66a1c84114f4aaa7e25); ?>
<?php endif; ?>

                        
                        <div>
                            <label for="dlc_jours" class="block text-lg font-bold text-gray-900 mb-2">
                                📅 DLC (nombre de jours) <span class="text-red-600">*</span>
                            </label>
                            <input type="number"
                                   name="dlc_jours"
                                   id="dlc_jours"
                                   min="1"
                                   value="<?php echo e(old('dlc_jours', $produit->dlc_cuisson_defaut_jours ?? 3)); ?>"
                                   required
                                   class="w-full text-3xl p-6 border-4 border-orange-300 rounded-xl focus:border-orange-500 focus:ring focus:ring-orange-200 font-bold text-center">
                            <p class="text-sm text-gray-600 mt-2 text-center">Modifiez si nécessaire</p>
                        </div>

                        
                        <div>
                            <label for="nombre_etiquettes" class="block text-lg font-bold text-gray-900 mb-2">
                                🏷️ Nombre d'étiquettes à imprimer <span class="text-red-600">*</span>
                            </label>
                            <input type="number"
                                   name="nombre_etiquettes"
                                   id="nombre_etiquettes"
                                   min="1"
                                   max="20"
                                   value="<?php echo e(old('nombre_etiquettes', 1)); ?>"
                                   required
                                   class="w-full text-3xl p-6 border-4 border-blue-300 rounded-xl focus:border-blue-500 focus:ring focus:ring-blue-200 font-bold text-center">
                            <p class="text-sm text-gray-600 mt-2 text-center">Nombre de contenants</p>
                        </div>

                        
                        <input type="hidden" name="quantite" value="1">

                        
                        <div class="flex gap-4 pt-4">
                            <a href="<?php echo e(route('cuisson-refroidissement.index')); ?>"
                               class="flex-1 py-6 bg-gray-600 text-white text-xl font-bold rounded-xl hover:bg-gray-700 text-center">
                                ← Annuler
                            </a>
                            <button type="submit"
                                    class="flex-1 py-6 bg-green-600 text-white text-xl font-bold rounded-xl hover:bg-green-700">
                                ✓ Valider et imprimer
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
<!-- v:1769258988 -->
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
<?php /**PATH C:\laragon\www\haccp.grolleau\haccp-app\resources\views\cuisson-refroidissement\create.blade.php ENDPATH**/ ?>