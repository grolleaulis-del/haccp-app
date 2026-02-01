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
            🔥 Cuisson / Refroidissement
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            
            <div id="photoStep" class="mb-6 bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">📸 1. Photo de l'étiquette</h3>
                
                <div id="cameraSection">
                    <video id="video" class="w-full rounded-lg border-4 border-gray-300 mb-4" autoplay playsinline></video>
                    <button type="button" id="captureBtn"
                            class="w-full py-6 bg-orange-600 text-white text-xl font-bold rounded-xl hover:bg-orange-700 shadow-lg">
                        📷 Prendre la photo
                    </button>
                </div>

                <div id="photoPreview" class="hidden">
                    <img id="capturedImage" class="w-full rounded-lg border-4 border-green-500 mb-4">
                    <button type="button" id="retakeBtn"
                            class="w-full py-4 bg-gray-600 text-white text-lg font-bold rounded-xl hover:bg-gray-700">
                        🔄 Reprendre la photo
                    </button>
                </div>

                <canvas id="canvas" class="hidden"></canvas>
            </div>

            
            <div id="productStep" class="hidden mb-6 bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">🥘 2. Sélectionner le produit</h3>

            <div class="mb-6 flex flex-col sm:flex-row gap-4 justify-between items-center">
                <h3 class="text-2xl font-bold text-gray-900">Sélectionnez un produit à cuire</h3>
                <div class="flex gap-2 w-full sm:w-auto">
                    
                    <input type="text"
                           id="searchProduct"
                           placeholder="🔍 Rechercher un produit..."
                           class="flex-1 sm:w-64 px-4 py-2 text-lg border-2 border-gray-300 rounded-lg focus:border-orange-500 focus:ring focus:ring-orange-200"
                           autocomplete="off">
                    <a href="<?php echo e(route('cuisson-refroidissement.historique')); ?>"
                       class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 whitespace-nowrap">
                        📋 Historique
                    </a>
                </div>
            </div>

            <div id="produitsContainer">
            <?php $__currentLoopData = $produits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $famille => $produitsGroupe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="mb-8 famille-section">
                    <h4 class="text-xl font-bold text-gray-700 mb-4 border-b-2 border-orange-500 pb-2">
                        <?php echo e($famille); ?>

                    </h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <?php $__currentLoopData = $produitsGroupe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('cuisson-refroidissement.create', $produit)); ?>"
                               data-product-name="<?php echo e(strtolower($produit->nom)); ?>"
                               class="produit-card block p-6 bg-white border-2 border-gray-200 rounded-xl hover:border-orange-500 hover:shadow-lg transition-all duration-200">
                                <div class="text-center">
                                    <div class="text-4xl mb-3">🍳</div>
                                    <h5 class="font-bold text-gray-900 mb-2"><?php echo e($produit->nom); ?></h5>
                                    <?php if($produit->dlc_cuisson_defaut_jours): ?>
                                        <div class="text-sm text-gray-600">
                                            <span class="inline-flex items-center px-2 py-1 bg-orange-100 text-orange-800 rounded-full">
                                                📅 DLC: <?php echo e($produit->dlc_cuisson_defaut_jours); ?> jours
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div id="noResults" class="hidden text-center py-12 bg-gray-50 rounded-lg">
                <p class="text-gray-500 text-lg">Aucun produit trouvé</p>
            </div>

            <?php if($produits->isEmpty()): ?>
                <div class="text-center py-12 bg-gray-50 rounded-lg">
                    <p class="text-gray-500 text-lg">Aucun produit disponible</p>
                    <a href="<?php echo e(route('produits.create')); ?>" class="mt-4 inline-block text-orange-600 hover:text-orange-700">
                        Ajouter un produit
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        const searchInput = document.getElementById('searchProduct');
        const produitsContainer = document.getElementById('produitsContainer');
        const noResults = document.getElementById('noResults');
        const produitCards = document.querySelectorAll('.produit-card');
        const familleSections = document.querySelectorAll('.famille-section');

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            let hasVisibleProducts = false;

            if (searchTerm === '') {
                // Réafficher tout
                produitCards.forEach(card => card.style.display = '');
                familleSections.forEach(section => section.style.display = '');
                noResults.classList.add('hidden');
                produitsContainer.style.display = '';
                return;
            }

            // Filtrer les produits
            familleSections.forEach(section => {
                let sectionHasVisible = false;
                const cardsInSection = section.querySelectorAll('.produit-card');

                cardsInSection.forEach(card => {
                    const productName = card.getAttribute('data-product-name');
                    if (productName.includes(searchTerm)) {
                        card.style.display = '';
                        sectionHasVisible = true;
                        hasVisibleProducts = true;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Masquer la section si aucun produit visible
                section.style.display = sectionHasVisible ? '' : 'none';
            });

            // Afficher message si aucun résultat
            if (!hasVisibleProducts) {
                produitsContainer.style.display = 'none';
                noResults.classList.remove('hidden');
            } else {
                produitsContainer.style.display = '';
                noResults.classList.add('hidden');
            }
        });

        // Focus automatique sur le champ de recherche
        searchInput.focus();
    </script>
    <?php $__env->stopPush(); ?>
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
<?php /**PATH C:\laragon\www\haccp.grolleau\haccp-app\resources\views\cuisson-refroidissement\index-temp.blade.php ENDPATH**/ ?>