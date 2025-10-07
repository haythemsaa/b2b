<?php $__env->startSection('title', 'Mes Adresses'); ?>

<?php $__env->startSection('content'); ?>
<div class="container" x-data="addressManager()" x-init="init()">
    <!-- Header -->
    <div class="row mb-4 animate__animated animate__fadeInDown">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1><i class="bi bi-geo-alt-fill me-2 text-primary"></i>Mes Adresses</h1>
                    <p class="text-muted mb-0">Gérez vos adresses de livraison</p>
                </div>
                <a href="<?php echo e(route('addresses.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Nouvelle Adresse
                </a>
            </div>
        </div>
    </div>

    <!-- Empty State -->
    <?php if($addresses->isEmpty()): ?>
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 animate__animated animate__fadeIn">
                <div class="card-body text-center py-5">
                    <i class="bi bi-geo-alt display-1 text-muted mb-4"></i>
                    <h3 class="text-muted mb-3">Aucune adresse enregistrée</h3>
                    <p class="text-muted mb-4">
                        Ajoutez une adresse de livraison pour faciliter vos commandes
                    </p>
                    <a href="<?php echo e(route('addresses.create')); ?>" class="btn btn-primary btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>Ajouter une adresse
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <!-- Addresses Grid -->
    <div class="row">
        <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-lg-6 mb-4">
            <div class="card h-100 shadow-sm border-0 animate__animated animate__fadeInUp"
                 style="animation-delay: <?php echo e($index * 0.1); ?>s;">
                <div class="card-body">
                    <!-- Address Header -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <?php if($address->label): ?>
                            <h5 class="card-title mb-1">
                                <i class="bi bi-tag-fill me-2 text-primary"></i><?php echo e($address->label); ?>

                            </h5>
                            <?php else: ?>
                            <h5 class="card-title mb-1">
                                <i class="bi bi-geo-alt-fill me-2 text-primary"></i>Adresse <?php echo e($index + 1); ?>

                            </h5>
                            <?php endif; ?>

                            <?php if($address->is_default): ?>
                            <span class="badge bg-success">
                                <i class="bi bi-star-fill"></i> Par défaut
                            </span>
                            <?php endif; ?>
                        </div>

                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('addresses.edit', $address)); ?>">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </a>
                                </li>
                                <?php if(!$address->is_default): ?>
                                <li>
                                    <button class="dropdown-item" @click="setDefault(<?php echo e($address->id); ?>)">
                                        <i class="bi bi-star"></i> Définir par défaut
                                    </button>
                                </li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <button class="dropdown-item text-danger" @click="deleteAddress(<?php echo e($address->id); ?>)">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Address Details -->
                    <div class="mb-3">
                        <p class="mb-1"><strong><?php echo e($address->full_name); ?></strong></p>
                        <?php if($address->company_name): ?>
                        <p class="mb-1 text-muted"><?php echo e($address->company_name); ?></p>
                        <?php endif; ?>
                        <p class="mb-1"><?php echo e($address->address_line1); ?></p>
                        <?php if($address->address_line2): ?>
                        <p class="mb-1"><?php echo e($address->address_line2); ?></p>
                        <?php endif; ?>
                        <p class="mb-1"><?php echo e($address->postal_code); ?> <?php echo e($address->city); ?></p>
                        <?php if($address->state): ?>
                        <p class="mb-1"><?php echo e($address->state); ?></p>
                        <?php endif; ?>
                        <p class="mb-1"><?php echo e($address->country); ?></p>
                    </div>

                    <!-- Contact Info -->
                    <div class="border-top pt-3">
                        <p class="mb-2">
                            <i class="bi bi-telephone me-2"></i>
                            <a href="tel:<?php echo e($address->phone); ?>"><?php echo e($address->phone); ?></a>
                        </p>
                        <?php if($address->notes): ?>
                        <p class="mb-0 text-muted small">
                            <i class="bi bi-info-circle me-2"></i><?php echo e($address->notes); ?>

                        </p>
                        <?php endif; ?>
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-3 d-grid gap-2 d-md-flex">
                        <a href="<?php echo e(route('addresses.edit', $address)); ?>"
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i> Modifier
                        </a>
                        <?php if(!$address->is_default): ?>
                        <button class="btn btn-sm btn-outline-success"
                                @click="setDefault(<?php echo e($address->id); ?>)">
                            <i class="bi bi-star"></i> Par défaut
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function addressManager() {
    return {
        init() {
            console.log('Address manager initialized');
        },

        async setDefault(addressId) {
            try {
                const response = await fetch(`/addresses/${addressId}/set-default`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();

                if (data.success) {
                    notyf.success('Adresse définie comme par défaut');
                    // Reload page to update UI
                    setTimeout(() => window.location.reload(), 500);
                } else {
                    notyf.error(data.message || 'Erreur');
                }
            } catch (error) {
                notyf.error('Erreur lors de la mise à jour');
                console.error(error);
            }
        },

        async deleteAddress(addressId) {
            const result = await Swal.fire({
                title: 'Supprimer cette adresse?',
                text: 'Cette action est irréversible',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler',
                confirmButtonColor: '#dc3545'
            });

            if (!result.isConfirmed) return;

            try {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/addresses/${addressId}`;

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';

                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            } catch (error) {
                notyf.error('Erreur lors de la suppression');
                console.error(error);
            }
        }
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\addresses\index.blade.php ENDPATH**/ ?>