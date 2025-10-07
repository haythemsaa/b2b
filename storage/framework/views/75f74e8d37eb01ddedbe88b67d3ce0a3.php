<?php $__env->startSection('title', 'Détails du Devis'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><i class="fas fa-file-invoice me-2 text-primary"></i>Devis <?php echo e($quote->quote_number); ?></h1>
                <div>
                    <a href="<?php echo e(route('quotes.index')); ?>" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Retour
                    </a>
                    <a href="<?php echo e(route('quotes.pdf', $quote)); ?>" class="btn btn-outline-primary me-2" target="_blank">
                        <i class="fas fa-file-pdf me-2"></i>Télécharger PDF
                    </a>
                    <?php if($quote->status === 'draft'): ?>
                    <form action="<?php echo e(route('quotes.send', $quote)); ?>" method="POST" class="d-inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-success" onclick="return confirm('Envoyer ce devis au client?')">
                            <i class="fas fa-paper-plane me-2"></i>Envoyer
                        </button>
                    </form>
                    <?php endif; ?>
                    <?php if($quote->canBeConverted() && Auth::id() === $quote->user_id): ?>
                    <form action="<?php echo e(route('quotes.convert', $quote)); ?>" method="POST" class="d-inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Convertir ce devis en commande?')">
                            <i class="fas fa-exchange-alt me-2"></i>Convertir en Commande
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if(session('warning')): ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i><?php echo e(session('warning')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="row">
        <!-- Informations Générales -->
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informations</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Statut:</label>
                        <br>
                        <?php
                            $statusColors = [
                                'draft' => 'secondary',
                                'sent' => 'info',
                                'viewed' => 'primary',
                                'accepted' => 'success',
                                'rejected' => 'danger',
                                'expired' => 'warning',
                                'converted' => 'dark'
                            ];
                            $statusLabels = [
                                'draft' => 'Brouillon',
                                'sent' => 'Envoyé',
                                'viewed' => 'Vu',
                                'accepted' => 'Accepté',
                                'rejected' => 'Rejeté',
                                'expired' => 'Expiré',
                                'converted' => 'Converti'
                            ];
                        ?>
                        <span class="badge bg-<?php echo e($statusColors[$quote->status] ?? 'secondary'); ?> fs-6">
                            <?php echo e($statusLabels[$quote->status] ?? ucfirst($quote->status)); ?>

                        </span>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Date de création:</label>
                        <br>
                        <strong><?php echo e($quote->created_at->format('d/m/Y à H:i')); ?></strong>
                    </div>

                    <?php if($quote->valid_until): ?>
                    <div class="mb-3">
                        <label class="text-muted small">Valide jusqu'au:</label>
                        <br>
                        <strong><?php echo e($quote->valid_until->format('d/m/Y')); ?></strong>
                        <?php if($quote->isExpired()): ?>
                        <span class="badge bg-warning ms-2">Expiré</span>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <?php if($quote->accepted_at): ?>
                    <div class="mb-3">
                        <label class="text-muted small">Accepté le:</label>
                        <br>
                        <strong><?php echo e($quote->accepted_at->format('d/m/Y')); ?></strong>
                    </div>
                    <?php endif; ?>

                    <?php if($quote->rejected_at): ?>
                    <div class="mb-3">
                        <label class="text-muted small">Rejeté le:</label>
                        <br>
                        <strong><?php echo e($quote->rejected_at->format('d/m/Y')); ?></strong>
                    </div>
                    <?php endif; ?>

                    <?php if($quote->converted_order_id): ?>
                    <div class="mb-3">
                        <label class="text-muted small">Commande liée:</label>
                        <br>
                        <a href="<?php echo e(route('orders.show', $quote->convertedOrder->order_number)); ?>" class="btn btn-sm btn-outline-primary">
                            Voir Commande #<?php echo e($quote->convertedOrder->order_number); ?>

                        </a>
                    </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="text-muted small">Vendeur:</label>
                        <br>
                        <strong><?php echo e($quote->user->name); ?></strong>
                        <br>
                        <small class="text-muted"><?php echo e($quote->user->email); ?></small>
                    </div>

                    <div class="mb-0">
                        <label class="text-muted small">Grossiste:</label>
                        <br>
                        <strong><?php echo e($quote->grossiste->name); ?></strong>
                        <br>
                        <small class="text-muted"><?php echo e($quote->grossiste->email); ?></small>
                    </div>
                </div>
            </div>

            <!-- Actions Grossiste -->
            <?php if(Auth::id() === $quote->grossiste_id && in_array($quote->status, ['sent', 'viewed'])): ?>
            <div class="card mb-4 shadow-sm border-success">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Actions</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('quotes.accept', $quote)); ?>" method="POST" class="mb-2">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-success w-100" onclick="return confirm('Accepter ce devis?')">
                            <i class="fas fa-check-circle me-2"></i>Accepter le Devis
                        </button>
                    </form>
                    <form action="<?php echo e(route('quotes.reject', $quote)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Rejeter ce devis?')">
                            <i class="fas fa-times-circle me-2"></i>Rejeter le Devis
                        </button>
                    </form>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Client et Articles -->
        <div class="col-md-8">
            <!-- Informations Client -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Client</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small">Nom:</label>
                                <br>
                                <strong><?php echo e($quote->customer_name); ?></strong>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small">Email:</label>
                                <br>
                                <a href="mailto:<?php echo e($quote->customer_email); ?>"><?php echo e($quote->customer_email); ?></a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <?php if($quote->customer_phone): ?>
                            <div class="mb-3">
                                <label class="text-muted small">Téléphone:</label>
                                <br>
                                <a href="tel:<?php echo e($quote->customer_phone); ?>"><?php echo e($quote->customer_phone); ?></a>
                            </div>
                            <?php endif; ?>
                            <?php if($quote->customer_address): ?>
                            <div class="mb-0">
                                <label class="text-muted small">Adresse:</label>
                                <br>
                                <?php echo e($quote->customer_address); ?>

                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Articles -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Articles (<?php echo e($quote->items->count()); ?>)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Produit</th>
                                    <th class="text-center">Quantité</th>
                                    <th class="text-end">Prix Unit.</th>
                                    <th class="text-center">Remise</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $quote->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if($item->product && $item->product->coverImage): ?>
                                            <img src="/storage/<?php echo e($item->product->coverImage->image_path); ?>"
                                                 class="me-3 rounded" style="width: 50px; height: 50px; object-fit: cover;"
                                                 alt="<?php echo e($item->product_name); ?>">
                                            <?php endif; ?>
                                            <div>
                                                <strong><?php echo e($item->product_name); ?></strong>
                                                <br>
                                                <small class="text-muted">SKU: <?php echo e($item->product_sku); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge bg-secondary"><?php echo e($item->quantity); ?></span>
                                    </td>
                                    <td class="text-end align-middle">
                                        <?php echo e(number_format($item->unit_price, 3)); ?> <?php echo e($quote->currency); ?>

                                    </td>
                                    <td class="text-center align-middle">
                                        <?php if($item->discount_percent > 0): ?>
                                        <span class="badge bg-warning text-dark">-<?php echo e($item->discount_percent); ?>%</span>
                                        <?php else: ?>
                                        -
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end align-middle">
                                        <strong><?php echo e(number_format($item->total, 3)); ?> <?php echo e($quote->currency); ?></strong>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Sous-total HT:</strong></td>
                                    <td class="text-end"><strong><?php echo e(number_format($quote->subtotal, 3)); ?> <?php echo e($quote->currency); ?></strong></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>TVA (<?php echo e($quote->tax_rate); ?>%):</strong></td>
                                    <td class="text-end"><strong><?php echo e(number_format($quote->tax_amount, 3)); ?> <?php echo e($quote->currency); ?></strong></td>
                                </tr>
                                <?php if($quote->discount_amount > 0): ?>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Remise:</strong></td>
                                    <td class="text-end"><strong class="text-danger">-<?php echo e(number_format($quote->discount_amount, 3)); ?> <?php echo e($quote->currency); ?></strong></td>
                                </tr>
                                <?php endif; ?>
                                <tr class="table-success">
                                    <td colspan="4" class="text-end"><strong class="fs-5">TOTAL TTC:</strong></td>
                                    <td class="text-end"><strong class="fs-5 text-success"><?php echo e(number_format($quote->total, 3)); ?> <?php echo e($quote->currency); ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <?php if($quote->notes || $quote->terms_conditions): ?>
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Notes & Conditions</h5>
                </div>
                <div class="card-body">
                    <?php if($quote->notes): ?>
                    <div class="mb-3">
                        <label class="text-muted small fw-bold">Notes:</label>
                        <p class="mb-0"><?php echo e($quote->notes); ?></p>
                    </div>
                    <?php endif; ?>

                    <?php if($quote->terms_conditions): ?>
                    <div class="mb-0">
                        <label class="text-muted small fw-bold">Conditions Générales:</label>
                        <p class="mb-0"><?php echo e($quote->terms_conditions); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\quotes\show.blade.php ENDPATH**/ ?>