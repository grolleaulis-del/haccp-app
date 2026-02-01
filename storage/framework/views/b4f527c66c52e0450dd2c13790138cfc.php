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
            ✏️ Modifier l'utilisateur
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <?php if($errors->any()): ?>
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="<?php echo e(route('users.update', $user)); ?>" class="space-y-6">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nom complet <span class="text-red-600">*</span>
                            </label>
                            <input type="text" name="name" id="name"
                                   value="<?php echo e(old('name', $user->name)); ?>"
                                   class="w-full rounded-md border-gray-300"
                                   required autofocus>
                        </div>

                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-600">*</span>
                            </label>
                            <input type="email" name="email" id="email"
                                   value="<?php echo e(old('email', $user->email)); ?>"
                                   class="w-full rounded-md border-gray-300"
                                   required>
                        </div>

                        
                        <?php if(auth()->user()->isAdmin()): ?>
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                                Rôle <span class="text-red-600">*</span>
                            </label>
                            <select name="role" id="role" class="w-full rounded-md border-gray-300" required>
                                <option value="employe" <?php echo e(old('role', $user->role) === 'employe' ? 'selected' : ''); ?>>
                                    👤 Employé - Accès aux fonctionnalités quotidiennes
                                </option>
                                <option value="manager" <?php echo e(old('role', $user->role) === 'manager' ? 'selected' : ''); ?>>
                                    ⭐ Manager - Gestion + visualisation des logs
                                </option>
                                <option value="admin" <?php echo e(old('role', $user->role) === 'admin' ? 'selected' : ''); ?>>
                                    👑 Admin - Accès complet au système
                                </option>
                            </select>
                        </div>

                        
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" 
                                       <?php echo e(old('is_active', $user->is_active) ? 'checked' : ''); ?>

                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                       <?php echo e($user->id === auth()->id() ? 'disabled' : ''); ?>>
                                <span class="ml-2 text-sm text-gray-700">Compte actif</span>
                            </label>
                            <?php if($user->id === auth()->id()): ?>
                                <p class="text-xs text-gray-500 mt-1">Vous ne pouvez pas désactiver votre propre compte</p>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        
                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-600 mb-4">
                                Laissez vide pour conserver le mot de passe actuel
                            </p>

                            <div class="mb-4">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nouveau mot de passe
                                </label>
                                <input type="password" name="password" id="password"
                                       class="w-full rounded-md border-gray-300">
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    Confirmer le nouveau mot de passe
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="w-full rounded-md border-gray-300">
                            </div>
                        </div>

                        
                        <div class="flex justify-end gap-3">
                            <a href="<?php echo e(route('users.index')); ?>"
                               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                💾 Enregistrer les modifications
                            </button>
                        </div>
                    </form>
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
<?php /**PATH C:\laragon\www\haccp.grolleau\haccp-app\resources\views\users\edit.blade.php ENDPATH**/ ?>