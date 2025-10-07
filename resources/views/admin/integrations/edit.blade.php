@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-edit"></i> Modifier l'intégration
            </h1>
            <p class="text-muted">{{ $integration->name }}</p>
        </div>
        <div>
            <a href="{{ route('admin.integrations.show', $integration) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <!-- Formulaire -->
    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('admin.integrations.update', $integration) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informations Générales</h5>
                    </div>
                    <div class="card-body">
                        <!-- Nom -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom de l'intégration <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $integration->name) }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Type (non modifiable) -->
                        <div class="mb-3">
                            <label class="form-label">Type de système</label>
                            <input type="text" class="form-control" value="{{ ucfirst(str_replace('_', ' ', $integration->type)) }}" disabled>
                            <small class="text-muted">Le type ne peut pas être modifié après création</small>
                        </div>

                        <!-- Statut -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Statut <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="testing" {{ old('status', $integration->status) == 'testing' ? 'selected' : '' }}>Test</option>
                                <option value="inactive" {{ old('status', $integration->status) == 'inactive' ? 'selected' : '' }}>Inactif</option>
                                <option value="active" {{ old('status', $integration->status) == 'active' ? 'selected' : '' }}>Actif</option>
                                <option value="error" {{ old('status', $integration->status) == 'error' ? 'selected' : '' }}>Erreur</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Configuration de Connexion -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-key"></i> Identifiants de Connexion</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-shield-alt"></i> Les identifiants sont chiffrés. Laissez vide pour conserver les valeurs actuelles.
                        </div>

                        @php
                            $credentials = $integration->credentials ?? [];
                        @endphp

                        <!-- API URL -->
                        <div class="mb-3">
                            <label for="api_url" class="form-label">URL de l'API</label>
                            <input type="url"
                                   class="form-control"
                                   id="api_url"
                                   name="credentials[api_url]"
                                   value="{{ old('credentials.api_url', $credentials['api_url'] ?? '') }}"
                                   placeholder="https://api.exemple.com">
                        </div>

                        <!-- API Key -->
                        <div class="mb-3">
                            <label for="api_key" class="form-label">Clé API</label>
                            <input type="text"
                                   class="form-control"
                                   id="api_key"
                                   name="credentials[api_key]"
                                   value="{{ old('credentials.api_key', $credentials['api_key'] ?? '') }}"
                                   placeholder="{{ isset($credentials['api_key']) ? '••••••••' : 'Entrez votre clé API' }}">
                            @if(isset($credentials['api_key']))
                                <small class="text-success"><i class="fas fa-check"></i> Clé configurée</small>
                            @endif
                        </div>

                        <!-- API Secret -->
                        <div class="mb-3">
                            <label for="api_secret" class="form-label">Secret API</label>
                            <input type="password"
                                   class="form-control"
                                   id="api_secret"
                                   name="credentials[api_secret]"
                                   placeholder="{{ isset($credentials['api_secret']) ? '•••••••• (laissez vide pour garder actuel)' : 'Entrez le secret' }}">
                            @if(isset($credentials['api_secret']))
                                <small class="text-success"><i class="fas fa-check"></i> Secret configuré</small>
                            @endif
                        </div>

                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Nom d'utilisateur</label>
                            <input type="text"
                                   class="form-control"
                                   id="username"
                                   name="credentials[username]"
                                   value="{{ old('credentials.username', $credentials['username'] ?? '') }}">
                            @if(isset($credentials['username']))
                                <small class="text-muted">Utilisateur actuel: <strong>{{ $credentials['username'] }}</strong></small>
                            @endif
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password"
                                   class="form-control"
                                   id="password"
                                   name="credentials[password]"
                                   placeholder="{{ isset($credentials['password']) ? '•••••••• (laissez vide pour garder actuel)' : 'Entrez le mot de passe' }}">
                            @if(isset($credentials['password']))
                                <small class="text-success"><i class="fas fa-check"></i> Mot de passe configuré</small>
                            @endif
                        </div>

                        <!-- Database Name -->
                        <div class="mb-3">
                            <label for="database" class="form-label">Nom de la base de données</label>
                            <input type="text"
                                   class="form-control"
                                   id="database"
                                   name="credentials[database]"
                                   value="{{ old('credentials.database', $credentials['database'] ?? '') }}">
                        </div>
                    </div>
                </div>

                <!-- Configuration de Synchronisation -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-sync"></i> Configuration de Synchronisation</h5>
                    </div>
                    <div class="card-body">
                        <!-- Direction -->
                        <div class="mb-3">
                            <label for="sync_direction" class="form-label">Direction de synchronisation</label>
                            <select class="form-select" id="sync_direction" name="sync_direction">
                                <option value="export" {{ old('sync_direction', $integration->sync_direction) == 'export' ? 'selected' : '' }}>Export uniquement (B2B → ERP)</option>
                                <option value="import" {{ old('sync_direction', $integration->sync_direction) == 'import' ? 'selected' : '' }}>Import uniquement (ERP → B2B)</option>
                                <option value="bidirectional" {{ old('sync_direction', $integration->sync_direction) == 'bidirectional' ? 'selected' : '' }}>Bidirectionnel (les deux sens)</option>
                            </select>
                        </div>

                        <!-- Entités à synchroniser -->
                        <div class="mb-3">
                            <label class="form-label">Entités à synchroniser</label>
                            @php
                                $syncEntities = old('sync_entities', $integration->sync_entities ?? []);
                            @endphp
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sync_entities[]" value="products" id="sync_products" {{ in_array('products', $syncEntities) ? 'checked' : '' }}>
                                <label class="form-check-label" for="sync_products">Produits</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sync_entities[]" value="orders" id="sync_orders" {{ in_array('orders', $syncEntities) ? 'checked' : '' }}>
                                <label class="form-check-label" for="sync_orders">Commandes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sync_entities[]" value="customers" id="sync_customers" {{ in_array('customers', $syncEntities) ? 'checked' : '' }}>
                                <label class="form-check-label" for="sync_customers">Clients</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sync_entities[]" value="invoices" id="sync_invoices" {{ in_array('invoices', $syncEntities) ? 'checked' : '' }}>
                                <label class="form-check-label" for="sync_invoices">Factures</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sync_entities[]" value="inventory" id="sync_inventory" {{ in_array('inventory', $syncEntities) ? 'checked' : '' }}>
                                <label class="form-check-label" for="sync_inventory">Inventaire/Stock</label>
                            </div>
                        </div>

                        <!-- Fréquence -->
                        <div class="mb-3">
                            <label for="sync_frequency" class="form-label">Fréquence de synchronisation</label>
                            <select class="form-select" id="sync_frequency" name="sync_frequency">
                                <option value="manual" {{ old('sync_frequency', $integration->sync_frequency) == 'manual' ? 'selected' : '' }}>Manuel</option>
                                <option value="hourly" {{ old('sync_frequency', $integration->sync_frequency) == 'hourly' ? 'selected' : '' }}>Toutes les heures</option>
                                <option value="daily" {{ old('sync_frequency', $integration->sync_frequency) == 'daily' ? 'selected' : '' }}>Quotidien</option>
                                <option value="weekly" {{ old('sync_frequency', $integration->sync_frequency) == 'weekly' ? 'selected' : '' }}>Hebdomadaire</option>
                            </select>
                        </div>

                        <!-- Auto Sync -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="auto_sync" id="auto_sync" value="1" {{ old('auto_sync', $integration->auto_sync) ? 'checked' : '' }}>
                            <label class="form-check-label" for="auto_sync">
                                Activer la synchronisation automatique
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Statistiques (lecture seule) -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Statistiques</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <p class="mb-1"><strong>Total syncs:</strong></p>
                                <p class="text-muted">{{ $integration->total_syncs }}</p>
                            </div>
                            <div class="col-md-3">
                                <p class="mb-1"><strong>Réussis:</strong></p>
                                <p class="text-success">{{ $integration->successful_syncs }}</p>
                            </div>
                            <div class="col-md-3">
                                <p class="mb-1"><strong>Échoués:</strong></p>
                                <p class="text-danger">{{ $integration->failed_syncs }}</p>
                            </div>
                            <div class="col-md-3">
                                <p class="mb-1"><strong>Dernière sync:</strong></p>
                                <p class="text-muted">{{ $integration->last_sync_at ? $integration->last_sync_at->format('d/m/Y H:i') : 'Jamais' }}</p>
                            </div>
                        </div>

                        @if($integration->last_error)
                            <div class="alert alert-danger mt-3 mb-0">
                                <strong>Dernière erreur:</strong><br>
                                {{ $integration->last_error }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Enregistrer les modifications
                        </button>
                        <a href="{{ route('admin.integrations.show', $integration) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sidebar Actions -->
        <div class="col-lg-4">
            <!-- Actions rapides -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-bolt"></i> Actions Rapides</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.integrations.test', $integration) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-info w-100">
                            <i class="fas fa-vial"></i> Tester la connexion
                        </button>
                    </form>

                    @if($integration->status === 'active')
                        <form action="{{ route('admin.integrations.sync', $integration) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-sync"></i> Synchroniser maintenant
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('admin.integrations.logs', $integration) }}" class="btn btn-outline-secondary w-100 mb-2">
                        <i class="fas fa-history"></i> Voir les logs
                    </a>

                    <form action="{{ route('admin.integrations.toggle', $integration) }}" method="POST">
                        @csrf
                        @if($integration->status === 'active')
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="fas fa-pause"></i> Désactiver
                            </button>
                        @else
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-play"></i> Activer
                            </button>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Aide -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-question-circle"></i> Aide</h5>
                </div>
                <div class="card-body">
                    <h6>Modification des identifiants</h6>
                    <p class="small">
                        Pour des raisons de sécurité, les identifiants actuels ne sont pas affichés.
                        Laissez les champs vides pour conserver les valeurs existantes.
                    </p>

                    <h6 class="mt-3">Test de connexion</h6>
                    <p class="small">
                        Utilisez le bouton "Tester la connexion" pour vérifier que les identifiants fonctionnent correctement.
                    </p>

                    <h6 class="mt-3">Synchronisation</h6>
                    <p class="small mb-0">
                        La synchronisation automatique ne fonctionnera que si le statut est "Actif" et qu'une fréquence est définie.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
