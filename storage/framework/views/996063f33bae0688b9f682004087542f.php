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
            <?php echo e(__('Usage Quotidien')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            
            <?php if($errors->any()): ?>
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if(session('success')): ?>
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            
            <?php if(!$familleSelectionnee): ?>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Sélectionnez une catégorie</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <?php $__currentLoopData = $familles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $famille): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('usage-quotidien.index', ['famille' => $famille->famille])); ?>"
                                   class="block p-6 bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-lg hover:from-blue-100 hover:to-blue-200 hover:border-blue-300 transition-all duration-200 shadow-sm hover:shadow-md">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-lg font-bold text-gray-900"><?php echo e($famille->famille); ?></h4>
                                            <p class="text-sm text-gray-600 mt-1"><?php echo e($famille->count); ?> produit(s)</p>
                                        </div>
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">📋 Lots créés aujourd'hui (<?php echo e($lotsAujourdhui->count()); ?>)</h3>

                        <?php if($lotsAujourdhui->count() > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Heure</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produit</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">N° Lot</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Photo</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employé</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php $__currentLoopData = $lotsAujourdhui; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                            <?php echo e($lot->started_at->format('H:i')); ?>

                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            <?php echo e($lot->produit->nom ?? 'N/A'); ?>

                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                            <?php echo e($lot->numero_lot ?? $lot->code_interne ?? '-'); ?>

                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <?php if($lot->photo_etiquette): ?>
                                                <a href="<?php echo e(asset('storage/' . $lot->photo_etiquette)); ?>" target="_blank">
                                                    <img src="<?php echo e(asset('storage/' . $lot->photo_etiquette)); ?>"
                                                         alt="Photo"
                                                         class="h-16 w-16 object-cover rounded border-2 border-gray-300 hover:border-blue-500 transition cursor-pointer">
                                                </a>
                                            <?php elseif($lot->photo_path): ?>
                                                <a href="<?php echo e(asset('storage/' . $lot->photo_path)); ?>" target="_blank">
                                                    <img src="<?php echo e(asset('storage/' . $lot->photo_path)); ?>"
                                                         alt="Photo"
                                                         class="h-16 w-16 object-cover rounded border-2 border-gray-300 hover:border-blue-500 transition cursor-pointer">
                                                </a>
                                            <?php else: ?>
                                                <span class="text-gray-400 text-sm">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                            <?php echo e($lot->user->name ?? 'N/A'); ?>

                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                                            <?php if($lot->statut === 'actif'): ?>
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                                    ✓ Actif
                                                </span>
                                            <?php else: ?>
                                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">
                                                    Clôturé
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <p class="text-gray-500 text-center py-4">Aucun lot créé aujourd'hui</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                
                <div class="mb-6">
                    <a href="<?php echo e(route('usage-quotidien.index')); ?>"
                       class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Retour aux catégories
                    </a>
                </div>

                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-900"><?php echo e($familleSelectionnee); ?></h3>
                        <p class="text-sm text-gray-600 mt-1"><?php echo e($produits->count()); ?> produit(s)</p>
                    </div>
                </div>

                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        
                        <div class="mb-6">
                            <input type="text"
                                   id="searchProduct"
                                   placeholder="🔍 Rechercher un produit..."
                                   class="w-full px-4 py-3 text-lg border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div id="produitsContainer" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                            <?php $__empty_1 = true; $__currentLoopData = $produits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <a href="<?php echo e(route('usage-quotidien.show-changer', $produit)); ?>"
                                   data-product-name="<?php echo e(strtolower($produit->nom)); ?>"
                                   class="produit-card relative block p-6 bg-white border-2 border-gray-300 rounded-lg hover:border-blue-500 hover:shadow-lg transition-all duration-200 text-center group">

                                    
                                    <div class="text-base font-semibold text-gray-900 group-hover:text-blue-600">
                                        <?php echo e($produit->nom); ?>

                                    </div>

                                    
                                    <?php if($produit->lotActif): ?>
                                        <div class="mt-2 inline-flex items-center px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                            ✓ Lot actif
                                        </div>
                                    <?php else: ?>
                                        <div class="mt-2 inline-flex items-center px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">
                                            ⚠️ Pas de lot
                                        </div>
                                    <?php endif; ?>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div id="noResults" class="col-span-full text-center text-gray-500 py-8">
                                    Aucun produit trouvé dans cette catégorie.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">📋 Lots créés aujourd'hui (<?php echo e($lotsAujourdhui->count()); ?>)</h3>

                        <?php if($lotsAujourdhui->count() > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Heure</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produit</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">N° Lot</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Photo</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employé</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php $__currentLoopData = $lotsAujourdhui; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                            <?php echo e($lot->started_at->format('H:i')); ?>

                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            <?php echo e($lot->produit->nom ?? 'N/A'); ?>

                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                            <?php echo e($lot->numero_lot ?? $lot->code_interne ?? '-'); ?>

                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <?php if($lot->photo_etiquette): ?>
                                                <a href="<?php echo e(asset('storage/' . $lot->photo_etiquette)); ?>" target="_blank">
                                                    <img src="<?php echo e(asset('storage/' . $lot->photo_etiquette)); ?>"
                                                         alt="Photo"
                                                         class="h-16 w-16 object-cover rounded border-2 border-gray-300 hover:border-blue-500 transition cursor-pointer">
                                                </a>
                                            <?php elseif($lot->photo_path): ?>
                                                <a href="<?php echo e(asset('storage/' . $lot->photo_path)); ?>" target="_blank">
                                                    <img src="<?php echo e(asset('storage/' . $lot->photo_path)); ?>"
                                                         alt="Photo"
                                                         class="h-16 w-16 object-cover rounded border-2 border-gray-300 hover:border-blue-500 transition cursor-pointer">
                                                </a>
                                            <?php else: ?>
                                                <span class="text-gray-400 text-sm">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                            <?php echo e($lot->user->name ?? 'N/A'); ?>

                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                                            <?php if($lot->statut === 'actif'): ?>
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                                    ✓ Actif
                                                </span>
                                            <?php else: ?>
                                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">
                                                    Clôturé
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <p class="text-gray-500 text-center py-4">Aucun lot créé aujourd'hui</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <?php if($familleSelectionnee): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchProduct');
            const produitsContainer = document.getElementById('produitsContainer');
            const produitCards = document.querySelectorAll('.produit-card');
            const noResults = document.getElementById('noResults');

            // Auto-focus sur le champ de recherche
            searchInput.focus();

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                let visibleCount = 0;

                produitCards.forEach(function(card) {
                    const productName = card.getAttribute('data-product-name');

                    if (productName.includes(searchTerm)) {
                        card.style.display = '';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Afficher/masquer le message "Aucun résultat"
                if (visibleCount === 0 && searchTerm !== '') {
                    noResults.textContent = 'Aucun produit trouvé pour "' + searchTerm + '"';
                    noResults.style.display = 'block';
                } else if (visibleCount === 0) {
                    noResults.textContent = 'Aucun produit trouvé dans cette catégorie.';
                    noResults.style.display = 'block';
                } else {
                    noResults.style.display = 'none';
                }
            });
        });
    </script>
    <?php endif; ?>
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
<?php /**PATH C:\laragon\www\haccp.grolleau\haccp-app\resources\views\usage-quotidien\index.blade.php ENDPATH**/ ?>