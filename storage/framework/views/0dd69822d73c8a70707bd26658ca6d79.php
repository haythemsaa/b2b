<?php $__env->startSection('title', 'Modifier le Produit'); ?>
<?php $__env->startSection('page-title', 'Modifier le Produit'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .nav-tabs .nav-link {
        color: #495057 !important;
        font-size: 14px;
        font-weight: 500;
        padding: 10px 20px;
    }
    .nav-tabs .nav-link:hover {
        color: #0d6efd !important;
    }
    .nav-tabs .nav-link.active {
        color: #0d6efd !important;
        font-weight: 600;
        background-color: #fff;
        border-color: #dee2e6 #dee2e6 #fff;
    }
    .image-preview {
        max-width: 200px;
        max-height: 200px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .image-item {
        position: relative;
        display: inline-block;
        margin: 10px;
    }
    .image-remove {
        position: absolute;
        top: -10px;
        right: -10px;
        background: #e74c3c;
        color: white;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 2px solid white;
    }
    .badge-cover {
        position: absolute;
        top: 5px;
        left: 5px;
        background: #27ae60;
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 11px;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour à la liste
        </a>
    </div>
</div>

<form method="POST" action="<?php echo e(route('admin.products.update', $product)); ?>" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="row">
        <!-- Section principale -->
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-box me-2"></i><?php echo e($product->name); ?>

                </div>
                <div class="card-body">
                    <!-- Navigation à onglets -->
                    <ul class="nav nav-tabs mb-4" id="productTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="general-tab" data-bs-toggle="tab"
                                    data-bs-target="#general" type="button" role="tab">
                                <i class="fas fa-info-circle me-1"></i>Général
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pricing-tab" data-bs-toggle="tab"
                                    data-bs-target="#pricing" type="button" role="tab">
                                <i class="fas fa-dollar-sign me-1"></i>Prix & Stock
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="images-tab" data-bs-toggle="tab"
                                    data-bs-target="#images" type="button" role="tab">
                                <i class="fas fa-images me-1"></i>Images
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="seo-tab" data-bs-toggle="tab"
                                    data-bs-target="#seo" type="button" role="tab">
                                <i class="fas fa-search me-1"></i>SEO
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="shipping-tab" data-bs-toggle="tab"
                                    data-bs-target="#shipping" type="button" role="tab">
                                <i class="fas fa-truck me-1"></i>Livraison
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="advanced-tab" data-bs-toggle="tab"
                                    data-bs-target="#advanced" type="button" role="tab">
                                <i class="fas fa-cogs me-1"></i>Avancé
                            </button>
                        </li>
                    </ul>

                    <!-- Contenu des onglets -->
                    <div class="tab-content" id="productTabsContent">
                        <!-- Onglet Général -->
                        <div class="tab-pane fade show active" id="general" role="tabpanel">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nom du produit *</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="name" name="name" value="<?php echo e(old('name', $product->name)); ?>" required>
                                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="sku" class="form-label">SKU/Référence *</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['sku'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="sku" name="sku" value="<?php echo e(old('sku', $product->sku)); ?>" required>
                                        <?php $__errorArgs = ['sku'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Catégorie *</label>
                                        <select class="form-select <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                id="category_id" name="category_id" required>
                                            <option value="">Sélectionner une catégorie</option>
                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($category->id); ?>"
                                                        <?php echo e(old('category_id', $product->category_id) == $category->id ? 'selected' : ''); ?>>
                                                    <?php echo e(str_repeat('— ', $category->level ?? 0)); ?><?php echo e($category->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="brand" class="form-label">Marque</label>
                                        <input type="text" class="form-control" id="brand" name="brand"
                                               value="<?php echo e(old('brand', $product->brand)); ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="manufacturer" class="form-label">Fabricant</label>
                                        <input type="text" class="form-control" id="manufacturer" name="manufacturer"
                                               value="<?php echo e(old('manufacturer', $product->manufacturer)); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="short_description" class="form-label">Description courte</label>
                                <textarea class="form-control" id="short_description" name="short_description"
                                          rows="2"><?php echo e(old('short_description', $product->short_description)); ?></textarea>
                                <small class="text-muted">Résumé affiché dans les listes de produits</small>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description complète</label>
                                <textarea class="form-control" id="description" name="description"
                                          rows="6"><?php echo e(old('description', $product->description)); ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="condition" class="form-label">État</label>
                                        <select class="form-select" id="condition" name="condition">
                                            <option value="new" <?php echo e(old('condition', $product->condition) == 'new' ? 'selected' : ''); ?>>Neuf</option>
                                            <option value="used" <?php echo e(old('condition', $product->condition) == 'used' ? 'selected' : ''); ?>>Occasion</option>
                                            <option value="refurbished" <?php echo e(old('condition', $product->condition) == 'refurbished' ? 'selected' : ''); ?>>Reconditionné</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="unit" class="form-label">Unité</label>
                                        <input type="text" class="form-control" id="unit" name="unit"
                                               value="<?php echo e(old('unit', $product->unit)); ?>" placeholder="pcs, kg, l...">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="position" class="form-label">Position</label>
                                        <input type="number" class="form-control" id="position" name="position"
                                               value="<?php echo e(old('position', $product->position ?? 0)); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Onglet Prix & Stock -->
                        <div class="tab-pane fade" id="pricing" role="tabpanel">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="base_price" class="form-label">Prix de base (HT)</label>
                                        <div class="input-group">
                                            <input type="number" step="0.001" class="form-control"
                                                   id="base_price" name="base_price"
                                                   value="<?php echo e(old('base_price', $product->base_price)); ?>">
                                            <span class="input-group-text">DT</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="tax_rate" class="form-label">TVA (%)</label>
                                        <input type="number" step="0.01" class="form-control"
                                               id="tax_rate" name="tax_rate"
                                               value="<?php echo e(old('tax_rate', $product->tax_rate ?? 19)); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Prix public (TTC) *</label>
                                        <div class="input-group">
                                            <input type="number" step="0.001" class="form-control <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                   id="price" name="price"
                                                   value="<?php echo e(old('price', $product->price)); ?>" required>
                                            <span class="input-group-text">DT</span>
                                        </div>
                                        <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="wholesale_price" class="form-label">Prix de gros</label>
                                        <div class="input-group">
                                            <input type="number" step="0.001" class="form-control"
                                                   id="wholesale_price" name="wholesale_price"
                                                   value="<?php echo e(old('wholesale_price', $product->wholesale_price)); ?>">
                                            <span class="input-group-text">DT</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Promotion</label>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="on_sale" name="on_sale"
                                                   <?php echo e(old('on_sale', $product->on_sale) ? 'checked' : ''); ?>>
                                            <label class="form-check-label" for="on_sale">
                                                Produit en promotion
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="sale-fields" style="display: <?php echo e(old('on_sale', $product->on_sale) ? 'flex' : 'none'); ?>;">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="sale_price" class="form-label">Prix promotionnel</label>
                                        <div class="input-group">
                                            <input type="number" step="0.001" class="form-control"
                                                   id="sale_price" name="sale_price"
                                                   value="<?php echo e(old('sale_price', $product->sale_price)); ?>">
                                            <span class="input-group-text">DT</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="sale_start_date" class="form-label">Date début</label>
                                        <input type="date" class="form-control" id="sale_start_date" name="sale_start_date"
                                               value="<?php echo e(old('sale_start_date', $product->sale_start_date)); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="sale_end_date" class="form-label">Date fin</label>
                                        <input type="date" class="form-control" id="sale_end_date" name="sale_end_date"
                                               value="<?php echo e(old('sale_end_date', $product->sale_end_date)); ?>">
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <h6 class="mb-3"><i class="fas fa-boxes me-2"></i>Gestion du stock</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="stock_quantity" class="form-label">Quantité en stock *</label>
                                        <input type="number" class="form-control <?php $__errorArgs = ['stock_quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="stock_quantity" name="stock_quantity"
                                               value="<?php echo e(old('stock_quantity', $product->stock_quantity)); ?>" required>
                                        <?php $__errorArgs = ['stock_quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="min_quantity" class="form-label">Quantité minimum</label>
                                        <input type="number" class="form-control" id="min_quantity" name="min_quantity"
                                               value="<?php echo e(old('min_quantity', $product->min_quantity ?? 1)); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="low_stock_threshold" class="form-label">Seuil alerte stock</label>
                                        <input type="number" class="form-control" id="low_stock_threshold" name="low_stock_threshold"
                                               value="<?php echo e(old('low_stock_threshold', $product->low_stock_threshold)); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input type="checkbox" class="form-check-input" id="available_for_order" name="available_for_order"
                                               <?php echo e(old('available_for_order', $product->available_for_order ?? true) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="available_for_order">
                                            Disponible à la commande
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="available_date" class="form-label">Date de disponibilité</label>
                                        <input type="date" class="form-control" id="available_date" name="available_date"
                                               value="<?php echo e(old('available_date', $product->available_date)); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Onglet Images -->
                        <div class="tab-pane fade" id="images" role="tabpanel">
                            <?php if($productImages->count() > 0): ?>
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-label mb-0">
                                        <i class="fas fa-images me-2 text-primary"></i>
                                        <strong>Galerie d'images (<?php echo e($productImages->count()); ?>)</strong>
                                    </label>
                                    <span class="badge bg-info">Cliquez sur une image pour l'ouvrir</span>
                                </div>
                                <div class="row g-3" id="images-gallery">
                                    <?php $__currentLoopData = $productImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-3" id="image-<?php echo e($image->id); ?>">
                                        <div class="card shadow-sm h-100 image-card">
                                            <div class="position-relative image-wrapper">
                                                <img src="/storage/<?php echo e($image->image_path); ?>"
                                                     alt="<?php echo e($product->name); ?>"
                                                     class="card-img-top product-image"
                                                     style="height: 200px; object-fit: cover; cursor: pointer;"
                                                     onclick="window.open(this.src, '_blank')"
                                                     onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'alert alert-danger m-2 text-center\' style=\'height:200px;display:flex;align-items:center;justify-content:center;flex-direction:column;\'><i class=\'fas fa-exclamation-triangle fa-2x mb-2\'></i><div>Image non trouvée</div><small class=\'text-muted\'><?php echo e($image->image_path); ?></small></div>'">

                                                <!-- Overlay pour les actions -->
                                                <div class="image-overlay">
                                                    <?php if($image->is_cover): ?>
                                                        <span class="badge bg-success position-absolute top-0 start-0 m-2">
                                                            <i class="fas fa-star me-1"></i>Image Principale
                                                        </span>
                                                    <?php endif; ?>

                                                    <button type="button"
                                                            class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2"
                                                            onclick="deleteImage('<?php echo e($product->sku); ?>', <?php echo e($image->id); ?>)"
                                                            title="Supprimer cette image">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body p-2">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted">
                                                        <i class="fas fa-sort me-1"></i>Position: <?php echo e($image->position); ?>

                                                    </small>
                                                    <?php if(!$image->is_cover): ?>
                                                    <form method="POST" action="<?php echo e(route('admin.products.set-cover', ['product' => $product, 'image' => $image])); ?>" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="btn btn-sm btn-primary" title="Définir comme image principale">
                                                            <i class="fas fa-star me-1"></i>Principale
                                                        </button>
                                                    </form>
                                                    <?php else: ?>
                                                    <span class="badge bg-success">Principale</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <hr class="my-4">
                            <?php else: ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Aucune image pour ce produit.</strong> Ajoutez-en ci-dessous.
                            </div>
                            <?php endif; ?>

                            <div class="mb-3">
                                <label class="form-label">Ajouter de nouvelles images</label>
                                <input type="file" class="form-control" name="images[]" multiple accept="image/*">
                                <small class="text-muted">Formats: JPG, PNG, GIF, WebP (Max: 5MB par image)</small>
                            </div>

                            <hr class="my-4">

                            <div class="mb-3">
                                <label for="image_url" class="form-label">Image principale (URL externe)</label>
                                <input type="url" class="form-control" id="image_url" name="image_url"
                                       value="<?php echo e(old('image_url', $product->image_url)); ?>"
                                       placeholder="https://exemple.com/image.jpg">
                            </div>

                            <div class="mb-3">
                                <label for="video_url" class="form-label">Vidéo YouTube/Vimeo (URL)</label>
                                <input type="url" class="form-control" id="video_url" name="video_url"
                                       value="<?php echo e(old('video_url', $product->video_url)); ?>"
                                       placeholder="https://youtube.com/watch?v=...">
                            </div>
                        </div>

                        <!-- Onglet SEO -->
                        <div class="tab-pane fade" id="seo" role="tabpanel">
                            <div class="mb-3">
                                <label for="meta_title" class="form-label">Meta Titre</label>
                                <input type="text" class="form-control" id="meta_title" name="meta_title"
                                       value="<?php echo e(old('meta_title', $product->meta_title)); ?>"
                                       maxlength="70">
                                <small class="text-muted">Recommandé: 50-60 caractères</small>
                            </div>

                            <div class="mb-3">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea class="form-control" id="meta_description" name="meta_description"
                                          rows="3" maxlength="160"><?php echo e(old('meta_description', $product->meta_description)); ?></textarea>
                                <small class="text-muted">Recommandé: 150-160 caractères</small>
                            </div>

                            <div class="mb-3">
                                <label for="meta_keywords" class="form-label">Mots-clés</label>
                                <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                                       value="<?php echo e(old('meta_keywords', $product->meta_keywords)); ?>"
                                       placeholder="mot1, mot2, mot3">
                                <small class="text-muted">Séparez les mots-clés par des virgules</small>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ean13" class="form-label">EAN-13</label>
                                        <input type="text" class="form-control" id="ean13" name="ean13"
                                               value="<?php echo e(old('ean13', $product->ean13)); ?>" maxlength="13">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="upc" class="form-label">UPC</label>
                                        <input type="text" class="form-control" id="upc" name="upc"
                                               value="<?php echo e(old('upc', $product->upc)); ?>" maxlength="12">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Onglet Livraison -->
                        <div class="tab-pane fade" id="shipping" role="tabpanel">
                            <h6 class="mb-3"><i class="fas fa-box me-2"></i>Dimensions</h6>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="weight" class="form-label">Poids (kg)</label>
                                        <input type="number" step="0.001" class="form-control"
                                               id="weight" name="weight"
                                               value="<?php echo e(old('weight', $product->weight)); ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="width" class="form-label">Largeur (cm)</label>
                                        <input type="number" step="0.01" class="form-control"
                                               id="width" name="width"
                                               value="<?php echo e(old('width', $product->width)); ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="height" class="form-label">Hauteur (cm)</label>
                                        <input type="number" step="0.01" class="form-control"
                                               id="height" name="height"
                                               value="<?php echo e(old('height', $product->height)); ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="depth" class="form-label">Profondeur (cm)</label>
                                        <input type="number" step="0.01" class="form-control"
                                               id="depth" name="depth"
                                               value="<?php echo e(old('depth', $product->depth)); ?>">
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input type="checkbox" class="form-check-input" id="free_shipping" name="free_shipping"
                                               <?php echo e(old('free_shipping', $product->free_shipping) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="free_shipping">
                                            <i class="fas fa-shipping-fast me-1"></i>Livraison gratuite
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="additional_shipping_cost" class="form-label">Coût livraison additionnel</label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" class="form-control"
                                                   id="additional_shipping_cost" name="additional_shipping_cost"
                                                   value="<?php echo e(old('additional_shipping_cost', $product->additional_shipping_cost)); ?>">
                                            <span class="input-group-text">DT</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="delivery_time" class="form-label">Délai de livraison</label>
                                <input type="text" class="form-control" id="delivery_time" name="delivery_time"
                                       value="<?php echo e(old('delivery_time', $product->delivery_time)); ?>"
                                       placeholder="2-3 jours ouvrables">
                            </div>
                        </div>

                        <!-- Onglet Avancé -->
                        <div class="tab-pane fade" id="advanced" role="tabpanel">
                            <div class="mb-3">
                                <label for="technical_specs" class="form-label">Spécifications techniques (JSON)</label>
                                <textarea class="form-control font-monospace" id="technical_specs" name="technical_specs"
                                          rows="6"><?php echo e(old('technical_specs', $product->technical_specs)); ?></textarea>
                                <small class="text-muted">Format: {"spec1": "valeur1", "spec2": "valeur2"}</small>
                            </div>

                            <div class="mb-3">
                                <label for="features" class="form-label">Caractéristiques</label>
                                <textarea class="form-control" id="features" name="features"
                                          rows="4"><?php echo e(old('features', $product->features)); ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input type="checkbox" class="form-check-input" id="featured" name="featured"
                                               <?php echo e(old('featured', $product->featured) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="featured">
                                            <i class="fas fa-star me-1"></i>Produit mis en avant
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input type="checkbox" class="form-check-input" id="new_arrival" name="new_arrival"
                                               <?php echo e(old('new_arrival', $product->new_arrival) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="new_arrival">
                                            <i class="fas fa-certificate me-1"></i>Nouveauté
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input type="checkbox" class="form-check-input" id="show_price" name="show_price"
                                               <?php echo e(old('show_price', $product->show_price ?? true) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="show_price">
                                            Afficher le prix
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input type="checkbox" class="form-check-input" id="customizable" name="customizable"
                                               <?php echo e(old('customizable', $product->customizable) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="customizable">
                                            Produit personnalisable
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne latérale -->
        <div class="col-lg-3">
            <!-- Statut du produit -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-toggle-on me-2"></i>Statut
                </div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" role="switch"
                               <?php echo e(old('is_active', $product->is_active) ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="is_active">
                            <strong>Actif</strong>
                        </label>
                    </div>
                    <hr>
                    <div class="text-muted small">
                        <div class="mb-2">
                            <i class="fas fa-calendar me-1"></i>
                            <strong>Créé:</strong><br>
                            <?php echo e($product->created_at->format('d/m/Y H:i')); ?>

                        </div>
                        <div>
                            <i class="fas fa-edit me-1"></i>
                            <strong>Modifié:</strong><br>
                            <?php echo e($product->updated_at->format('d/m/Y H:i')); ?>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-bolt me-2"></i>Actions rapides
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Enregistrer
                        </button>
                        <a href="<?php echo e(route('products.show', $product->sku)); ?>" class="btn btn-outline-info" target="_blank">
                            <i class="fas fa-eye me-2"></i>Voir le produit
                        </a>
                        <a href="<?php echo e(route('admin.custom-prices.create')); ?>?product_id=<?php echo e($product->id); ?>" class="btn btn-outline-warning">
                            <i class="fas fa-tags me-2"></i>Prix personnalisés
                        </a>
                    </div>
                </div>
            </div>

            <!-- Informations -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle me-2"></i>Informations
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted">ID Produit:</small>
                        <div><strong>#<?php echo e($product->id); ?></strong></div>
                    </div>
                    <?php if($product->customPrices && $product->customPrices->count() > 0): ?>
                    <div class="mb-2">
                        <small class="text-muted">Prix personnalisés:</small>
                        <div><span class="badge bg-success"><?php echo e($product->customPrices->count()); ?></span></div>
                    </div>
                    <?php endif; ?>
                    <div>
                        <small class="text-muted">Catégorie:</small>
                        <div><?php echo e($product->category->name ?? 'N/A'); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php $__env->startPush('scripts'); ?>
<script>
    // Toggle promotion fields
    document.getElementById('on_sale').addEventListener('change', function() {
        document.getElementById('sale-fields').style.display = this.checked ? 'flex' : 'none';
    });

    // Delete image function with AJAX
    function deleteImage(productId, imageId) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer cette image ?')) {
            return;
        }

        const imageCard = document.getElementById(`image-${imageId}`);

        // Ajouter un effet de chargement
        if (imageCard) {
            imageCard.style.opacity = '0.5';
            imageCard.style.pointerEvents = 'none';
        }

        // Envoyer la requête AJAX
        fetch(`/admin/products/${productId}/images/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Animation de suppression
                if (imageCard) {
                    imageCard.style.transition = 'all 0.3s ease';
                    imageCard.style.transform = 'scale(0)';
                    imageCard.style.opacity = '0';

                    setTimeout(() => {
                        imageCard.remove();

                        // Vérifier s'il reste des images
                        const gallery = document.getElementById('images-gallery');
                        if (gallery && gallery.children.length === 0) {
                            location.reload(); // Recharger pour afficher le message "Aucune image"
                        }
                    }, 300);
                }

                // Afficher un message de succès
                showNotification('Image supprimée avec succès', 'success');
            } else {
                // Restaurer l'opacité en cas d'erreur
                if (imageCard) {
                    imageCard.style.opacity = '1';
                    imageCard.style.pointerEvents = 'auto';
                }
                showNotification(data.message || 'Erreur lors de la suppression', 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            if (imageCard) {
                imageCard.style.opacity = '1';
                imageCard.style.pointerEvents = 'auto';
            }
            showNotification('Erreur lors de la suppression de l\'image', 'error');
        });
    }

    // Fonction pour afficher les notifications
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(notification);

        // Auto-suppression après 3 secondes
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 150);
        }, 3000);
    }

    // Preview images before upload
    document.querySelector('input[name="images[]"]')?.addEventListener('change', function(e) {
        const files = e.target.files;
        if (files.length > 0) {
            let preview = document.getElementById('new-images-preview');
            if (!preview) {
                preview = document.createElement('div');
                preview.id = 'new-images-preview';
                preview.className = 'row g-3 mt-2';
                e.target.parentElement.appendChild(preview);
            }
            preview.innerHTML = '';

            Array.from(files).forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-md-3';
                        col.innerHTML = `
                            <div class="card">
                                <img src="${e.target.result}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                <div class="card-body p-2">
                                    <small class="text-muted">${file.name}</small>
                                </div>
                            </div>
                        `;
                        preview.appendChild(col);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\products\edit.blade.php ENDPATH**/ ?>