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
            <?php echo e(__('Contrôle Arrivages')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Filtres</h3>

                    <form method="GET" action="<?php echo e(route('controle.index')); ?>" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date début</label>
                                <input type="date" name="date_debut" value="<?php echo e($date_debut); ?>"
                                    class="w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date fin</label>
                                <input type="date" name="date_fin" value="<?php echo e($date_fin); ?>"
                                    class="w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Fournisseur</label>
                                <select name="fournisseur_id" class="w-full rounded-md border-gray-300">
                                    <option value="">-- Tous --</option>
                                    <?php $__currentLoopData = $fournisseurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($f->id); ?>"
                                            <?php echo e($fournisseur_id == $f->id ? 'selected' : ''); ?>>
                                            <?php echo e($f->nom); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Type d'opération</label>
                                <select name="type_operation" class="w-full rounded-md border-gray-300">
                                    <option value="">-- Tous --</option>
                                    <option value="usage" <?php echo e($type_operation == 'usage' ? 'selected' : ''); ?>>Usage quotidien</option>
                                    <option value="cuisson" <?php echo e($type_operation == 'cuisson' ? 'selected' : ''); ?>>Cuisson</option>
                                    <option value="congelation" <?php echo e($type_operation == 'congelation' ? 'selected' : ''); ?>>Congélation</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Filtrer
                            </button>
                            <a href="<?php echo e(route('controle.export-pdf', request()->query())); ?>"
                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                📄 Export PDF Global
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="font-semibold text-lg text-gray-900 mb-4">
                        📦 Lots d'utilisation (<?php echo e($lots->total()); ?>)
                    </h3>

                    <?php if($lots->isEmpty()): ?>
                        <p class="text-gray-500 text-center py-8">Aucun lot trouvé</p>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produit</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">N° Lot</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">DLC</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employé</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Photo</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php $__currentLoopData = $lots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <?php echo e($lot->started_at->format('d/m/Y H:i')); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <?php if($lot->type_operation === 'cuisson'): ?>
                                                    <span class="px-2 py-1 bg-orange-100 text-orange-800 rounded-full text-xs font-medium">
                                                        🔥 Cuisson
                                                    </span>
                                                <?php elseif($lot->type_operation === 'congelation'): ?>
                                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                                        ❄️ Congélation
                                                    </span>
                                                <?php else: ?>
                                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                                        ✅ Usage
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                <?php echo e($lot->produit->nom ?? 'N/A'); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <?php echo e($lot->numero_lot ?? '-'); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <?php if($lot->dlc): ?>
                                                    <span class="<?php echo e($lot->dlc < now() ? 'text-red-600 font-bold' : 'text-gray-900'); ?>">
                                                        <?php echo e($lot->dlc->format('d/m/Y')); ?>

                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-gray-400">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <?php echo e($lot->user->name ?? 'N/A'); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <?php if($lot->photo_etiquette): ?>
                                                    <a href="<?php echo e(asset('storage/' . $lot->photo_etiquette)); ?>"
                                                       target="_blank"
                                                       class="block hover:opacity-80">
                                                        <img src="<?php echo e(asset('storage/' . $lot->photo_etiquette)); ?>"
                                                             alt="Photo"
                                                             class="w-16 h-16 object-cover rounded border border-gray-200">
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-gray-400">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <form method="POST" action="<?php echo e(route($lot->type_operation === 'cuisson' ? 'cuisson-refroidissement.destroy' : 'lots.destroy', $lot)); ?>"
                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce lot ?');"
                                                      class="inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit"
                                                            class="text-red-600 hover:text-red-900 font-medium">
                                                        🗑️
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <?php echo e($lots->links()); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="font-semibold text-lg text-gray-900 mb-4">
                        📦 Arrivages (<?php echo e($arrivages->total()); ?>)
                    </h3>

                    <?php if($arrivages->isEmpty()): ?>
                        <p class="text-gray-500 text-center py-8">Aucun arrivage trouvé</p>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Fournisseur</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Lignes</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">BL
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php $__currentLoopData = $arrivages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $arrivage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <?php echo e($arrivage->date_arrivage->format('d/m/Y')); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <?php echo e($arrivage->fournisseur->nom); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?php echo e($arrivage->lignes->count()); ?> produit(s)
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <?php if($arrivage->bl_path): ?>
                                                    <span class="text-green-600">✓ Oui</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400">- Non</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <div class="flex gap-2">
                                                    <a href="<?php echo e(route('arrivages.show', $arrivage)); ?>"
                                                        class="text-blue-600 hover:text-blue-700">
                                                        👁️ Voir
                                                    </a>
                                                    <a href="<?php echo e(route('controle.pdf', $arrivage)); ?>"
                                                        class="text-red-600 hover:text-red-700">
                                                        📄 PDF
                                                    </a>
                                                    <a href="<?php echo e(route('controle.zip', $arrivage)); ?>"
                                                        class="text-purple-600 hover:text-purple-700">
                                                        📦 ZIP
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <?php echo e($arrivages->links()); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
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
<?php /**PATH C:\laragon\www\haccp.grolleau\haccp-app\resources\views\controle\index.blade.php ENDPATH**/ ?>