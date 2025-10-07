<!DOCTYPE html>
<html>
<head>
    <title>Test - Product Edit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
    <div class="container">
        <h1>Test de la page d'édition produit</h1>

        <div class="alert alert-info">
            <h4>Informations de session :</h4>
            <ul>
                <li><strong>Utilisateur connecté :</strong> <?php echo e(auth()->check() ? auth()->user()->name : 'Non connecté'); ?></li>
                <li><strong>Rôle :</strong> <?php echo e(auth()->check() ? auth()->user()->role : 'N/A'); ?></li>
                <li><strong>Email :</strong> <?php echo e(auth()->check() ? auth()->user()->email : 'N/A'); ?></li>
            </ul>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h3>Onglets de test</h3>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs mb-4" id="testTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab1" data-bs-toggle="tab"
                                data-bs-target="#content1" type="button">
                            Onglet 1
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab2" data-bs-toggle="tab"
                                data-bs-target="#content2" type="button">
                            Onglet 2 - Images
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab3" data-bs-toggle="tab"
                                data-bs-target="#content3" type="button">
                            Onglet 3
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="content1">
                        <h4>Contenu onglet 1</h4>
                        <p>Si vous voyez ceci, l'onglet 1 fonctionne.</p>
                    </div>
                    <div class="tab-pane fade" id="content2">
                        <h4>Contenu onglet 2 - Upload Image</h4>
                        <div class="mb-3">
                            <label class="form-label">Test upload d'images</label>
                            <input type="file" class="form-control" multiple accept="image/*">
                        </div>
                    </div>
                    <div class="tab-pane fade" id="content3">
                        <h4>Contenu onglet 3</h4>
                        <p>Si vous voyez ceci, l'onglet 3 fonctionne.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="<?php echo e(route('admin.products.edit', 'RIZ-BAS-1KG')); ?>" class="btn btn-primary">
                Aller vers la vraie page d'édition
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\products\test.blade.php ENDPATH**/ ?>