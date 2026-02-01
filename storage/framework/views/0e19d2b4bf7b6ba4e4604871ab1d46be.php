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

            <form action="<?php echo e(route('cuisson-refroidissement.store')); ?>" method="POST" id="cuissonForm">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="produit_id" id="produitId">
                <input type="hidden" name="photo" id="photoData">

                
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

                    
                    <input type="text" id="searchProduct" placeholder="🔍 Rechercher..."
                           class="w-full px-4 py-3 text-lg border-2 border-gray-300 rounded-lg focus:border-orange-500 mb-4">

                    <div id="produitsContainer">
                        <?php $__currentLoopData = $produits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $famille => $produitsGroupe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="mb-6 famille-section">
                                <h4 class="text-lg font-bold text-gray-700 mb-3 border-b-2 border-orange-500 pb-2">
                                    <?php echo e($famille); ?>

                                </h4>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    <?php $__currentLoopData = $produitsGroupe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <button type="button"
                                                data-product-id="<?php echo e($produit->id); ?>"
                                                data-product-name="<?php echo e(strtolower($produit->nom)); ?>"
                                                data-product-dlc="<?php echo e($produit->dlc_cuisson_defaut_jours ?? 3); ?>"
                                                class="produit-btn p-4 bg-white border-2 border-gray-200 rounded-xl hover:border-orange-500 hover:shadow-lg transition-all text-left">
                                            <div class="text-3xl mb-2">🍳</div>
                                            <div class="font-bold text-gray-900"><?php echo e($produit->nom); ?></div>
                                            <?php if($produit->dlc_cuisson_defaut_jours): ?>
                                                <div class="text-xs text-gray-600 mt-1">
                                                    📅 DLC: <?php echo e($produit->dlc_cuisson_defaut_jours); ?> jours
                                                </div>
                                            <?php endif; ?>
                                        </button>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                
                <div id="formStep" class="hidden mb-6 bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">📋 3. Validation</h3>

                    <div class="bg-orange-50 rounded-lg p-4 mb-6">
                        <p class="text-lg"><span class="font-bold">Produit:</span> <span id="selectedProduct"></span></p>
                    </div>

                    <div class="space-y-6">
                        
                        <div>
                            <label class="block text-lg font-bold text-gray-900 mb-2">
                                📅 DLC (nombre de jours)
                            </label>
                            <input type="number" name="dlc_jours" id="dlcJours" min="1" required
                                   class="w-full text-3xl p-6 border-4 border-orange-300 rounded-xl focus:border-orange-500 font-bold text-center">
                            <p class="text-sm text-gray-600 mt-2 text-center">Modifiez si nécessaire</p>
                        </div>

                        
                        <div>
                            <label class="block text-lg font-bold text-gray-900 mb-2">
                                🏷️ Nombre d'étiquettes à imprimer
                            </label>
                            <input type="number" name="nombre_etiquettes" min="1" max="20" value="1" required
                                   class="w-full text-3xl p-6 border-4 border-blue-300 rounded-xl focus:border-blue-500 font-bold text-center">
                            <p class="text-sm text-gray-600 mt-2 text-center">Nombre de contenants</p>
                        </div>

                        
                        <input type="hidden" name="quantite" value="1">

                        
                        <div class="flex gap-4">
                            <a href="<?php echo e(route('dashboard')); ?>"
                               class="flex-1 py-6 bg-gray-500 text-white text-xl font-bold rounded-xl hover:bg-gray-600 text-center">
                                ← Annuler
                            </a>
                            <button type="submit"
                                    class="flex-1 py-6 bg-green-600 text-white text-xl font-bold rounded-xl hover:bg-green-700">
                                ✓ Valider et imprimer
                            </button>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const captureBtn = document.getElementById('captureBtn');
        const retakeBtn = document.getElementById('retakeBtn');
        const photoPreview = document.getElementById('photoPreview');
        const cameraSection = document.getElementById('cameraSection');
        const capturedImage = document.getElementById('capturedImage');
        const photoDataInput = document.getElementById('photoData');
        const photoStep = document.getElementById('photoStep');
        const productStep = document.getElementById('productStep');
        const formStep = document.getElementById('formStep');
        const produitId = document.getElementById('produitId');
        const selectedProduct = document.getElementById('selectedProduct');
        const dlcJours = document.getElementById('dlcJours');

        // Démarrer la caméra
        navigator.mediaDevices.getUserMedia({
            video: { facingMode: 'environment', width: 1920, height: 1080 }
        })
        .then(stream => {
            video.srcObject = stream;
        })
        .catch(err => {
            alert('Erreur d\'accès à la caméra: ' + err.message);
        });

        // Capturer la photo
        captureBtn.addEventListener('click', () => {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0);

            const dataUrl = canvas.toDataURL('image/jpeg', 0.8);
            photoDataInput.value = dataUrl;
            capturedImage.src = dataUrl;

            // Arrêter la caméra
            const stream = video.srcObject;
            const tracks = stream.getTracks();
            tracks.forEach(track => track.stop());

            // Passer à l'étape suivante
            cameraSection.classList.add('hidden');
            photoPreview.classList.remove('hidden');
            productStep.classList.remove('hidden');
        });

        // Reprendre la photo
        retakeBtn.addEventListener('click', () => {
            photoPreview.classList.add('hidden');
            cameraSection.classList.remove('hidden');
            productStep.classList.add('hidden');
            formStep.classList.add('hidden');

            // Redémarrer la caméra
            navigator.mediaDevices.getUserMedia({
                video: { facingMode: 'environment', width: 1920, height: 1080 }
            })
            .then(stream => {
                video.srcObject = stream;
            });
        });

        // Sélection du produit
        document.querySelectorAll('.produit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.productId;
                const name = this.textContent.trim().split('\n')[1].trim();
                const dlc = this.dataset.productDlc;

                produitId.value = id;
                selectedProduct.textContent = name;
                dlcJours.value = dlc;

                formStep.classList.remove('hidden');
                formStep.scrollIntoView({ behavior: 'smooth' });
            });
        });

        // Recherche produit
        const searchInput = document.getElementById('searchProduct');
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const produitBtns = document.querySelectorAll('.produit-btn');

            produitBtns.forEach(btn => {
                const productName = btn.dataset.productName;
                btn.style.display = productName.includes(searchTerm) ? '' : 'none';
            });

            // Gérer les sections vides
            document.querySelectorAll('.famille-section').forEach(section => {
                const visibleBtns = Array.from(section.querySelectorAll('.produit-btn'))
                    .filter(btn => btn.style.display !== 'none');
                section.style.display = visibleBtns.length > 0 ? '' : 'none';
            });
        });
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
<?php /**PATH C:\laragon\www\haccp.grolleau\haccp-app\resources\views\cuisson-refroidissement\index-new.blade.php ENDPATH**/ ?>