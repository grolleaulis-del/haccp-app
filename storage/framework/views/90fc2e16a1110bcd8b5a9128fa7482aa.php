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
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <?php echo e(__('DLC en cours')); ?>

            </h2>
            <a href="<?php echo e(route('dashboard')); ?>" class="text-indigo-600 hover:text-indigo-900">
                ← Retour au tableau de bord
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <?php if($lots->isEmpty()): ?>
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun lot avec DLC en cours</h3>
                            <p class="mt-1 text-sm text-gray-500">Tous les lots ont une DLC dépassée ou aucun lot n'est enregistré.</p>
                        </div>
                    <?php else: ?>
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">
                                <?php echo e($lots->count()); ?> lot(s) avec DLC en cours
                            </h3>
                            <p class="text-sm text-gray-600">
                                Lots dont la date limite de consommation n'est pas encore dépassée
                            </p>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Photo
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Produit
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            N° Lot
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date de Création
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            DLC
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jours restants
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Employé
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php $__currentLoopData = $lots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $joursRestants = \Carbon\Carbon::parse($lot->dlc)->diffInDays(\Carbon\Carbon::today(), false);
                                            $joursRestants = -$joursRestants; // Inverser pour avoir positif
                                            
                                            if ($joursRestants == 0) {
                                                $badgeClass = 'bg-red-100 text-red-800';
                                                $badgeText = 'Aujourd\'hui';
                                            } elseif ($joursRestants == 1) {
                                                $badgeClass = 'bg-orange-100 text-orange-800';
                                                $badgeText = 'Demain';
                                            } elseif ($joursRestants <= 3) {
                                                $badgeClass = 'bg-yellow-100 text-yellow-800';
                                                $badgeText = $joursRestants . ' jours';
                                            } else {
                                                $badgeClass = 'bg-green-100 text-green-800';
                                                $badgeText = $joursRestants . ' jours';
                                            }
                                        ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <?php if($lot->photo_etiquette): ?>
                                                    <img src="<?php echo e(asset('storage/photos_cuisson/' . $lot->photo_etiquette)); ?>" 
                                                         alt="Photo du lot" 
                                                         class="h-16 w-16 rounded object-cover cursor-pointer"
                                                         onclick="window.open(this.src, '_blank')">
                                                <?php else: ?>
                                                    <div class="h-16 w-16 bg-gray-200 rounded flex items-center justify-center">
                                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <?php echo e($lot->produit->nom ?? 'N/A'); ?>

                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    <?php echo e($lot->produit->famille ?? ''); ?>

                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-mono font-bold text-indigo-600">
                                                    <?php echo e($lot->numero_lot); ?>

                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    <?php echo e(\Carbon\Carbon::parse($lot->created_at)->format('d/m/Y')); ?>

                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    <?php echo e(\Carbon\Carbon::parse($lot->created_at)->format('H:i')); ?>

                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <?php echo e(\Carbon\Carbon::parse($lot->dlc)->format('d/m/Y')); ?>

                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($badgeClass); ?>">
                                                    <?php echo e($badgeText); ?>

                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    <?php echo e($lot->user->name ?? 'N/A'); ?>

                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 text-sm text-gray-500">
                            <p><strong>Légende des couleurs :</strong></p>
                            <ul class="mt-2 space-y-1">
                                <li><span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Aujourd'hui</span> - DLC expire aujourd'hui</li>
                                <li><span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Demain</span> - DLC expire demain</li>
                                <li><span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">≤ 3 jours</span> - DLC expire dans 2-3 jours</li>
                                <li><span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">> 3 jours</span> - DLC expire dans plus de 3 jours</li>
                            </ul>
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
<?php /**PATH C:\laragon\www\haccp.grolleau\haccp-app\resources\views\cuisson-refroidissement\dlc-en-cours.blade.php ENDPATH**/ ?>