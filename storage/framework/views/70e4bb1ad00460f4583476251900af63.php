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
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <?php echo e(__('Historique des Lots')); ?>

            </h2>
            <a href="<?php echo e(route('usage-quotidien.index')); ?>"
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                ← Retour à l'usage quotidien
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Filtres</h3>
                    <form method="GET" action="<?php echo e(route('usage-quotidien.historique')); ?>" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                        
                        <div>
                            <label for="famille" class="block text-sm font-medium text-gray-700 mb-1">
                                Catégorie
                            </label>
                            <select name="famille" id="famille" class="w-full rounded-md border-gray-300">
                                <option value="">Toutes les catégories</option>
                                <?php $__currentLoopData = $familles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $famille): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($famille); ?>" <?php echo e(request('famille') === $famille ? 'selected' : ''); ?>>
                                        <?php echo e($famille); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        
                        <div>
                            <label for="produit_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Produit
                            </label>
                            <select name="produit_id" id="produit_id" class="w-full rounded-md border-gray-300">
                                <option value="">Tous les produits</option>
                                <?php $__currentLoopData = $produits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($produit->id); ?>" <?php echo e(request('produit_id') == $produit->id ? 'selected' : ''); ?>>
                                        <?php echo e($produit->nom); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        
                        <div>
                            <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-1">
                                Date début
                            </label>
                            <input type="date" name="date_debut" id="date_debut"
                                   value="<?php echo e(request('date_debut')); ?>"
                                   class="w-full rounded-md border-gray-300">
                        </div>

                        
                        <div>
                            <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-1">
                                Date fin
                            </label>
                            <input type="date" name="date_fin" id="date_fin"
                                   value="<?php echo e(request('date_fin')); ?>"
                                   class="w-full rounded-md border-gray-300">
                        </div>

                        
                        <div class="md:col-span-2 lg:col-span-4 flex gap-3 justify-end">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Rechercher
                            </button>
                            <?php if(request()->hasAny(['famille', 'produit_id', 'date_debut', 'date_fin'])): ?>
                                <a href="<?php echo e(route('usage-quotidien.historique')); ?>"
                                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                    Réinitialiser
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-600">Total des lots clôturés</div>
                    <div class="text-3xl font-bold text-gray-900 mt-1"><?php echo e($lots->total()); ?></div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-600">Aujourd'hui</div>
                    <div class="text-3xl font-bold text-blue-600 mt-1">
                        <?php echo e($lots->where('ended_at', '>=', now()->startOfDay())->count()); ?>

                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-600">Cette semaine</div>
                    <div class="text-3xl font-bold text-green-600 mt-1">
                        <?php echo e($lots->where('ended_at', '>=', now()->startOfWeek())->count()); ?>

                    </div>
                </div>
            </div>

            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <label class="flex items-center">
                            <input type="checkbox" id="selectAll"
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
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

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-12">
                                    <span class="sr-only">Sélectionner</span>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Produit
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Catégorie
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date ouverture
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date clôture
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Durée
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Traça bilité
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Utilisateur
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Commentaire
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__empty_1 = true; $__currentLoopData = $lots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <input type="checkbox" name="lots[]" value="<?php echo e($lot->id); ?>"
                                               class="lot-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900"><?php echo e($lot->produit->nom); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?php echo e($lot->produit->famille); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?php echo e($lot->started_at->format('d/m/Y')); ?></div>
                                        <div class="text-xs text-gray-500"><?php echo e($lot->started_at->format('H:i')); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?php echo e($lot->ended_at->format('d/m/Y')); ?></div>
                                        <div class="text-xs text-gray-500"><?php echo e($lot->ended_at->format('H:i')); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <?php
                                                $duree = $lot->started_at->diffInDays($lot->ended_at);
                                                $heures = $lot->started_at->diffInHours($lot->ended_at) % 24;
                                            ?>
                                            <?php if($duree > 0): ?>
                                                <?php echo e($duree); ?>j
                                                <?php if($heures > 0): ?>
                                                    <?php echo e($heures); ?>h
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <?php echo e($heures); ?>h
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if($lot->code_interne): ?>
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                Code: <?php echo e($lot->code_interne); ?>

                                            </span>
                                        <?php elseif($lot->photo_path): ?>
                                            <a href="<?php echo e(asset('storage/' . $lot->photo_path)); ?>" target="_blank"
                                               class="text-blue-600 hover:text-blue-900 text-sm">
                                                📷 Voir photo
                                            </a>
                                        <?php elseif($lot->photo_etiquette): ?>
                                            <a href="<?php echo e(asset('storage/' . $lot->photo_etiquette)); ?>" target="_blank"
                                               class="text-blue-600 hover:text-blue-900 text-sm">
                                                📷 Voir photo
                                            </a>
                                        <?php else: ?>
                                            <span class="text-xs text-gray-400">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?php echo e($lot->user->name ?? '-'); ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-600 max-w-xs truncate"
                                             title="<?php echo e($lot->commentaire); ?>">
                                            <?php echo e($lot->commentaire ?: '-'); ?>

                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                        Aucun lot clôturé trouvé.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            
            <div class="mt-4">
                <?php echo e($lots->withQueryString()->links()); ?>

            </div>

        </div>
    </div>

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
                form.action = '<?php echo e(route('lots.destroy.multiple')); ?>';

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
<?php /**PATH C:\laragon\www\haccp.grolleau\haccp-app\resources\views\usage-quotidien\historique.blade.php ENDPATH**/ ?>