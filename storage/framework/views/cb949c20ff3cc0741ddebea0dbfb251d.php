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
            <?php echo e(__('Changer le lot')); ?> - <?php echo e($produit->nom); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            
            <?php if($errors->any()): ?>
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    
                    <div class="mb-6 p-4 bg-gray-50 rounded">
                        <h3 class="font-semibold text-gray-900 mb-2"><?php echo e($produit->nom); ?></h3>
                        <p class="text-sm text-gray-600">
                            <strong>Famille:</strong> <?php echo e($produit->famille); ?>

                        </p>
                        <p class="text-sm text-gray-600">
                            <strong>Mode traçabilité:</strong>
                            <?php echo e($produit->mode_tracabilite === 'etiquette_photo' ? 'Photo étiquette' : 'Code interne'); ?>

                        </p>
                    </div>

                    
                    <?php if($lotActif): ?>
                        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded">
                            <p class="text-sm text-blue-800 font-semibold mb-2">Lot actif actuel:</p>
                            <p class="text-sm text-blue-800">
                                Démarré le: <?php echo e($lotActif->started_at->format('d/m/Y H:i')); ?>

                            </p>
                            <?php if($lotActif->code_interne): ?>
                                <p class="text-sm text-blue-800">
                                    Code: <?php echo e($lotActif->code_interne); ?>

                                </p>
                            <?php endif; ?>
                            <p class="text-sm text-blue-800 italic mt-2">
                                (Ce lot sera clôturé et un nouveau créé)
                            </p>
                        </div>
                    <?php endif; ?>

                    
                    <form method="POST" action="<?php echo e(route('usage-quotidien.changer', $produit)); ?>" enctype="multipart/form-data" class="space-y-6">
                        <?php echo csrf_field(); ?>

                        
                        <?php if($produit->mode_tracabilite === 'etiquette_photo'): ?>
                            <?php if (isset($component)) { $__componentOriginal071b46241508c66a1c84114f4aaa7e25 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal071b46241508c66a1c84114f4aaa7e25 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.camera-capture','data' => ['name' => 'photo','label' => 'Photo étiquette','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('camera-capture'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'photo','label' => 'Photo étiquette','required' => true]); ?>
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
                            <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <?php else: ?>
                            
                            <div>
                                <label for="code_interne" class="block text-sm font-medium text-gray-700 mb-2">
                                    Code interne <span class="text-red-600">*</span>
                                </label>
                                <input type="text"
                                       name="code_interne"
                                       id="code_interne"
                                       class="w-full rounded-md border-gray-300
                                              <?php $__errorArgs = ['code_interne'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       required>
                                <?php $__errorArgs = ['code_interne'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            
                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                                    Photo (optionnelle)
                                </label>
                                <input type="file"
                                       name="photo"
                                       id="photo"
                                       accept="image/*"
                                       class="w-full rounded-md border-gray-300">
                                <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <p class="text-xs text-gray-500 mt-1">Max 5 MB</p>
                            </div>
                        <?php endif; ?>

                        
                        <div>
                            <label for="commentaire" class="block text-sm font-medium text-gray-700 mb-2">
                                Commentaire
                            </label>
                            <textarea name="commentaire"
                                      id="commentaire"
                                      rows="3"
                                      class="w-full rounded-md border-gray-300"></textarea>
                            <?php $__errorArgs = ['commentaire'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 font-medium">
                                Créer le nouveau lot
                            </button>
                            <a href="<?php echo e(route('usage-quotidien.index')); ?>" class="px-6 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 font-medium">
                                Annuler
                            </a>
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
<?php /**PATH C:\laragon\www\haccp.grolleau\haccp-app\resources\views\usage-quotidien\changer-lot.blade.php ENDPATH**/ ?>