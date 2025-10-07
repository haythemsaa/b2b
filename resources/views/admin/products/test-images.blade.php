<!DOCTYPE html>
<html>
<head>
    <title>Test Images - Produit #{{ $product->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>🔍 Test d'affichage des images - {{ $product->name }}</h1>

        <div class="alert alert-info">
            <strong>Informations du serveur:</strong><br>
            URL de base: {{ url('/') }}<br>
            Storage URL: {{ url('/storage') }}<br>
            Nombre d'images: {{ $images->count() }}
        </div>

        <div class="row">
            @if($images->count() > 0)
            @foreach($images as $image)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Image #{{ $image->id }} - Position {{ $image->position }}
                        @if($image->is_cover)
                            <span class="badge bg-warning">★ Principale</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <h6>Chemin BDD:</h6>
                        <code>{{ $image->image_path }}</code>

                        <h6 class="mt-3">URL générée:</h6>
                        <code>/storage/{{ $image->image_path }}</code>

                        <h6 class="mt-3">URL complète:</h6>
                        <code>{{ url('/storage/' . $image->image_path) }}</code>

                        <h6 class="mt-3">Chemin physique:</h6>
                        <code>{{ storage_path('app/public/' . $image->image_path) }}</code>

                        <h6 class="mt-3">Fichier existe?</h6>
                        @if(file_exists(storage_path('app/public/' . $image->image_path)))
                            <span class="badge bg-success"><i class="fas fa-check"></i> OUI</span>
                        @else
                            <span class="badge bg-danger"><i class="fas fa-times"></i> NON</span>
                        @endif

                        <hr>

                        <h6>Méthode 1: /storage/path</h6>
                        <img src="/storage/{{ $image->image_path }}"
                             class="img-fluid mb-2"
                             style="max-height: 150px;"
                             onerror="this.parentElement.innerHTML += '<div class=\'alert alert-danger mt-2\'>❌ ERREUR Méthode 1</div>'">

                        <h6>Méthode 2: asset()</h6>
                        <img src="{{ asset('storage/' . $image->image_path) }}"
                             class="img-fluid mb-2"
                             style="max-height: 150px;"
                             onerror="this.parentElement.innerHTML += '<div class=\'alert alert-danger mt-2\'>❌ ERREUR Méthode 2</div>'">

                        <h6>Méthode 3: url()</h6>
                        <img src="{{ url('/storage/' . $image->image_path) }}"
                             class="img-fluid mb-2"
                             style="max-height: 150px;"
                             onerror="this.parentElement.innerHTML += '<div class=\'alert alert-danger mt-2\'>❌ ERREUR Méthode 3</div>'">

                        <hr>

                        <h6>Test accès direct (cliquez):</h6>
                        <a href="/storage/{{ $image->image_path }}" target="_blank" class="btn btn-sm btn-primary">
                            <i class="fas fa-external-link-alt"></i> Ouvrir l'image
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="col-12">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> Aucune image trouvée pour ce produit.
                </div>
            </div>
            @endif
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à l'édition
            </a>
        </div>
    </div>

    <script>
        console.log('Images loaded:', {{ $images->count() }});
        console.log('Product ID:', {{ $product->id }});
    </script>
</body>
</html>
