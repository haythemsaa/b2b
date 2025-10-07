<?php $__env->startSection('title', 'Mes Devis'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><i class="fas fa-file-invoice me-2 text-primary"></i>Mes Devis</h1>
                <a href="<?php echo e(route('quotes.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Créer un Devis
                </a>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if(isset($quotes) && $quotes->count() > 0): ?>
    <div class="row">
        <div class="col-12">
            <?php $__currentLoopData = $quotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card mb-3 shadow-sm">
                <div class="card-header bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <h6 class="mb-0"><i class="fas fa-file-alt me-2"></i><?php echo e($quote->quote_number); ?></h6>
                            <small class="text-muted"><?php echo e($quote->created_at->format('d/m/Y H:i')); ?></small>
                        </div>
                        <div class="col-md-3">
                            <strong><?php echo e($quote->customer_name); ?></strong>
                            <br>
                            <small class="text-muted"><?php echo e($quote->customer_email); ?></small>
                        </div>
                        <div class="col-md-2">
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
                            <span class="badge bg-<?php echo e($statusColors[$quote->status] ?? 'secondary'); ?>">
                                <?php echo e($statusLabels[$quote->status] ?? ucfirst($quote->status)); ?>

                            </span>
                        </div>
                        <div class="col-md-2">
                            <strong class="text-success"><?php echo e(number_format($quote->total, 3)); ?> <?php echo e($quote->currency); ?></strong>
                            <br>
                            <small class="text-muted"><?php echo e($quote->items->count()); ?> article(s)</small>
                        </div>
                        <div class="col-md-2 text-end">
                            <a href="<?php echo e(route('quotes.show', $quote)); ?>" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>Voir Détails
                            </a>
                        </div>
                    </div>
                </div>

                <?php if($quote->items && $quote->items->count() > 0): ?>
                <div class="card-body">
                    <div class="row">
                        <?php $__currentLoopData = $quote->items->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4 mb-2">
                            <div class="d-flex align-items-center">
                                <?php if($item->product && $item->product->coverImage): ?>
                                <img src="/storage/<?php echo e($item->product->coverImage->image_path); ?>" class="me-2 rounded" style="width: 40px; height: 40px; object-fit: cover;" alt="<?php echo e($item->product_name); ?>">
                                <?php else: ?>
                                <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fas fa-image text-muted small"></i>
                                </div>
                                <?php endif; ?>
                                <div>
                                    <small class="fw-medium"><?php echo e($item->product_name); ?></small>
                                    <br>
                                    <small class="text-muted">Qté: <?php echo e($item->quantity); ?> × <?php echo e(number_format($item->unit_price, 3)); ?></small>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($quote->items->count() > 3): ?>
                        <div class="col-md-12">
                            <small class="text-muted">et <?php echo e($quote->items->count() - 3); ?> autre(s) article(s)...</small>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php if($quote->valid_until): ?>
                    <div class="mt-2">
                        <small class="text-muted">
                            <i class="fas fa-calendar-alt me-1"></i>
                            Valide jusqu'au: <strong><?php echo e($quote->valid_until->format('d/m/Y')); ?></strong>
                            <?php if($quote->isExpired()): ?>
                                <span class="badge bg-warning ms-2">Expiré</span>
                            <?php endif; ?>
                        </small>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if(method_exists($quotes, 'links')): ?>
            <div class="d-flex justify-content-center">
                <?php echo e($quotes->links()); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php else: ?>
    <div class="row">
        <div class="col-12 text-center py-5">
            <i class="fas fa-file-invoice display-1 text-muted mb-3"></i>
            <h4 class="text-muted mb-3">Aucun devis trouvé</h4>
            <p class="text-muted mb-4">Vous n'avez pas encore créé de devis. Commencez par créer votre premier devis.</p>
            <a href="<?php echo e(route('quotes.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Créer mon Premier Devis
            </a>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\quotes\index.blade.php ENDPATH**/ ?>