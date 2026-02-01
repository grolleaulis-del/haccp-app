<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🔥 Cuisson / Refroidissement
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('cuisson-refroidissement.store') }}" method="POST" id="cuissonForm">
                @csrf
                <input type="hidden" name="produit_id" id="produitId">
                <input type="hidden" name="photo" id="photoData">

                {{-- Étape 1: Photo --}}
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

                {{-- Étape 2: Sélection produit --}}
                <div id="productStep" class="hidden mb-6 bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">🥘 2. Sélectionner le produit</h3>

                    {{-- Barre de recherche --}}
                    <input type="text" id="searchProduct" placeholder="🔍 Rechercher..."
                           class="w-full px-4 py-3 text-lg border-2 border-gray-300 rounded-lg focus:border-orange-500 mb-4">

                    <div id="produitsContainer">
                        @foreach($produits as $famille => $produitsGroupe)
                            <div class="mb-6 famille-section">
                                <h4 class="text-lg font-bold text-gray-700 mb-3 border-b-2 border-orange-500 pb-2">
                                    {{ $famille }}
                                </h4>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    @foreach($produitsGroupe as $produit)
                                        <button type="button"
                                                data-product-id="{{ $produit->id }}"
                                                data-product-name="{{ strtolower($produit->nom) }}"
                                                data-product-dlc="{{ $produit->dlc_cuisson_defaut_jours ?? 3 }}"
                                                class="produit-btn p-4 bg-white border-2 border-gray-200 rounded-xl hover:border-orange-500 hover:shadow-lg transition-all text-left">
                                            <div class="text-3xl mb-2">🍳</div>
                                            <div class="font-bold text-gray-900">{{ $produit->nom }}</div>
                                            @if($produit->dlc_cuisson_defaut_jours)
                                                <div class="text-xs text-gray-600 mt-1">
                                                    📅 DLC: {{ $produit->dlc_cuisson_defaut_jours }} jours
                                                </div>
                                            @endif
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Étape 3: Formulaire DLC + Étiquettes --}}
                <div id="formStep" class="hidden mb-6 bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">📋 3. Validation</h3>

                    <div class="bg-orange-50 rounded-lg p-4 mb-6">
                        <p class="text-lg"><span class="font-bold">Produit:</span> <span id="selectedProduct"></span></p>
                    </div>

                    <div class="space-y-6">
                        {{-- DLC --}}
                        <div>
                            <label class="block text-lg font-bold text-gray-900 mb-2">
                                📅 DLC (nombre de jours)
                            </label>
                            <input type="number" name="dlc_jours" id="dlcJours" min="1" required
                                   class="w-full text-3xl p-6 border-4 border-orange-300 rounded-xl focus:border-orange-500 font-bold text-center">
                            <p class="text-sm text-gray-600 mt-2 text-center">Modifiez si nécessaire</p>
                        </div>

                        {{-- Nombre d'étiquettes --}}
                        <div>
                            <label class="block text-lg font-bold text-gray-900 mb-2">
                                🏷️ Nombre d'étiquettes à imprimer
                            </label>
                            <input type="number" name="nombre_etiquettes" min="1" max="20" value="1" required
                                   class="w-full text-3xl p-6 border-4 border-blue-300 rounded-xl focus:border-blue-500 font-bold text-center">
                            <p class="text-sm text-gray-600 mt-2 text-center">Nombre de contenants</p>
                        </div>

                        {{-- Quantité cachée --}}
                        <input type="hidden" name="quantite" value="1">

                        {{-- Boutons --}}
                        <div class="flex gap-4">
                            <a href="{{ route('dashboard') }}"
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

    @push('scripts')
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
    @endpush
</x-app-layout>
