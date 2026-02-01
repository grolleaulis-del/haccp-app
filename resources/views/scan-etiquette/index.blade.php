<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Scanner une étiquette') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-black text-white flex items-start justify-center">
        <div class="w-full max-w-3xl px-4 pt-2">
            <form action="{{ route('scan-etiquette.select-produit') }}" method="POST" id="scanForm" class="space-y-4">
                @csrf
                <input type="hidden" name="photo" id="photoInput">
                <input type="hidden" name="skip_photo" id="skipPhotoInput" value="0">

                {{-- Caméra plein écran --}}
                <div class="bg-gray-900 rounded-xl border border-gray-700 p-2">
                    <x-camera-capture
                        name="photo_capture"
                        label="Prendre la photo maintenant"
                        :required="false"
                        autostart="true"
                    />
                </div>

                {{-- Bouton ignorer --}}
                <button type="button"
                        id="skipBtn"
                        onclick="skipPhoto()"
                        class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-4 rounded-lg transition-all duration-150 text-lg">
                    Ignorer la photo, il y a un produit
                </button>
            </form>


        </div>
    </div>

    <script>
        function skipPhoto() {
            document.getElementById('skipPhotoInput').value = '1';
            document.getElementById('photoInput').value = '';
            document.getElementById('scanForm').submit();
        }

        // Soumission auto dès qu'une photo est capturée
        window.addEventListener('photo-captured', function(event) {
            const form = document.getElementById('scanForm');
            const skip = document.getElementById('skipPhotoInput');
            const photo = document.getElementById('photoInput');
            if (!form || !skip || !photo) return;
            skip.value = '0';
            if (event.detail && event.detail.data) {
                photo.value = event.detail.data;
            }
            form.submit();
        });

        // Auto-démarrer la caméra et masquer le bouton
        window.addEventListener('DOMContentLoaded', function() {
            const hideAndStart = () => {
                const cameraBtn = document.querySelector('[data-camera-btn]');
                if (cameraBtn) {
                    cameraBtn.style.display = 'none';
                    if (!cameraBtn.disabled) {
                        cameraBtn.click();
                        return true;
                    }
                }
                return false;
            };

            // Essayer plusieurs fois au cas où le composant se monte lentement
            const attempts = [150, 400, 800];
            attempts.forEach(delay => setTimeout(hideAndStart, delay));
        });
    </script>
</x-app-layout>
