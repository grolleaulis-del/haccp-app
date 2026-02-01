<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cuisson / Refroidissement') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-black text-white flex items-start justify-center">
        <div class="w-full max-w-3xl px-4 pt-2">
            <form action="{{ route('cuisson-refroidissement.select-produit') }}" method="POST" id="scanForm" class="space-y-4">
                @csrf
                <input type="hidden" name="photo" id="photoInput">

                {{-- Cam�ra plein �cran --}}
                <div class="bg-gray-900 rounded-xl border border-gray-700 p-2">
                    <x-camera-capture
                        name="photo_capture"
                        label="Prendre la photo maintenant"
                        :required="true"
                        autostart="true"
                    />
                </div>

                <p class="text-sm text-gray-400 text-center">Photo obligatoire pour enregistrer la cuisson/refroidissement.</p>
            </form>
        </div>
    </div>

    <script>
        // Soumission auto d�s qu'une photo est captur�e
        window.addEventListener('photo-captured', function(event) {
            const form = document.getElementById('scanForm');
            const photo = document.getElementById('photoInput');
            if (!form || !photo) return;
            if (event.detail && event.detail.data) {
                photo.value = event.detail.data;
                form.submit();
            }
        });

        // Auto-d�marrer la cam�ra et masquer le bouton
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

            const attempts = [150, 400, 800];
            attempts.forEach(delay => setTimeout(hideAndStart, delay));
        });
    </script>
</x-app-layout>
