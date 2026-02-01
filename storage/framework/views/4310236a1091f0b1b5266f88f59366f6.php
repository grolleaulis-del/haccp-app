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
            🌡️ Relevé de Températures
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
                <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">Sélectionnez un équipement</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php $__currentLoopData = $equipements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $lastReleve = $equipement->releves->first();
                            $isConforme = $lastReleve ? $lastReleve->conforme : null;
                        ?>
                        <a href="<?php echo e(route('temperatures.quick', $equipement)); ?>"
                           class="relative block p-6 rounded-xl border-2 transition-all duration-200 hover:scale-105 hover:shadow-lg
                                  <?php echo e($isConforme === true ? 'bg-green-50 border-green-300 hover:border-green-500' :
                                     ($isConforme === false ? 'bg-red-50 border-red-300 hover:border-red-500' :
                                     'bg-gray-50 border-gray-300 hover:border-blue-500')); ?>">

                            
                            <div class="text-center mb-3">
                                <h4 class="font-bold text-lg text-gray-900"><?php echo e($equipement->nom); ?></h4>
                            </div>

                            
                            <?php if($lastReleve): ?>
                                <div class="text-center">
                                    <div class="text-3xl font-bold <?php echo e($isConforme ? 'text-green-600' : 'text-red-600'); ?>">
                                        <?php echo e($lastReleve->temperature); ?>°C
                                    </div>
                                    <div class="text-xs text-gray-600 mt-1">
                                        <?php echo e($lastReleve->created_at->format('H:i')); ?>

                                    </div>
                                    <div class="mt-2 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                               <?php echo e($isConforme ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                        <?php echo e($isConforme ? '✓ Conforme' : '✗ Non conforme'); ?>

                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="text-center text-gray-500 text-sm italic">
                                    Aucun relevé
                                </div>
                            <?php endif; ?>

                            
                            <?php if($equipement->temperature_min && $equipement->temperature_max): ?>
                                <div class="mt-3 text-center text-xs text-gray-600">
                                    Plage: <?php echo e($equipement->temperature_min); ?>°C à <?php echo e($equipement->temperature_max); ?>°C
                                </div>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <div class="text-center">
                <a href="<?php echo e(route('temperatures.historique')); ?>"
                   class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 font-medium">
                    📊 Voir l'historique complet
                </a>
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
<?php /**PATH C:\laragon\www\haccp.grolleau\haccp-app\resources\views\temperatures\index.blade.php ENDPATH**/ ?>