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
            <?php echo e(__('Cuisson / Refroidissement')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="min-h-screen bg-black text-white flex items-start justify-center">
        <div class="w-full max-w-3xl px-4 pt-2">
            <form action="<?php echo e(route('cuisson-refroidissement.select-produit')); ?>" method="POST" id="scanForm" class="space-y-4">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="photo" id="photoInput">

                
                <div class="bg-gray-900 rounded-xl border border-gray-700 p-2">
                    <?php if (isset($component)) { $__componentOriginal071b46241508c66a1c84114f4aaa7e25 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal071b46241508c66a1c84114f4aaa7e25 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.camera-capture','data' => ['name' => 'photo_capture','label' => 'Prendre la photo maintenant','required' => true,'autostart' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('camera-capture'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'photo_capture','label' => 'Prendre la photo maintenant','required' => true,'autostart' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal071b46241508c66a1c84114f4aaa7e25)): ?>
<?php $attributes = $__attributesOriginal071b46241508c66a1c84114f4aaa7e25; ?>
<?php unset($__attributesOriginal071b46241508c66a1c84114f4aaa7e25); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal071b46241508c66a1c84114f4aaa7e25)): ?>
<?php $component = $__componentOriginal071b46241508c66a1c84114f4aaa7e25; ?>
<?php unset($__componentOriginal071b46241508c66a1c84114f4aaa7e25); ?>
<?php endif; ?>
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
<?php /**PATH C:\laragon\www\haccp.grolleau\haccp-app\resources\views\cuisson-refroidissement\index.blade.php ENDPATH**/ ?>