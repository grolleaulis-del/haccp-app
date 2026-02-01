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
            🌡️ Relevé - <?php echo e($equipement->nom); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            
            <div class="mb-6">
                <a href="<?php echo e(route('temperatures.index')); ?>"
                   class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Retour
                </a>
            </div>

            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <div class="text-center mb-8">
                        <h3 class="text-3xl font-bold text-gray-900 mb-2"><?php echo e($equipement->nom); ?></h3>
                        <?php if($equipement->temperature_min && $equipement->temperature_max): ?>
                            <p class="text-lg text-gray-600">
                                Température attendue: <?php echo e($equipement->temperature_min); ?>°C à <?php echo e($equipement->temperature_max); ?>°C
                            </p>
                        <?php endif; ?>
                    </div>

                    <form method="POST" action="<?php echo e(route('temperatures.quick.store', $equipement)); ?>" class="space-y-6">
                        <?php echo csrf_field(); ?>

                        
                        <div>
                            <label class="block text-xl font-semibold text-gray-700 mb-3">Température relevée</label>
                            <div class="flex items-center gap-4">
                                <input type="number"
                                       name="temperature"
                                       step="0.1"
                                       required
                                       autofocus
                                       class="flex-1 text-4xl text-center font-bold border-4 border-blue-300 rounded-xl py-6 focus:border-blue-500 focus:ring focus:ring-blue-200"
                                       placeholder="0.0">
                                <span class="text-4xl font-bold text-gray-600">°C</span>
                            </div>
                            <?php $__errorArgs = ['temperature'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-2 text-red-600 text-sm"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div>
                            <label class="block text-xl font-semibold text-gray-700 mb-3">Conformité</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="conforme" value="1" required
                                           class="peer sr-only">
                                    <div class="p-6 border-4 border-gray-300 rounded-xl text-center transition-all
                                                peer-checked:border-green-500 peer-checked:bg-green-50">
                                        <div class="text-5xl mb-2">✓</div>
                                        <div class="text-xl font-bold text-gray-900">Conforme</div>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="conforme" value="0" required
                                           class="peer sr-only">
                                    <div class="p-6 border-4 border-gray-300 rounded-xl text-center transition-all
                                                peer-checked:border-red-500 peer-checked:bg-red-50">
                                        <div class="text-5xl mb-2">✗</div>
                                        <div class="text-xl font-bold text-gray-900">Non conforme</div>
                                    </div>
                                </label>
                            </div>
                            <?php $__errorArgs = ['conforme'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-2 text-red-600 text-sm"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div x-data="{ showAction: false }">
                            <div x-show="showAction" style="display: none;">
                                <label class="block text-lg font-semibold text-gray-700 mb-2">Action corrective</label>
                                <textarea name="action_corrective" rows="3"
                                          class="w-full rounded-lg border-2 border-gray-300 focus:border-red-500 focus:ring focus:ring-red-200"
                                          placeholder="Décrivez l'action corrective prise..."></textarea>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const radios = document.querySelectorAll('input[name="conforme"]');
                                    radios.forEach(radio => {
                                        radio.addEventListener('change', function() {
                                            Alpine.evaluate(document.querySelector('[x-data]'), 'showAction = ' + (this.value === '0'));
                                        });
                                    });
                                });
                            </script>
                        </div>

                        
                        <div class="flex gap-4 pt-4">
                            <a href="<?php echo e(route('temperatures.index')); ?>"
                               class="flex-1 px-6 py-4 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 font-bold text-center text-xl">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="flex-1 px-6 py-4 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-bold text-xl">
                                ✓ Enregistrer
                            </button>
                        </div>
                    </form>
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
<?php /**PATH C:\laragon\www\haccp.grolleau\haccp-app\resources\views\temperatures\quick.blade.php ENDPATH**/ ?>