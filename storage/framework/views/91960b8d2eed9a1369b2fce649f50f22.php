<?php $__env->startSection('title', 'Taux de Change'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">
                <i class="fas fa-exchange-alt text-success"></i> Taux de Change
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.currencies.index')); ?>">Devises</a></li>
                    <li class="breadcrumb-item active">Taux de Change</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="<?php echo e(route('admin.currencies.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour aux Devises
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Récupération automatique des taux -->
    <div class="card mb-4 shadow">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">
                <i class="fas fa-robot"></i> Récupération Automatique des Taux
            </h5>
        </div>
        <div class="card-body">
            <p>Récupérer automatiquement les taux de change depuis une API externe.</p>
            <form action="<?php echo e(route('admin.exchange-rates.fetch')); ?>" method="POST" class="row g-3">
                <?php echo csrf_field(); ?>
                <div class="col-md-4">
                    <label class="form-label">Devise de base</label>
                    <select name="base_currency" class="form-select" required>
                        <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($currency->code); ?>"
                                    <?php echo e($currency->code === 'TND' ? 'selected' : ''); ?>>
                                <?php echo e($currency->code); ?> - <?php echo e($currency->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-8 d-flex align-items-end">
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-download"></i> Récupérer les Taux
                    </button>
                    <small class="text-muted ms-3">
                        <i class="fas fa-info-circle"></i>
                        Utilise l'API exchangerate-api.com
                    </small>
                </div>
            </form>
        </div>
    </div>

    <!-- Taux de change du jour -->
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">
                <i class="fas fa-calendar-day"></i> Taux de Change Actuels
                <span class="badge bg-primary ms-2"><?php echo e(now()->format('d/m/Y')); ?></span>
            </h5>
        </div>
        <div class="card-body">
            <?php if($rates->isEmpty()): ?>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    Aucun taux de change trouvé pour aujourd'hui. Utilisez le bouton ci-dessus pour récupérer les taux.
                </div>
            <?php else: ?>
                <form action="<?php echo e(route('admin.exchange-rates.update')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>De</th>
                                    <th>Vers</th>
                                    <th>Taux</th>
                                    <th>Source</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $rates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $rate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo e($rate->fromCurrency->code); ?></strong>
                                            <small class="text-muted d-block"><?php echo e($rate->fromCurrency->name); ?></small>
                                        </td>
                                        <td>
                                            <strong><?php echo e($rate->toCurrency->code); ?></strong>
                                            <small class="text-muted d-block"><?php echo e($rate->toCurrency->name); ?></small>
                                        </td>
                                        <td>
                                            <input type="hidden" name="rates[<?php echo e($index); ?>][from_currency]" value="<?php echo e($rate->from_currency); ?>">
                                            <input type="hidden" name="rates[<?php echo e($index); ?>][to_currency]" value="<?php echo e($rate->to_currency); ?>">
                                            <input type="number"
                                                   step="0.000001"
                                                   name="rates[<?php echo e($index); ?>][rate]"
                                                   value="<?php echo e($rate->rate); ?>"
                                                   class="form-control form-control-sm"
                                                   style="width: 150px;">
                                        </td>
                                        <td>
                                            <?php if($rate->source === 'api'): ?>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-robot"></i> API
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-info">
                                                    <i class="fas fa-user"></i> Manuel
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($rate->date->format('d/m/Y')); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Enregistrer les Modifications
                        </button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <!-- Convertisseur de devises -->
    <div class="card mt-4 shadow">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">
                <i class="fas fa-calculator"></i> Convertisseur de Devises
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3" id="converter">
                <div class="col-md-3">
                    <label class="form-label">Montant</label>
                    <input type="number" step="0.01" class="form-control" id="amount" value="100">
                </div>
                <div class="col-md-3">
                    <label class="form-label">De</label>
                    <select class="form-select" id="from_currency">
                        <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($currency->code); ?>"><?php echo e($currency->code); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Vers</label>
                    <select class="form-select" id="to_currency">
                        <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($currency->code); ?>" <?php echo e($currency->code === 'EUR' ? 'selected' : ''); ?>>
                                <?php echo e($currency->code); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" class="btn btn-success w-100" id="convertBtn">
                        <i class="fas fa-exchange-alt"></i> Convertir
                    </button>
                </div>
            </div>
            <div id="result" class="mt-4"></div>
        </div>
    </div>
</div>

<script>
document.getElementById('convertBtn').addEventListener('click', function() {
    const amount = document.getElementById('amount').value;
    const from = document.getElementById('from_currency').value;
    const to = document.getElementById('to_currency').value;

    fetch('<?php echo e(route("admin.exchange-rates.convert")); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify({ amount, from, to })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('result').innerHTML = `
                <div class="alert alert-success">
                    <h4>${amount} ${from} = ${data.converted.toFixed(6)} ${to}</h4>
                    <p class="mb-0">Format: ${data.formatted}</p>
                </div>
            `;
        } else {
            document.getElementById('result').innerHTML = `
                <div class="alert alert-danger">
                    ${data.message}
                </div>
            `;
        }
    })
    .catch(error => {
        document.getElementById('result').innerHTML = `
            <div class="alert alert-danger">
                Erreur lors de la conversion
            </div>
        `;
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\currencies\rates.blade.php ENDPATH**/ ?>