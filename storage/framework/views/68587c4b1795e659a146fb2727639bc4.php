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
            🏷️ Sélectionner le produit
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                        <div class="p-6 space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900">Photo du produit tracé</h3>
                            <?php if(!empty($photoData)): ?>
                                <div class="flex justify-center">
                                    <img src="<?php echo e($photoData); ?>" alt="Étiquette"
                                         class="w-40 h-40 object-cover rounded-lg border-2 border-gray-300">
                                </div>
                            <?php else: ?>
                                <div class="p-4 border-2 border-dashed border-gray-300 rounded-lg text-center text-gray-500">
                                    Pas de photo fournie
                                </div>
                            <?php endif; ?>
                            <?php if(!empty($skipPhoto)): ?>
                                <div class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">
                                    Étape photo ignorée
                                </div>
                            <?php endif; ?>

                            
                            <div class="space-y-2 pt-4 border-t">
                                <a href="<?php echo e(route('scan-etiquette.index')); ?>"
                                   class="block w-full px-4 py-3 bg-gray-600 text-white text-center font-semibold rounded-lg hover:bg-gray-700 transition">
                                    ← Reprendre photo
                                </a>
                                <button type="submit" form="selectProduitForm"
                                        class="w-full px-4 py-3 bg-green-600 text-white text-center font-semibold rounded-lg hover:bg-green-700 transition">
                                    💾 Enregistrer le lot
                                </button>

                                
                                <div class="mt-3">
                                    <label for="commentaire" class="block text-sm font-medium text-gray-700 mb-2">
                                        Commentaire (optionnel)
                                    </label>
                                    <textarea form="selectProduitForm" name="commentaire" id="commentaire" rows="2"
                                              class="w-full rounded-md border-gray-300"
                                              placeholder="Informations complémentaires..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                Sélectionnez le produit correspondant
                            </h3>

                            <form method="POST" action="<?php echo e(route('scan-etiquette.store-lot')); ?>" id="selectProduitForm">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="photo" value="<?php echo e($photoData); ?>">
                                <input type="hidden" name="skip_photo" value="<?php echo e(!empty($skipPhoto) ? 1 : 0); ?>">



                                
                                <div class="mb-4">
                                    <input type="text"
                                           id="searchProduct"
                                           placeholder="Rechercher un produit..."
                                           class="w-full px-4 py-3 text-base border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                
                                <div class="space-y-6 max-h-[600px] overflow-y-auto pr-2">
                                    <?php
                                        $produitsParFamille = $produits->groupBy('famille');
                                    ?>

                                    <?php $__currentLoopData = $produitsParFamille; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $famille => $produitsGroupe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div>
                                            <h4 class="text-md font-bold text-gray-800 mb-3 bg-gray-100 px-3 py-2 rounded">
                                                <?php echo e($famille); ?>

                                            </h4>
                                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 ml-2">
                                                <?php $__currentLoopData = $produitsGroupe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <label class="relative cursor-pointer group produit-card" data-product-name="<?php echo e(strtolower($produit->nom)); ?>">
                                                        <input type="radio"
                                                               name="produit_id"
                                                               value="<?php echo e($produit->id); ?>"
                                                               class="peer sr-only"
                                                               required>
                                                        <div class="p-4 border-2 border-gray-300 rounded-lg hover:border-blue-500 peer-checked:border-green-600 peer-checked:bg-green-50 transition-all">
                                                            <div class="text-center">
                                                                <div class="text-3xl mb-2">
                                                                    <?php if($produit->lotActif): ?>
                                                                        ✅
                                                                    <?php else: ?>
                                                                        📦
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="text-sm font-semibold text-gray-900">
                                                                    <?php echo e($produit->nom); ?>

                                                                </div>
                                                                <?php if($produit->lotActif): ?>
                                                                    <div class="text-xs text-green-600 mt-1">
                                                                        Lot actif
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </label>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                            </form>

                        </div>
                    </div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchProduct');
    if (!searchInput) return;
    const cards = Array.from(document.querySelectorAll('.produit-card'));

    searchInput.addEventListener('input', function() {
        const term = this.value.toLowerCase().trim();
        cards.forEach(card => {
            const name = card.getAttribute('data-product-name');
            card.style.display = name.includes(term) ? '' : 'none';
        });
    });
});
</script>

<?php /**PATH C:\laragon\www\haccp.grolleau\haccp-app\resources\views\scan-etiquette\select-produit.blade.php ENDPATH**/ ?>