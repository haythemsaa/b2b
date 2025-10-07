<!DOCTYPE html>
<html>
<head>
    <title>Test Images - Produit #<?php echo e($product->id); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>🔍 Test d'affichage des images - <?php echo e($product->name); ?></h1>

        <div class="alert alert-info">
            <strong>Informations du serveur:</strong><br>
            URL de base: <?php echo e(url('/')); ?><br>
            Storage URL: <?php echo e(url('/storage')); ?><br>
            Nombre d'images: <?php echo e($images->count()); ?>

        </div>

        <div class="row">
            <?php if($images->count() > 0): ?>
            <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Image #<?php echo e($image->id); ?> - Position <?php echo e($image->position); ?>

                        <?php if($image->is_cover): ?>
                            <span class="badge bg-warning">★ Principale</span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <h6>Chemin BDD:</h6>
                        <code><?php echo e($image->image_path); ?></code>

                        <h6 class="mt-3">URL générée:</h6>
                        <code>/storage/<?php echo e($image->image_path); ?></code>

                        <h6 class="mt-3">URL complète:</h6>
                        <code><?php echo e(url('/storage/' . $image->image_path)); ?></code>

                        <h6 class="mt-3">Chemin physique:</h6>
                        <code><?php echo e(storage_path('app/public/' . $image->image_path)); ?></code>

                        <h6 class="mt-3">Fichier existe?</h6>
                        <?php if(file_exists(storage_path('app/public/' . $image->image_path))): ?>
                            <span class="badge bg-success"><i class="fas fa-check"></i> OUI</span>
                        <?php else: ?>
                            <span class="badge bg-danger"><i class="fas fa-times"></i> NON</span>
                        <?php endif; ?>

                        <hr>

                        <h6>Méthode 1: /storage/path</h6>
                        <img src="/storage/<?php echo e($image->image_path); ?>"
                             class="img-fluid mb-2"
                             style="max-height: 150px;"
                             onerror="this.parentElement.innerHTML += '<div class=\'alert alert-danger mt-2\'>❌ ERREUR Méthode 1</div>'">

                        <h6>Méthode 2: asset()</h6>
                        <img src="<?php echo e(asset('storage/' . $image->image_path)); ?>"
                             class="img-fluid mb-2"
                             style="max-height: 150px;"
                             onerror="this.parentElement.innerHTML += '<div class=\'alert alert-danger mt-2\'>❌ ERREUR Méthode 2</div>'">

                        <h6>Méthode 3: url()</h6>
                        <img src="<?php echo e(url('/storage/' . $image->image_path)); ?>"
                             class="img-fluid mb-2"
                             style="max-height: 150px;"
                             onerror="this.parentElement.innerHTML += '<div class=\'alert alert-danger mt-2\'>❌ ERREUR Méthode 3</div>'">

                        <hr>

                        <h6>Test accès direct (cliquez):</h6>
                        <a href="/storage/<?php echo e($image->image_path); ?>" target="_blank" class="btn btn-sm btn-primary">
                            <i class="fas fa-external-link-alt"></i> Ouvrir l'image
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> Aucune image trouvée pour ce produit.
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="mt-4">
            <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à l'édition
            </a>
        </div>
    </div>

    <script>
        console.log('Images loaded:', <?php echo e($images->count()); ?>);
        console.log('Product ID:', <?php echo e($product->id); ?>);
    </script>
</body>
</html>
<?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\products\test-images.blade.php ENDPATH**/ ?>