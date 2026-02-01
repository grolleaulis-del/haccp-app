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
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Arrivage du <?php echo e($arrivage->date_arrivage->format('d/m/Y')); ?> - <?php echo e($arrivage->fournisseur->nom); ?>

            </h2>
            <div class="flex gap-2">
                <a href="<?php echo e(route('arrivages.edit', $arrivage)); ?>" class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 font-medium text-sm">
                    Éditer
                </a>
                <a href="<?php echo e(route('arrivages.index')); ?>" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 font-medium text-sm">
                    Retour
                </a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Fournisseur</p>
                            <p class="font-medium text-gray-900"><?php echo e($arrivage->fournisseur->nom); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Date</p>
                            <p class="font-medium text-gray-900"><?php echo e($arrivage->date_arrivage->format('d/m/Y')); ?></p>
                        </div>
                    </div>

                    <?php if($arrivage->bl_path): ?>
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Bon de livraison</p>
                            <a href="<?php echo e(Storage::disk('public')->url($arrivage->bl_path)); ?>" target="_blank" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                                📄 Télécharger
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if($arrivage->commentaire): ?>
                        <div>
                            <p class="text-sm text-gray-500">Commentaire</p>
                            <p class="text-gray-700"><?php echo e($arrivage->commentaire); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="font-semibold text-lg text-gray-900 mb-4">
                        Produits reçus (<?php echo e($arrivage->lignes->count()); ?>)
                    </h3>

                    <?php if($arrivage->lignes->isEmpty()): ?>
                        <p class="text-gray-500 text-center py-8">Aucun produit reçu</p>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php $__currentLoopData = $arrivage->lignes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ligne): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="border border-gray-200 rounded-lg p-4 flex justify-between items-start">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900"><?php echo e($ligne->produit->nom); ?></h4>
                                        <p class="text-sm text-gray-500"><?php echo e($ligne->produit->famille); ?></p>

                                        <?php if($ligne->numero_lot): ?>
                                            <p class="text-sm text-gray-700 mt-2">
                                                <strong>Lot:</strong> <?php echo e($ligne->numero_lot); ?>

                                            </p>
                                        <?php endif; ?>

                                        <?php if($ligne->photo_path): ?>
                                            <p class="mt-2">
                                                <a href="<?php echo e(Storage::disk('public')->url($ligne->photo_path)); ?>" target="_blank" class="text-blue-600 hover:text-blue-700 text-sm">
                                                    🖼️ Voir photo
                                                </a>
                                            </p>
                                        <?php endif; ?>

                                        <?php if($ligne->commentaire): ?>
                                            <p class="text-sm text-gray-700 mt-2"><?php echo e($ligne->commentaire); ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <p class="text-xs text-gray-400"><?php echo e($ligne->created_at->format('d/m/Y H:i')); ?></p>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>

                    <button type="button" class="mt-6 text-blue-600 hover:text-blue-700 text-sm font-medium" onclick="toggleAddLigneForm()">
                        + Ajouter une ligne
                    </button>
                </div>
            </div>

            
            <div id="add-ligne-form" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hidden">
                <div class="p-6">
                    <h4 class="font-semibold text-gray-900 mb-4">Ajouter une ligne</h4>

                    <form method="POST" action="<?php echo e(route('arrivages.addLigne', $arrivage)); ?>" enctype="multipart/form-data" class="space-y-4">
                        <?php echo csrf_field(); ?>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Produit <span class="text-red-600">*</span>
                                </label>
                                <select name="produit_id" required class="w-full rounded-md border-gray-300">
                                    <option value="">-- Sélectionner --</option>
                                    <?php $__currentLoopData = $produits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($p->id); ?>"><?php echo e($p->nom); ?> (<?php echo e($p->famille); ?>)</option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Numéro lot
                                </label>
                                <input type="text" name="numero_lot" placeholder="ex: LOT123" class="w-full rounded-md border-gray-300">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Photo étiquette
                                </label>
                                <input type="file" name="photo" accept="image/*" class="w-full rounded-md border-gray-300">
                                <p class="text-xs text-gray-500 mt-1">Max 5 MB</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Commentaire
                                </label>
                                <input type="text" name="commentaire" class="w-full rounded-md border-gray-300">
                            </div>
                        </div>

                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm font-medium">
                                Ajouter
                            </button>
                            <button type="button" onclick="toggleAddLigneForm()" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 text-sm font-medium">
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        function toggleAddLigneForm() {
            document.getElementById('add-ligne-form').classList.toggle('hidden');
        }
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
<?php /**PATH C:\laragon\www\haccp.grolleau\haccp-app\resources\views\arrivages\show.blade.php ENDPATH**/ ?>