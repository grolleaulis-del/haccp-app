@props(['name' => 'photo', 'label' => 'Photo', 'required' => false, 'autostart' => false])

<div x-data="cameraCapture({ autostart: {{ $autostart ? 'true' : 'false' }} })" class="space-y-4">
    {{-- Label avec bouton capture Ã  cÃ´tÃ© (en haut) --}}
    <div class="flex items-center gap-4 mb-4">
        <label class="text-sm font-medium text-gray-700">
            {{ $label }} @if($required)<span class="text-red-600">*</span>@endif
        </label>
        <button type="button"
                @click="startWebcam()"
                x-show="!showWebcam && !capturedImage"
                class="hidden sm:flex w-24 h-24 bg-green-600 text-white rounded-lg hover:bg-green-700 items-center justify-center text-sm font-semibold flex-shrink-0">
            Photo
        </button>
    </div>

    {{-- Flux vidÃ©o + bouton capture cÃ´te Ã  cÃ´te --}}
    <div x-show="showWebcam" class="relative flex gap-3 items-stretch">
        <button type="button"
                @click="captureFromWebcam()"
                class="w-32 h-32 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center justify-center text-lg font-semibold flex-shrink-0">
            Photo
        </button>
        <video x-ref="video" autoplay playsinline class="flex-1 rounded-lg border-2 border-blue-500"></video>
    </div>

    {{-- Bouton Annuler en bas --}}
    <div x-show="showWebcam" class="mt-2">
        <button type="button"
                @click="stopWebcam()"
                class="w-full px-4 py-3 text-lg bg-gray-600 text-white rounded-lg hover:bg-gray-700">
            Annuler
        </button>
    </div>

    {{-- PrÃ©visualisation de la photo capturÃ©e --}}
    <div x-show="capturedImage" class="mb-4">
        <img :src="capturedImage" alt="Photo capturÃ©e" class="max-w-full h-auto rounded-lg border-2 border-green-500">
        <input type="hidden" :name="'{{ $name }}'" :value="capturedImage">
        <button type="button" @click="resetCapture()"
                class="mt-2 px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700">
            âŒ Supprimer et reprendre
        </button>
    </div>

    {{-- Boutons de capture mobile --}}
    <div x-show="!capturedImage" class="space-y-3">
        {{-- Mobile : Utiliser l'appareil photo (PRIORITAIRE) --}}
        <div class="block sm:hidden">
            <input type="file"
                   accept="image/*"
                   capture="environment"
                   @change="handleFileSelect($event)"
                   class="sr-only"
                   x-ref="mobileInput">
            <button type="button"
                    @click="$refs.mobileInput.click()"
                    class="w-full px-4 py-3 bg-blue-600 text-white text-lg font-bold rounded-lg hover:bg-blue-700 flex items-center justify-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Photo Prendre une photo
            </button>
            <p class="text-xs text-gray-500 text-center mt-2">RecommandÃ© pour iPhone/Android</p>
        </div>

        {{-- Desktop : Utiliser la webcam --}}
        <div class="hidden sm:block space-y-3">
            <button type="button"
                    @click="startWebcam()"
                    x-show="!showWebcam && !capturedImage"
                    class="w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Photo Utiliser la webcam
            </button>

            {{-- Upload fichier sur desktop --}}
            <label x-show="!showWebcam && !capturedImage" class="w-full px-4 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 text-center cursor-pointer block">
                ðŸ“ Choisir un fichier
                <input type="file"
                       accept="image/*"
                       @change="handleFileSelect($event)"
                       class="sr-only">
            </label>
        </div>
    </div>

    {{-- Canvas cachÃ© pour la capture --}}
    <canvas x-ref="canvas" class="hidden"></canvas>
</div>

<script>
function cameraCapture(options = {}) {
    return {
        autostart: options.autostart || false,
        capturedImage: null,
        showWebcam: false,
        stream: null,

        async startWebcam() {
            try {
                // VÃ©rifier que navigator.mediaDevices existe
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    alert('Votre navigateur ne supporte pas l\'accÃ¨s Ã  la camÃ©ra. Utilisez la fonction de fichier ou un navigateur plus rÃ©cent.');
                    return;
                }

                if (!window.isSecureContext) {
                    alert("Camera indisponible en HTTP. Utilisez \"Prendre une photo\" ou passez en HTTPS.");
                    return;
                }

                // Essayer d'abord facingMode environment (tÃ©lÃ©phone)
                try {
                    this.stream = await navigator.mediaDevices.getUserMedia({
                        video: { 
                            facingMode: { ideal: 'environment' }
                        },
                        audio: false
                    });
                } catch (e) {
                    // Si environment Ã©choue, essayer sans prÃ©fÃ©rences
                    this.stream = await navigator.mediaDevices.getUserMedia({
                        video: true,
                        audio: false
                    });
                }

                this.$refs.video.srcObject = this.stream;
                // Attendre que le flux soit prÃªt
                await new Promise((resolve) => {
                    this.$refs.video.onloadedmetadata = resolve;
                });
                this.showWebcam = true;
            } catch (error) {
                console.error('Erreur camÃ©ra:', error);
                alert('Impossible d\'accÃ©der Ã  la camÃ©ra.\n\nSur iPhone: Allez dans ParamÃ¨tres > ConfidentialitÃ© > CamÃ©ra et activez l\'accÃ¨s.\n\nErreur: ' + error.message);
            }
        },

        stopWebcam() {
            if (this.stream) {
                this.stream.getTracks().forEach(track => track.stop());
                this.stream = null;
            }
            this.showWebcam = false;
        },

        captureFromWebcam() {
            const video = this.$refs.video;
            const canvas = this.$refs.canvas;
            
            if (!video || !video.videoWidth) {
                alert('La camÃ©ra n\'est pas prÃªte, veuillez attendre quelques secondes');
                return;
            }

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0);

            this.capturedImage = canvas.toDataURL('image/jpeg', 0.8);
            this.$dispatch('photo-captured', { data: this.capturedImage });
            this.stopWebcam();
        },

        handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.capturedImage = e.target.result;
                    this.$dispatch('photo-captured', { data: this.capturedImage });
                };
                reader.readAsDataURL(file);
            }
        },

        resetCapture() {
            this.capturedImage = null;
            this.stopWebcam();
        },

        init() {
            if (this.autostart) {
                // tenter au montage, puis retenter aprÃ¨s un court dÃ©lai si nÃ©cessaire
                const tryStart = () => this.startWebcam().catch(() => {});
                tryStart();
                setTimeout(tryStart, 300);
                setTimeout(tryStart, 800);
            }
        }
    }
}
</script>

