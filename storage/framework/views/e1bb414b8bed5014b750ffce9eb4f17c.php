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
            📋 Historique des cuissons
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 flex justify-between items-center">
                <h3 class="text-2xl font-bold text-gray-900">Historique</h3>
                <a href="<?php echo e(route('cuisson-refroidissement.index')); ?>"
                   class="inline-flex items-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                    ← Retour
                </a>
            </div>

            
            <div class="mb-6 bg-white rounded-lg shadow p-4">
                <form method="GET" class="flex gap-4 items-end">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Filtrer par date</label>
                        <input type="date" name="date" value="<?php echo e(request('date')); ?>"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring focus:ring-orange-200">
                    </div>
                    <button type="submit" class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                        Filtrer
                    </button>
                    <?php if(request('date')): ?>
                        <a href="<?php echo e(route('cuisson-refroidissement.historique')); ?>"
                           class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                            Réinitialiser
                        </a>
                    <?php endif; ?>
                </form>
            </div>

            
            <?php if($lots->count() > 0): ?>
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <label class="flex items-center">
                                <input type="checkbox" id="selectAll"
                                       class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                <span class="ml-2 text-sm font-medium text-gray-700">Tout sélectionner</span>
                            </label>
                            <span id="selectedCount" class="text-sm text-gray-600">0 lot(s) sélectionné(s)</span>
                        </div>
                        <button type="button" id="deleteSelectedBtn"
                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                            🗑️ Supprimer la sélection
                        </button>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase w-12">
                                    <span class="sr-only">Sélectionner</span>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantité</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">DLC</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Temp. Cuisson</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Temp. Refroid.</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employé</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Photo</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__currentLoopData = $lots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <input type="checkbox" name="lots[]" value="<?php echo e($lot->id); ?>"
                                               class="lot-checkbox rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <?php echo e($lot->date_production->format('d/m/Y H:i')); ?>

                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        <?php echo e($lot->produit->nom); ?>

                                        <div class="text-xs text-gray-500"><?php echo e($lot->produit->famille); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <?php echo e($lot->quantite); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <?php echo e($lot->dlc->format('d/m/Y')); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <?php if($lot->temperature_cuisson): ?>
                                            <span class="text-red-600 font-semibold"><?php echo e($lot->temperature_cuisson); ?>°C</span>
                                        <?php else: ?>
                                            <span class="text-gray-400">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <?php if($lot->temperature_refroidissement): ?>
                                            <span class="text-blue-600 font-semibold"><?php echo e($lot->temperature_refroidissement); ?>°C</span>
                                        <?php else: ?>
                                            <span class="text-gray-400">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo e($lot->user->name); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <?php if($lot->photo_etiquette): ?>
                                            <a href="<?php echo e(asset('storage/' . $lot->photo_etiquette)); ?>"
                                               target="_blank"
                                               class="text-orange-600 hover:text-orange-800">
                                                📷 Voir
                                            </a>
                                        <?php else: ?>
                                            <span class="text-gray-400">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <?php echo e($lots->links()); ?>

                </div>
            <?php else: ?>
                <div class="bg-white rounded-lg shadow p-12 text-center">
                    <div class="text-6xl mb-4">📋</div>
                    <p class="text-gray-500 text-lg">Aucune cuisson enregistrée</p>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <?php if($lots->count() > 0): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const lotCheckboxes = document.querySelectorAll('.lot-checkbox');
            const deleteBtn = document.getElementById('deleteSelectedBtn');
            const selectedCountSpan = document.getElementById('selectedCount');

            // Fonction pour mettre à jour le compteur et l'état du bouton
            function updateSelectedCount() {
                const checkedCount = document.querySelectorAll('.lot-checkbox:checked').length;
                selectedCountSpan.textContent = `${checkedCount} lot(s) sélectionné(s)`;
                deleteBtn.disabled = checkedCount === 0;

                // Mettre à jour l'état de "Tout sélectionner"
                selectAllCheckbox.checked = checkedCount === lotCheckboxes.length && checkedCount > 0;
                selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < lotCheckboxes.length;
            }

            // Tout sélectionner / Tout désélectionner
            selectAllCheckbox.addEventListener('change', function() {
                lotCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateSelectedCount();
            });

            // Gérer le changement de chaque case à cocher
            lotCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedCount);
            });

            // Gérer la suppression multiple
            deleteBtn.addEventListener('click', function() {
                const checkedBoxes = document.querySelectorAll('.lot-checkbox:checked');

                if (checkedBoxes.length === 0) {
                    return;
                }

                if (!confirm('Êtes-vous sûr de vouloir supprimer les lots sélectionnés ?')) {
                    return;
                }

                // Créer un formulaire dynamique
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '<?php echo e(route('cuisson-refroidissement.destroy.multiple')); ?>';

                // Ajouter le token CSRF
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '<?php echo e(csrf_token()); ?>';
                form.appendChild(csrfInput);

                // Ajouter les IDs des lots sélectionnés
                checkedBoxes.forEach(checkbox => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'lots[]';
                    input.value = checkbox.value;
                    form.appendChild(input);
                });

                // Soumettre le formulaire
                document.body.appendChild(form);
                form.submit();
            });

            // Initialiser le compteur
            updateSelectedCount();
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
<?php /**PATH C:\laragon\www\haccp.grolleau\haccp-app\resources\views\cuisson-refroidissement\historique.blade.php ENDPATH**/ ?>