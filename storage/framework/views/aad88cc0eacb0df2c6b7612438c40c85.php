<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0"><i class="fas fa-file-invoice"></i> Gestion des Devis</h1>
            <p class="text-muted">Gérez les demandes de devis de vos clients</p>
        </div>
        <a href="<?php echo e(route('admin.quotes.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouveau Devis
        </a>
    </div>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Devis</p>
                            <h3 class="mb-0"><?php echo e($stats['total']); ?></h3>
                        </div>
                        <div class="text-primary">
                            <i class="fas fa-file-invoice fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Brouillons</p>
                            <h3 class="mb-0 text-secondary"><?php echo e($stats['draft']); ?></h3>
                        </div>
                        <div class="text-secondary">
                            <i class="fas fa-edit fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Envoyés</p>
                            <h3 class="mb-0 text-info"><?php echo e($stats['sent']); ?></h3>
                        </div>
                        <div class="text-info">
                            <i class="fas fa-paper-plane fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Acceptés</p>
                            <h3 class="mb-0 text-success"><?php echo e($stats['accepted']); ?></h3>
                        </div>
                        <div class="text-success">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Convertis</p>
                            <h3 class="mb-0 text-primary"><?php echo e($stats['converted']); ?></h3>
                        </div>
                        <div class="text-primary">
                            <i class="fas fa-exchange-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Montant Total</p>
                            <h4 class="mb-0"><?php echo e(number_format($stats['total_amount'], 2)); ?> TND</h4>
                        </div>
                        <div class="text-warning">
                            <i class="fas fa-coins fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.quotes.index')); ?>" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Vendeur</label>
                    <select name="user_id" class="form-select">
                        <option value="">Tous les vendeurs</option>
                        <?php $__currentLoopData = $vendeurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendeur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($vendeur->id); ?>" <?php echo e(request('user_id') == $vendeur->id ? 'selected' : ''); ?>>
                                <?php echo e($vendeur->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Statut</label>
                    <select name="status" class="form-select">
                        <option value="">Tous les statuts</option>
                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($status); ?>" <?php echo e(request('status') == $status ? 'selected' : ''); ?>>
                                <?php echo e(ucfirst($status)); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Date début</label>
                    <input type="date" name="from_date" class="form-control" value="<?php echo e(request('from_date')); ?>">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Date fin</label>
                    <input type="date" name="to_date" class="form-control" value="<?php echo e(request('to_date')); ?>">
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filtrer
                    </button>
                    <a href="<?php echo e(route('admin.quotes.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des devis -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-list"></i> Liste des Devis</h5>
        </div>
        <div class="card-body">
            <?php if($quotes->isEmpty()): ?>
                <div class="text-center py-5">
                    <i class="fas fa-file-invoice fa-4x text-muted mb-3"></i>
                    <p class="text-muted">Aucun devis trouvé</p>
                    <a href="<?php echo e(route('admin.quotes.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Créer le premier devis
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>N° Devis</th>
                                <th>Client</th>
                                <th>Date</th>
                                <th>Validité</th>
                                <th>Montant Total</th>
                                <th>Statut</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $quotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <strong><?php echo e($quote->quote_number); ?></strong>
                                    </td>
                                    <td>
                                        <div>
                                            <strong><?php echo e($quote->user->name); ?></strong>
                                            <br>
                                            <small class="text-muted"><?php echo e($quote->user->company_name); ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <small><?php echo e($quote->created_at->format('d/m/Y')); ?></small>
                                    </td>
                                    <td>
                                        <?php if($quote->valid_until): ?>
                                            <small><?php echo e(\Carbon\Carbon::parse($quote->valid_until)->format('d/m/Y')); ?></small>
                                            <br>
                                            <?php if(\Carbon\Carbon::parse($quote->valid_until)->isPast()): ?>
                                                <span class="badge bg-danger">Expiré</span>
                                            <?php else: ?>
                                                <small class="text-success">
                                                    <?php echo e(\Carbon\Carbon::parse($quote->valid_until)->diffForHumans()); ?>

                                                </small>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <small class="text-muted">Non défini</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?php echo e(number_format($quote->total, 2)); ?> TND</strong>
                                    </td>
                                    <td>
                                        <?php
                                            $statusColors = [
                                                'draft' => 'secondary',
                                                'sent' => 'info',
                                                'viewed' => 'primary',
                                                'accepted' => 'success',
                                                'rejected' => 'danger',
                                                'expired' => 'warning',
                                                'converted' => 'success'
                                            ];
                                            $color = $statusColors[$quote->status] ?? 'secondary';
                                        ?>
                                        <span class="badge bg-<?php echo e($color); ?>">
                                            <?php echo e(ucfirst($quote->status)); ?>

                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('admin.quotes.show', $quote)); ?>"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <?php if($quote->status === 'draft'): ?>
                                                <a href="<?php echo e(route('admin.quotes.edit', $quote)); ?>"
                                                   class="btn btn-sm btn-outline-warning"
                                                   title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if(in_array($quote->status, ['draft', 'sent'])): ?>
                                                <form action="<?php echo e(route('admin.quotes.send', $quote)); ?>"
                                                      method="POST"
                                                      class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit"
                                                            class="btn btn-sm btn-outline-info"
                                                            title="Envoyer au client">
                                                        <i class="fas fa-paper-plane"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>

                                            <?php if($quote->status === 'accepted' && !$quote->converted_order_id): ?>
                                                <form action="<?php echo e(route('admin.quotes.convert', $quote)); ?>"
                                                      method="POST"
                                                      class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit"
                                                            class="btn btn-sm btn-outline-success"
                                                            title="Convertir en commande">
                                                        <i class="fas fa-exchange-alt"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>

                                            <a href="<?php echo e(route('admin.quotes.pdf', $quote)); ?>"
                                               class="btn btn-sm btn-outline-danger"
                                               title="Télécharger PDF"
                                               target="_blank">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>

                                            <?php if($quote->status === 'draft'): ?>
                                                <form action="<?php echo e(route('admin.quotes.destroy', $quote)); ?>"
                                                      method="POST"
                                                      class="d-inline"
                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce devis ?');">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit"
                                                            class="btn btn-sm btn-outline-danger"
                                                            title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    <?php echo e($quotes->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views/admin/quotes/index.blade.php ENDPATH**/ ?>