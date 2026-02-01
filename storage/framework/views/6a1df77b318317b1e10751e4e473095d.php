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
            <?php echo e(__('Nouvel arrivage')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            
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

                    <form method="POST" action="<?php echo e(route('arrivages.store')); ?>" enctype="multipart/form-data" class="space-y-6">
                        <?php echo csrf_field(); ?>

                        
                        <div>
                            <label for="fournisseur_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Fournisseur <span class="text-red-600">*</span>
                            </label>
                            <select name="fournisseur_id" id="fournisseur_id" required class="w-full rounded-md border-gray-300 <?php $__errorArgs = ['fournisseur_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">-- Sélectionner --</option>
                                <?php $__currentLoopData = $fournisseurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($f->id); ?>" <?php echo e(old('fournisseur_id') == $f->id ? 'selected' : ''); ?>>
                                        <?php echo e($f->nom); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['fournisseur_id'];
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
                            <label for="date_arrivage" class="block text-sm font-medium text-gray-700 mb-2">
                                Date <span class="text-red-600">*</span>
                            </label>
                            <input type="date" name="date_arrivage" id="date_arrivage" value="<?php echo e(old('date_arrivage', now()->format('Y-m-d'))); ?>" required class="w-full rounded-md border-gray-300 <?php $__errorArgs = ['date_arrivage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['date_arrivage'];
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
                            <label for="bl_file" class="block text-sm font-medium text-gray-700 mb-2">
                                Bon de livraison (PDF/Image)
                            </label>
                            <input type="file" name="bl_file" id="bl_file" accept=".pdf,.jpg,.jpeg,.png" class="w-full rounded-md border-gray-300">
                            <p class="text-xs text-gray-500 mt-1">Max 5 MB (PDF, JPG, PNG)</p>
                            <?php $__errorArgs = ['bl_file'];
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
                            <label for="commentaire" class="block text-sm font-medium text-gray-700 mb-2">
                                Commentaire
                            </label>
                            <textarea name="commentaire" id="commentaire" rows="3" class="w-full rounded-md border-gray-300"><?php echo e(old('commentaire')); ?></textarea>
                        </div>

                        
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-4">Produits reçus</h3>
                            <div id="lignes-container" class="space-y-4">
                                <div class="ligne-item p-4 border border-gray-300 rounded">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Produit <span class="text-red-600">*</span>
                                            </label>
                                            <select name="lignes[0][produit_id]" required class="w-full rounded-md border-gray-300">
                                                <option value="">-- Sélectionner --</option>
                                                <?php $__currentLoopData = $produits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($p->id); ?>"><?php echo e($p->nom); ?> (<?php echo e($p->famille); ?>)</option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Numéro lot
                                            </label>
                                            <input type="text" name="lignes[0][numero_lot]" placeholder="ex: LOT123" class="w-full rounded-md border-gray-300">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Photo étiquette
                                            </label>
                                            <input type="file" name="lignes[0][photo]" accept="image/*" class="w-full rounded-md border-gray-300">
                                            <p class="text-xs text-gray-500 mt-1">Max 5 MB</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Commentaire
                                            </label>
                                            <input type="text" name="lignes[0][commentaire]" class="w-full rounded-md border-gray-300">
                                        </div>
                                    </div>
                                    <button type="button" class="mt-4 text-sm text-red-600 hover:text-red-700 remove-ligne">
                                        Supprimer cette ligne
                                    </button>
                                </div>
                            </div>
                            <button type="button" id="add-ligne-btn" class="mt-4 text-sm text-blue-600 hover:text-blue-700">
                                + Ajouter une ligne
                            </button>
                        </div>

                        
                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 font-medium">
                                Créer l'arrivage
                            </button>
                            <a href="<?php echo e(route('arrivages.index')); ?>" class="px-6 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 font-medium">
                                Annuler
                            </a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let ligneCount = 1;

            document.getElementById('add-ligne-btn').addEventListener('click', function() {
                const container = document.getElementById('lignes-container');
                const newLigne = document.querySelector('.ligne-item').cloneNode(true);

                // Update field names
                newLigne.querySelectorAll('[name]').forEach(input => {
                    input.name = input.name.replace(/\[0\]/g, '[' + ligneCount + ']');
                    input.value = '';
                });

                newLigne.querySelector('.remove-ligne').addEventListener('click', function() {
                    newLigne.remove();
                });

                container.appendChild(newLigne);
                ligneCount++;
            });

            document.querySelectorAll('.remove-ligne').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.closest('.ligne-item').remove();
                });
            });
        });
    </script>
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
<?php /**PATH C:\laragon\www\haccp.grolleau\haccp-app\resources\views\arrivages\create.blade.php ENDPATH**/ ?>