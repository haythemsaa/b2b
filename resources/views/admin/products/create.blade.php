@extends('layouts.admin')

@section('title', 'Créer un Produit')
@section('page-title', 'Créer un Nouveau Produit')

@push('styles')
<style>
    .nav-tabs .nav-link {
        color: #6c757d;
    }
    .nav-tabs .nav-link.active {
        color: #2c3e50;
        font-weight: 600;
    }
    .image-upload-zone {
        border: 2px dashed #ddd;
        border-radius: 10px;
        padding: 40px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        background: #f8f9fa;
    }
    .image-upload-zone:hover {
        border-color: #3498db;
        background: #e3f2fd;
    }
    .image-upload-zone.dragover {
        border-color: #27ae60;
        background: #d4edda;
    }
    .preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 20px;
    }
    .image-preview-item {
        position: relative;
        width: 150px;
        height: 150px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .image-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .image-preview-item .remove-image {
        position: absolute;
        top: 5px;
        right: 5px;
        background: #e74c3c;
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .image-preview-item:hover .remove-image {
        opacity: 1;
    }
    .image-preview-item .set-main {
        position: absolute;
        bottom: 5px;
        left: 5px;
        right: 5px;
        background: rgba(52, 152, 219, 0.9);
        color: white;
        border: none;
        padding: 5px;
        font-size: 12px;
        cursor: pointer;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .image-preview-item:hover .set-main {
        opacity: 1;
    }
    .image-preview-item.main-image {
        border: 3px solid #27ae60;
    }
    .image-preview-item.main-image::after {
        content: '★ Principale';
        position: absolute;
        top: 5px;
        left: 5px;
        background: #27ae60;
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: bold;
    }
    .sku-generator {
        cursor: pointer;
        color: #3498db;
        font-size: 12px;
    }
    .sku-generator:hover {
        text-decoration: underline;
    }
    .progress {
        height: 25px;
        margin-top: 10px;
    }
    .char-counter {
        font-size: 12px;
        color: #6c757d;
    }
    .char-counter.warning {
        color: #f39c12;
    }
    .char-counter.danger {
        color: #e74c3c;
    }
</style>
@endpush

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour à la liste
        </a>
    </div>
</div>

<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" id="productForm">
    @csrf

    <div class="row">
        <!-- Section principale -->
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-box-open me-2"></i>Nouveau Produit
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
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               id="name" name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="sku" class="form-label">SKU/Référence *</label>
                                        <input type="text" class="form-control @error('sku') is-invalid @enderror"
                                               id="sku" name="sku" value="{{ old('sku') }}" required>
                                        <small class="sku-generator" onclick="generateSKU()">
                                            <i class="fas fa-magic"></i> Générer automatiquement
                                        </small>
                                        @error('sku')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Catégorie *</label>
                                        <select class="form-select @error('category_id') is-invalid @enderror"
                                                id="category_id" name="category_id" required>
                                            <option value="">Sélectionner une catégorie</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}"
                                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ str_repeat('— ', $category->level ?? 0) }}{{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="brand" class="form-label">Marque</label>
                                        <input type="text" class="form-control" id="brand" name="brand"
                                               value="{{ old('brand') }}" list="brands-list">
                                        <datalist id="brands-list">
                                            <option value="Samsung">
                                            <option value="Apple">
                                            <option value="Sony">
                                            <option value="LG">
                                            <option value="Nike">
                                        </datalist>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="manufacturer" class="form-label">Fabricant</label>
                                        <input type="text" class="form-control" id="manufacturer" name="manufacturer"
                                               value="{{ old('manufacturer') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="short_description" class="form-label">Description courte</label>
                                <textarea class="form-control" id="short_description" name="short_description"
                                          rows="2" maxlength="255">{{ old('short_description') }}</textarea>
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">Résumé affiché dans les listes de produits</small>
                                    <small class="char-counter" data-target="short_description">0/255</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description complète</label>
                                <textarea class="form-control" id="description" name="description"
                                          rows="6">{{ old('description') }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="condition" class="form-label">État</label>
                                        <select class="form-select" id="condition" name="condition">
                                            <option value="new" selected>Neuf</option>
                                            <option value="used">Occasion</option>
                                            <option value="refurbished">Reconditionné</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="unit" class="form-label">Unité</label>
                                        <input type="text" class="form-control" id="unit" name="unit"
                                               value="{{ old('unit', 'pcs') }}" placeholder="pcs, kg, l...">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="position" class="form-label">Position (ordre d'affichage)</label>
                                        <input type="number" class="form-control" id="position" name="position"
                                               value="{{ old('position', 0) }}">
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
                                                   value="{{ old('base_price') }}">
                                            <span class="input-group-text">DT</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="tax_rate" class="form-label">TVA (%)</label>
                                        <input type="number" step="0.01" class="form-control"
                                               id="tax_rate" name="tax_rate"
                                               value="{{ old('tax_rate', 19) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Prix public (TTC) *</label>
                                        <div class="input-group">
                                            <input type="number" step="0.001" class="form-control @error('price') is-invalid @enderror"
                                                   id="price" name="price"
                                                   value="{{ old('price') }}" required>
                                            <span class="input-group-text">DT</span>
                                        </div>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                                   value="{{ old('wholesale_price') }}">
                                            <span class="input-group-text">DT</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Promotion</label>
                                        <div class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input" id="on_sale" name="on_sale"
                                                   role="switch" {{ old('on_sale') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="on_sale">
                                                Activer une promotion
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="sale-fields" style="display: none;">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="sale_price" class="form-label">Prix promotionnel</label>
                                        <div class="input-group">
                                            <input type="number" step="0.001" class="form-control"
                                                   id="sale_price" name="sale_price"
                                                   value="{{ old('sale_price') }}">
                                            <span class="input-group-text">DT</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="sale_start_date" class="form-label">Date début</label>
                                        <input type="date" class="form-control" id="sale_start_date" name="sale_start_date"
                                               value="{{ old('sale_start_date') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="sale_end_date" class="form-label">Date fin</label>
                                        <input type="date" class="form-control" id="sale_end_date" name="sale_end_date"
                                               value="{{ old('sale_end_date') }}">
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <h6 class="mb-3"><i class="fas fa-boxes me-2"></i>Gestion du stock</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="stock_quantity" class="form-label">Quantité en stock *</label>
                                        <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror"
                                               id="stock_quantity" name="stock_quantity"
                                               value="{{ old('stock_quantity', 0) }}" required>
                                        @error('stock_quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="min_quantity" class="form-label">Quantité minimum commande</label>
                                        <input type="number" class="form-control" id="min_quantity" name="min_quantity"
                                               value="{{ old('min_quantity', 1) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="low_stock_threshold" class="form-label">Seuil alerte stock</label>
                                        <input type="number" class="form-control" id="low_stock_threshold" name="low_stock_threshold"
                                               value="{{ old('low_stock_threshold', 5) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check form-switch mb-3">
                                        <input type="checkbox" class="form-check-input" id="available_for_order" name="available_for_order"
                                               role="switch" checked>
                                        <label class="form-check-label" for="available_for_order">
                                            Disponible à la commande
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="available_date" class="form-label">Date de disponibilité</label>
                                        <input type="date" class="form-control" id="available_date" name="available_date"
                                               value="{{ old('available_date') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Onglet Images -->
                        <div class="tab-pane fade" id="images" role="tabpanel">
                            <div class="mb-4">
                                <label class="form-label">Images du produit</label>
                                <div class="image-upload-zone" id="imageDropZone">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    <h5>Glissez-déposez vos images ici</h5>
                                    <p class="text-muted">ou cliquez pour sélectionner des fichiers</p>
                                    <input type="file" id="imageInput" name="images[]" multiple accept="image/*" style="display: none;">
                                    <button type="button" class="btn btn-primary mt-2" onclick="document.getElementById('imageInput').click()">
                                        <i class="fas fa-folder-open me-2"></i>Parcourir
                                    </button>
                                </div>
                                <small class="text-muted mt-2 d-block">
                                    Formats acceptés: JPG, PNG, GIF, WebP (Max: 5MB par image)
                                </small>
                            </div>

                            <div class="preview-container" id="imagePreviewContainer">
                                <!-- Les aperçus d'images seront ajoutés ici dynamiquement -->
                            </div>

                            <div id="uploadProgress" class="progress" style="display: none;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                     style="width: 0%">0%</div>
                            </div>

                            <hr class="my-4">

                            <div class="mb-3">
                                <label for="image_url" class="form-label">Image principale (URL)</label>
                                <input type="url" class="form-control" id="image_url" name="image_url"
                                       value="{{ old('image_url') }}"
                                       placeholder="https://exemple.com/image.jpg">
                                <small class="text-muted">Ou utilisez une URL d'image externe</small>
                            </div>

                            <div class="mb-3">
                                <label for="video_url" class="form-label">Vidéo YouTube/Vimeo (URL)</label>
                                <input type="url" class="form-control" id="video_url" name="video_url"
                                       value="{{ old('video_url') }}"
                                       placeholder="https://youtube.com/watch?v=...">
                            </div>
                        </div>

                        <!-- Onglet SEO -->
                        <div class="tab-pane fade" id="seo" role="tabpanel">
                            <div class="mb-3">
                                <label for="meta_title" class="form-label">Meta Titre</label>
                                <input type="text" class="form-control" id="meta_title" name="meta_title"
                                       value="{{ old('meta_title') }}"
                                       maxlength="70">
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">Recommandé: 50-60 caractères</small>
                                    <small class="char-counter" data-target="meta_title">0/70</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea class="form-control" id="meta_description" name="meta_description"
                                          rows="3" maxlength="160">{{ old('meta_description') }}</textarea>
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">Recommandé: 150-160 caractères</small>
                                    <small class="char-counter" data-target="meta_description">0/160</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="meta_keywords" class="form-label">Mots-clés</label>
                                <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                                       value="{{ old('meta_keywords') }}"
                                       placeholder="mot1, mot2, mot3">
                                <small class="text-muted">Séparez les mots-clés par des virgules</small>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ean13" class="form-label">EAN-13</label>
                                        <input type="text" class="form-control" id="ean13" name="ean13"
                                               value="{{ old('ean13') }}" maxlength="13" pattern="[0-9]{13}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="upc" class="form-label">UPC</label>
                                        <input type="text" class="form-control" id="upc" name="upc"
                                               value="{{ old('upc') }}" maxlength="12" pattern="[0-9]{12}">
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
                                               value="{{ old('weight') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="width" class="form-label">Largeur (cm)</label>
                                        <input type="number" step="0.01" class="form-control"
                                               id="width" name="width"
                                               value="{{ old('width') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="height" class="form-label">Hauteur (cm)</label>
                                        <input type="number" step="0.01" class="form-control"
                                               id="height" name="height"
                                               value="{{ old('height') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="depth" class="form-label">Profondeur (cm)</label>
                                        <input type="number" step="0.01" class="form-control"
                                               id="depth" name="depth"
                                               value="{{ old('depth') }}">
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check form-switch mb-3">
                                        <input type="checkbox" class="form-check-input" id="free_shipping" name="free_shipping"
                                               role="switch">
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
                                                   value="{{ old('additional_shipping_cost') }}">
                                            <span class="input-group-text">DT</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="delivery_time" class="form-label">Délai de livraison</label>
                                <input type="text" class="form-control" id="delivery_time" name="delivery_time"
                                       value="{{ old('delivery_time') }}"
                                       placeholder="2-3 jours ouvrables">
                            </div>
                        </div>

                        <!-- Onglet Avancé -->
                        <div class="tab-pane fade" id="advanced" role="tabpanel">
                            <div class="mb-3">
                                <label for="technical_specs" class="form-label">Spécifications techniques (JSON)</label>
                                <textarea class="form-control font-monospace" id="technical_specs" name="technical_specs"
                                          rows="6">{{ old('technical_specs') }}</textarea>
                                <small class="text-muted">Format: {"spec1": "valeur1", "spec2": "valeur2"}</small>
                            </div>

                            <div class="mb-3">
                                <label for="features" class="form-label">Caractéristiques</label>
                                <textarea class="form-control" id="features" name="features"
                                          rows="4">{{ old('features') }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check form-switch mb-3">
                                        <input type="checkbox" class="form-check-input" id="featured" name="featured" role="switch">
                                        <label class="form-check-label" for="featured">
                                            <i class="fas fa-star me-1"></i>Produit mis en avant
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch mb-3">
                                        <input type="checkbox" class="form-check-input" id="new_arrival" name="new_arrival" role="switch">
                                        <label class="form-check-label" for="new_arrival">
                                            <i class="fas fa-certificate me-1"></i>Nouveauté
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check form-switch mb-3">
                                        <input type="checkbox" class="form-check-input" id="show_price" name="show_price"
                                               role="switch" checked>
                                        <label class="form-check-label" for="show_price">
                                            Afficher le prix
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch mb-3">
                                        <input type="checkbox" class="form-check-input" id="customizable" name="customizable" role="switch">
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
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active"
                               role="switch" checked>
                        <label class="form-check-label" for="is_active">
                            <strong>Produit actif</strong>
                        </label>
                    </div>
                    <small class="text-muted">
                        Le produit sera visible sur le site une fois activé
                    </small>
                </div>
            </div>

            <!-- Actions -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-bolt me-2"></i>Actions
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Créer le produit
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="saveDraft()">
                            <i class="fas fa-file me-2"></i>Enregistrer brouillon
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-danger">
                            <i class="fas fa-times me-2"></i>Annuler
                        </a>
                    </div>
                </div>
            </div>

            <!-- Aide -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-question-circle me-2"></i>Aide
                </div>
                <div class="card-body">
                    <small class="text-muted">
                        <ul class="mb-0 ps-3">
                            <li>Les champs marqués * sont obligatoires</li>
                            <li>Le SKU doit être unique</li>
                            <li>Vous pouvez ajouter plusieurs images</li>
                            <li>La première image devient l'image principale</li>
                        </ul>
                    </small>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
// Génération automatique du SKU
function generateSKU() {
    const name = document.getElementById('name').value;
    if (!name) {
        alert('Veuillez d\'abord entrer un nom de produit');
        return;
    }
    const sku = name.substring(0, 3).toUpperCase() + '-' + Math.random().toString(36).substring(2, 8).toUpperCase();
    document.getElementById('sku').value = sku;
}

// Auto-generate SKU from product name
document.getElementById('name').addEventListener('blur', function() {
    const skuField = document.getElementById('sku');
    if (!skuField.value) {
        generateSKU();
    }
});

// Toggle promotion fields
document.getElementById('on_sale').addEventListener('change', function() {
    document.getElementById('sale-fields').style.display = this.checked ? 'flex' : 'none';
});

// Character counters
document.querySelectorAll('.char-counter').forEach(counter => {
    const targetId = counter.dataset.target;
    const target = document.getElementById(targetId);
    if (target) {
        target.addEventListener('input', function() {
            const maxLength = this.maxLength || 999;
            const currentLength = this.value.length;
            counter.textContent = currentLength + '/' + maxLength;

            counter.classList.remove('warning', 'danger');
            if (currentLength > maxLength * 0.8) {
                counter.classList.add('warning');
            }
            if (currentLength >= maxLength) {
                counter.classList.add('danger');
            }
        });
    }
});

// Gestion du Drag & Drop pour les images
const dropZone = document.getElementById('imageDropZone');
const imageInput = document.getElementById('imageInput');
const previewContainer = document.getElementById('imagePreviewContainer');
let selectedImages = [];

dropZone.addEventListener('click', () => imageInput.click());

dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('dragover');
});

dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('dragover');
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('dragover');
    handleFiles(e.dataTransfer.files);
});

imageInput.addEventListener('change', (e) => {
    handleFiles(e.target.files);
});

function handleFiles(files) {
    Array.from(files).forEach(file => {
        if (file.type.startsWith('image/')) {
            if (file.size > 5 * 1024 * 1024) {
                alert(`L'image ${file.name} est trop grande (max 5MB)`);
                return;
            }
            selectedImages.push(file);
            previewImage(file);
        }
    });
}

function previewImage(file) {
    const reader = new FileReader();
    reader.onload = (e) => {
        const div = document.createElement('div');
        div.className = 'image-preview-item' + (selectedImages.length === 1 ? ' main-image' : '');
        div.innerHTML = `
            <img src="${e.target.result}" alt="Preview">
            <button type="button" class="remove-image" onclick="removeImage(this, '${file.name}')">
                <i class="fas fa-times"></i>
            </button>
            ${selectedImages.length > 1 ? `<button type="button" class="set-main" onclick="setMainImage(this)">Définir comme principale</button>` : ''}
        `;
        previewContainer.appendChild(div);
    };
    reader.readAsDataURL(file);
}

function removeImage(button, fileName) {
    selectedImages = selectedImages.filter(f => f.name !== fileName);
    button.closest('.image-preview-item').remove();
}

function setMainImage(button) {
    document.querySelectorAll('.image-preview-item').forEach(item => {
        item.classList.remove('main-image');
    });
    button.closest('.image-preview-item').classList.add('main-image');
}

// Sauvegarde brouillon
function saveDraft() {
    const formData = new FormData(document.getElementById('productForm'));
    formData.append('is_draft', '1');

    // TODO: Implémenter la sauvegarde en brouillon
    alert('Fonctionnalité de brouillon à venir');
}

// Calcul automatique du prix TTC
document.getElementById('base_price').addEventListener('input', calculatePriceTTC);
document.getElementById('tax_rate').addEventListener('input', calculatePriceTTC);

function calculatePriceTTC() {
    const basePrice = parseFloat(document.getElementById('base_price').value) || 0;
    const taxRate = parseFloat(document.getElementById('tax_rate').value) || 0;
    const priceTTC = basePrice * (1 + taxRate / 100);
    document.getElementById('price').value = priceTTC.toFixed(3);
}
</script>
@endpush
@endsection
