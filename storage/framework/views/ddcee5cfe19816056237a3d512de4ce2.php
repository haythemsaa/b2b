<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-file-invoice"></i> Devis <?php echo e($quote->quote_number); ?>

            </h1>
            <p class="text-muted">Détails du devis</p>
        </div>
        <div>
            <a href="<?php echo e(route('admin.quotes.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
            <a href="<?php echo e(route('admin.quotes.pdf', $quote)); ?>" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf"></i> PDF
            </a>
            <?php if($quote->status === 'draft'): ?>
                <a href="<?php echo e(route('admin.quotes.edit', $quote)); ?>" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Modifier
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <!-- Informations principales -->
        <div class="col-md-8">
            <!-- Informations du devis -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informations du Devis</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>N° Devis:</strong> <?php echo e($quote->quote_number); ?></p>
                            <p><strong>Date création:</strong> <?php echo e($quote->created_at->format('d/m/Y H:i')); ?></p>
                            <p><strong>Validité jusqu'au:</strong>
                                <?php if($quote->valid_until): ?>
                                    <?php echo e(\Carbon\Carbon::parse($quote->valid_until)->format('d/m/Y')); ?>

                                    <?php if(\Carbon\Carbon::parse($quote->valid_until)->isPast()): ?>
                                        <span class="badge bg-danger">Expiré</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-muted">Non défini</span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Statut:</strong>
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
                                <span class="badge bg-<?php echo e($color); ?>"><?php echo e(ucfirst($quote->status)); ?></span>
                            </p>
                            <p><strong>Créé par:</strong> <?php echo e($quote->grossiste->name); ?></p>
                            <?php if($quote->sent_at): ?>
                                <p><strong>Envoyé le:</strong> <?php echo e($quote->sent_at->format('d/m/Y H:i')); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if($quote->notes): ?>
                        <hr>
                        <p><strong>Notes:</strong></p>
                        <p class="text-muted"><?php echo e($quote->notes); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Client -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-user"></i> Informations Client</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nom:</strong> <?php echo e($quote->user->name); ?></p>
                            <p><strong>Email:</strong> <?php echo e($quote->user->email); ?></p>
                            <p><strong>Téléphone:</strong> <?php echo e($quote->user->phone ?? 'N/A'); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Société:</strong> <?php echo e($quote->user->company_name); ?></p>
                            <p><strong>Adresse:</strong> <?php echo e($quote->user->address ?? 'N/A'); ?></p>
                            <p><strong>Ville:</strong> <?php echo e($quote->user->city ?? 'N/A'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Articles du devis -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-box"></i> Articles du Devis</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>SKU</th>
                                    <th class="text-end">Prix Unitaire</th>
                                    <th class="text-center">Quantité</th>
                                    <th class="text-end">Remise</th>
                                    <th class="text-end">Sous-total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $quote->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo e($item->product->name); ?></strong>
                                            <?php if($item->notes): ?>
                                                <br><small class="text-muted"><?php echo e($item->notes); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($item->product->sku); ?></td>
                                        <td class="text-end"><?php echo e(number_format($item->unit_price, 2)); ?> TND</td>
                                        <td class="text-center"><?php echo e($item->quantity); ?></td>
                                        <td class="text-end">
                                            <?php if($item->discount > 0): ?>
                                                <?php echo e(number_format($item->discount, 2)); ?> TND
                                                <br><small class="text-success">(<?php echo e(number_format(($item->discount / ($item->unit_price * $item->quantity)) * 100, 2)); ?>%)</small>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end">
                                            <strong><?php echo e(number_format($item->subtotal, 2)); ?> TND</strong>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end"><strong>Sous-total:</strong></td>
                                    <td class="text-end"><strong><?php echo e(number_format($quote->subtotal, 2)); ?> TND</strong></td>
                                </tr>
                                <?php if($quote->discount > 0): ?>
                                    <tr>
                                        <td colspan="5" class="text-end"><strong>Remise globale:</strong></td>
                                        <td class="text-end text-success">
                                            <strong>-<?php echo e(number_format($quote->discount, 2)); ?> TND</strong>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td colspan="5" class="text-end"><strong>TVA (<?php echo e($quote->tax_rate ?? 0); ?>%):</strong></td>
                                    <td class="text-end"><strong><?php echo e(number_format($quote->tax, 2)); ?> TND</strong></td>
                                </tr>
                                <tr class="table-primary">
                                    <td colspan="5" class="text-end"><strong>TOTAL:</strong></td>
                                    <td class="text-end"><h4 class="mb-0"><?php echo e(number_format($quote->total, 2)); ?> TND</h4></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Conditions -->
            <?php if($quote->terms): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-file-contract"></i> Conditions</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted"><?php echo e($quote->terms); ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Actions et historique -->
        <div class="col-md-4">
            <!-- Actions rapides -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-tasks"></i> Actions</h5>
                </div>
                <div class="card-body">
                    <?php if(in_array($quote->status, ['draft', 'sent'])): ?>
                        <form action="<?php echo e(route('admin.quotes.send', $quote)); ?>" method="POST" class="mb-2">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-info w-100">
                                <i class="fas fa-paper-plane"></i> Envoyer au Client
                            </button>
                        </form>
                    <?php endif; ?>

                    <?php if($quote->status === 'sent' || $quote->status === 'viewed'): ?>
                        <form action="<?php echo e(route('admin.quotes.accept', $quote)); ?>" method="POST" class="mb-2">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-check"></i> Marquer Accepté
                            </button>
                        </form>

                        <form action="<?php echo e(route('admin.quotes.reject', $quote)); ?>" method="POST" class="mb-2">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-times"></i> Marquer Rejeté
                            </button>
                        </form>
                    <?php endif; ?>

                    <?php if($quote->status === 'accepted' && !$quote->converted_order_id): ?>
                        <form action="<?php echo e(route('admin.quotes.convert', $quote)); ?>" method="POST" class="mb-2">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-exchange-alt"></i> Convertir en Commande
                            </button>
                        </form>
                    <?php endif; ?>

                    <?php if($quote->converted_order_id): ?>
                        <a href="<?php echo e(route('admin.orders.show', $quote->convertedOrder)); ?>" class="btn btn-outline-primary w-100 mb-2">
                            <i class="fas fa-shopping-cart"></i> Voir la Commande
                        </a>
                    <?php endif; ?>

                    <a href="<?php echo e(route('admin.quotes.duplicate', $quote)); ?>" class="btn btn-outline-secondary w-100 mb-2">
                        <i class="fas fa-copy"></i> Dupliquer
                    </a>

                    <?php if($quote->status === 'draft'): ?>
                        <form action="<?php echo e(route('admin.quotes.destroy', $quote)); ?>"
                              method="POST"
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce devis ?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Timeline/Historique -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-history"></i> Historique</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <p class="mb-0"><strong>Devis créé</strong></p>
                                <small class="text-muted"><?php echo e($quote->created_at->format('d/m/Y H:i')); ?></small>
                            </div>
                        </div>

                        <?php if($quote->sent_at): ?>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <p class="mb-0"><strong>Devis envoyé</strong></p>
                                    <small class="text-muted"><?php echo e($quote->sent_at->format('d/m/Y H:i')); ?></small>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if($quote->viewed_at): ?>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <p class="mb-0"><strong>Devis consulté</strong></p>
                                    <small class="text-muted"><?php echo e($quote->viewed_at->format('d/m/Y H:i')); ?></small>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if($quote->accepted_at): ?>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <p class="mb-0"><strong>Devis accepté</strong></p>
                                    <small class="text-muted"><?php echo e($quote->accepted_at->format('d/m/Y H:i')); ?></small>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if($quote->rejected_at): ?>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-danger"></div>
                                <div class="timeline-content">
                                    <p class="mb-0"><strong>Devis rejeté</strong></p>
                                    <small class="text-muted"><?php echo e($quote->rejected_at->format('d/m/Y H:i')); ?></small>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if($quote->converted_order_id): ?>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <p class="mb-0"><strong>Converti en commande</strong></p>
                                    <small class="text-muted"><?php echo e($quote->updated_at->format('d/m/Y H:i')); ?></small>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-item:before {
    content: '';
    position: absolute;
    left: -22px;
    top: 8px;
    bottom: -12px;
    width: 2px;
    background: #dee2e6;
}

.timeline-item:last-child:before {
    display: none;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 0;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-content {
    padding-left: 0;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\quotes\show.blade.php ENDPATH**/ ?>