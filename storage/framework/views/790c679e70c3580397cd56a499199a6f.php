

<?php $__env->startSection('title', 'Gestion des Groupes de Clients'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Groupes de Clients</h1>
                <a href="<?php echo e(route('admin.groups.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouveau Groupe
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
                    <h5 class="card-title mb-0">Liste des Groupes</h5>
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
                            <a href="<?php echo e(route('admin.groups.index')); ?>" class="btn btn-outline-secondary w-100">Reset</a>
                        </div>
                    </form>

                    <?php if($groups->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Description</th>
                                        <th>Remise %</th>
                                        <th>Vendeurs</th>
                                        <th>Statut</th>
                                        <th>Créé le</th>
                                        <th width="150">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo e($group->name); ?></strong>
                                            </td>
                                            <td><?php echo e(Str::limit($group->description, 50)); ?></td>
                                            <td>
                                                <?php if($group->discount_percentage > 0): ?>
                                                    <span class="badge bg-success"><?php echo e($group->discount_percentage); ?>%</span>
                                                <?php else: ?>
                                                    <span class="text-muted">0%</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-info"><?php echo e($group->users_count); ?></span>
                                            </td>
                                            <td>
                                                <?php if($group->is_active): ?>
                                                    <span class="badge bg-success">Actif</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Inactif</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($group->created_at->format('d/m/Y')); ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo e(route('admin.groups.show', $group)); ?>"
                                                       class="btn btn-sm btn-outline-info" title="Voir">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?php echo e(route('admin.groups.edit', $group)); ?>"
                                                       class="btn btn-sm btn-outline-primary" title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-warning toggle-status"
                                                            data-group-id="<?php echo e($group->id); ?>"
                                                            title="<?php echo e($group->is_active ? 'Désactiver' : 'Activer'); ?>">
                                                        <i class="fas <?php echo e($group->is_active ? 'fa-pause' : 'fa-play'); ?>"></i>
                                                    </button>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-danger delete-group"
                                                            data-group-id="<?php echo e($group->id); ?>"
                                                            data-group-name="<?php echo e($group->name); ?>"
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

                        <?php echo e($groups->withQueryString()->links()); ?>

                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucun groupe trouvé</h5>
                            <p class="text-muted">Commencez par créer votre premier groupe de clients.</p>
                            <a href="<?php echo e(route('admin.groups.create')); ?>" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Créer un Groupe
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
    const deleteButtons = document.querySelectorAll('.delete-group');
    const toggleButtons = document.querySelectorAll('.toggle-status');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const groupId = this.dataset.groupId;
            const groupName = this.dataset.groupName;

            if (confirm(`Êtes-vous sûr de vouloir supprimer le groupe "${groupName}" ?`)) {
                fetch(`/admin/groups/${groupId}`, {
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
            const groupId = this.dataset.groupId;

            fetch(`/admin/groups/${groupId}/toggle-status`, {
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\groups\index.blade.php ENDPATH**/ ?>