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
            ✅ Cuisson enregistrée
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                <div class="text-6xl mb-6">✅</div>
                <h3 class="text-3xl font-bold text-green-600 mb-4">Cuisson enregistrée avec succès !</h3>

                <div class="bg-gray-50 rounded-lg p-6 mb-6 text-left">
                    <h4 class="font-bold text-gray-900 mb-4 text-xl">Détails de la cuisson</h4>
                    <div class="space-y-2">
                        <p><span class="font-semibold">Produit:</span> <?php echo e($lot->produit->nom); ?></p>
                        <p><span class="font-semibold">Quantité:</span> <?php echo e($lot->quantite); ?></p>
                        <p><span class="font-semibold">Date de production:</span> <?php echo e($lot->date_production->format('d/m/Y H:i')); ?></p>
                        <p><span class="font-semibold">DLC:</span> <?php echo e($lot->dlc->format('d/m/Y')); ?></p>
                        <?php if($lot->temperature_cuisson): ?>
                            <p><span class="font-semibold">Température cuisson:</span> <?php echo e($lot->temperature_cuisson); ?>°C</p>
                        <?php endif; ?>
                        <?php if($lot->temperature_refroidissement): ?>
                            <p><span class="font-semibold">Température refroidissement:</span> <?php echo e($lot->temperature_refroidissement); ?>°C</p>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if($lot->photo_etiquette): ?>
                    <div class="mb-6">
                        <img src="<?php echo e(asset('storage/' . $lot->photo_etiquette)); ?>"
                             alt="Photo étiquette"
                             class="max-w-full h-auto rounded-lg border-4 border-gray-300 mx-auto">
                    </div>
                <?php endif; ?>

                
                <div class="bg-blue-50 rounded-lg p-6 mb-6">
                    <h4 class="font-bold text-gray-900 mb-4 text-lg">🏷️ Imprimer des étiquettes</h4>
                    <form action="<?php echo e(route('cuisson-refroidissement.print-labels', $lot)); ?>" method="POST" target="_blank" class="flex gap-4 items-end">
                        <?php echo csrf_field(); ?>
                        <div class="flex-1 text-left">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre d'étiquettes</label>
                            <input type="number" name="nombre_etiquettes" value="1" min="1" max="20"
                                   class="w-full rounded-md border-gray-300 text-lg py-3">
                        </div>
                        <button type="submit" class="px-8 py-3 bg-blue-600 text-white text-lg font-bold rounded-lg hover:bg-blue-700">
                            🖨️ Imprimer
                        </button>
                    </form>
                </div>

                <div class="flex gap-4">
                    <a href="<?php echo e(route('cuisson-refroidissement.index')); ?>"
                       class="flex-1 py-4 bg-orange-600 text-white text-lg font-bold rounded-xl hover:bg-orange-700">
                        🔥 Nouvelle cuisson
                    </a>
                    <a href="<?php echo e(route('dashboard')); ?>"
                       class="flex-1 py-4 bg-gray-600 text-white text-lg font-bold rounded-xl hover:bg-gray-700">
                        🏠 Retour au dashboard
                    </a>
                </div>
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
<?php /**PATH C:\laragon\www\haccp.grolleau\haccp-app\resources\views\cuisson-refroidissement\success.blade.php ENDPATH**/ ?>