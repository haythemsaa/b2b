<?php $__env->startSection('title', 'Gestion des Vendeurs'); ?>
<?php $__env->startSection('page-title', 'Gestion des Vendeurs'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">Vendeurs</h2>
                <p class="text-muted">Gérez les comptes vendeurs</p>
            </div>
            <div>
                <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouveau Vendeur
                </a>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Liste des Vendeurs</h5>
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3 mb-4">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Rechercher..." value="<?php echo e(request('search')); ?>">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="1" <?php echo e(request('status') === '1' ? 'selected' : ''); ?>>Actif</option>
                                <option value="0" <?php echo e(request('status') === '0' ? 'selected' : ''); ?>>Inactif</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-outline-primary w-100">Filtrer</button>
                        </div>
                        <div class="col-md-2">
                            <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-outline-secondary w-100">Reset</a>
                        </div>
                    </form>

                    <?php if($users->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Vendeur</th>
                                        <th>Entreprise</th>
                                        <th>Téléphone</th>
                                        <th>Groupes</th>
                                        <th>Statut</th>
                                        <th>Inscrit le</th>
                                        <th width="150">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <strong><?php echo e($user->name); ?></strong>
                                                    <div class="small text-muted"><?php echo e($user->email); ?></div>
                                                </div>
                                            </td>
                                            <td><?php echo e($user->company_name ?: '-'); ?></td>
                                            <td><?php echo e($user->phone ?: '-'); ?></td>
                                            <td>
                                                <?php if($user->customerGroups->count() > 0): ?>
                                                    <?php $__currentLoopData = $user->customerGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <span class="badge bg-info me-1"><?php echo e($group->name); ?></span>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <span class="text-muted">Aucun groupe</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($user->is_active): ?>
                                                    <span class="badge bg-success">Actif</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Inactif</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($user->created_at->format('d/m/Y')); ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo e(route('admin.users.edit', $user)); ?>"
                                                       class="btn btn-sm btn-outline-primary" title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-warning toggle-status"
                                                            data-user-id="<?php echo e($user->id); ?>"
                                                            title="<?php echo e($user->is_active ? 'Désactiver' : 'Activer'); ?>">
                                                        <i class="fas <?php echo e($user->is_active ? 'fa-pause' : 'fa-play'); ?>"></i>
                                                    </button>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-danger delete-user"
                                                            data-user-id="<?php echo e($user->id); ?>"
                                                            data-user-name="<?php echo e($user->name); ?>"
                                                            title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <?php echo e($users->withQueryString()->links()); ?>

                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucun vendeur trouvé</h5>
                            <p class="text-muted">Commencez par créer votre premier vendeur.</p>
                            <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Créer un Vendeur
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-user');
    const toggleButtons = document.querySelectorAll('.toggle-status');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.userId;
            const userName = this.dataset.userName;

            if (confirm(`Êtes-vous sûr de vouloir supprimer le vendeur "${userName}" ?`)) {
                fetch(`/admin/users/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Une erreur est survenue');
                });
            }
        });
    });

    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.userId;

            fetch(`/admin/users/${userId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    location.reload();
                } else {
                    alert('Une erreur est survenue');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Une erreur est survenue');
            });
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views/admin/users/index.blade.php ENDPATH**/ ?>