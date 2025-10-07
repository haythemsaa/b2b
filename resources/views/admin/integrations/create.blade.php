@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-plug"></i> Nouvelle Intégration ERP
            </h1>
            <p class="text-muted">Configurer une nouvelle intégration avec un système externe</p>
        </div>
        <div>
            <a href="{{ route('admin.integrations.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <!-- Formulaire -->
    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('admin.integrations.store') }}" method="POST">
                @csrf

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
                                   value="{{ old('name') }}"
                                   required
                                   placeholder="Ex: SAP Business One - Production">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Un nom descriptif pour identifier cette intégration</small>
                        </div>

                        <!-- Type -->
                        <div class="mb-3">
                            <label for="type" class="form-label">Type de système <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror"
                                    id="type"
                                    name="type"
                                    required
                                    onchange="updateTypeDescription()">
                                <option value="">-- Sélectionner un type --</option>
                                <option value="sap_b1" {{ old('type') == 'sap_b1' ? 'selected' : '' }}>SAP Business One</option>
                                <option value="dynamics_365" {{ old('type') == 'dynamics_365' ? 'selected' : '' }}>Microsoft Dynamics 365</option>
                                <option value="sage" {{ old('type') == 'sage' ? 'selected' : '' }}>Sage</option>
                                <option value="quickbooks" {{ old('type') == 'quickbooks' ? 'selected' : '' }}>QuickBooks</option>
                                <option value="odoo" {{ old('type') == 'odoo' ? 'selected' : '' }}>Odoo</option>
                                <option value="xero" {{ old('type') == 'xero' ? 'selected' : '' }}>Xero</option>
                                <option value="netsuite" {{ old('type') == 'netsuite' ? 'selected' : '' }}>Oracle NetSuite</option>
                                <option value="custom_api" {{ old('type') == 'custom_api' ? 'selected' : '' }}>API Personnalisée</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted" id="type-description">Sélectionnez le système ERP/Comptabilité à intégrer</small>
                        </div>

                        <!-- Statut -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Statut <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="testing" {{ old('status', 'testing') == 'testing' ? 'selected' : '' }}>Test</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactif</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Actif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Commencez en mode "Test" pour valider la configuration</small>
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
                            <i class="fas fa-shield-alt"></i> Les identifiants sont chiffrés et stockés de manière sécurisée
                        </div>

                        <!-- API URL -->
                        <div class="mb-3">
                            <label for="api_url" class="form-label">URL de l'API</label>
                            <input type="url"
                                   class="form-control"
                                   id="api_url"
                                   name="credentials[api_url]"
                                   value="{{ old('credentials.api_url') }}"
                                   placeholder="https://api.exemple.com">
                            <small class="text-muted">L'URL de base de l'API du système externe</small>
                        </div>

                        <!-- API Key -->
                        <div class="mb-3">
                            <label for="api_key" class="form-label">Clé API</label>
                            <input type="text"
                                   class="form-control"
                                   id="api_key"
                                   name="credentials[api_key]"
                                   value="{{ old('credentials.api_key') }}"
                                   placeholder="Entrez votre clé API">
                        </div>

                        <!-- API Secret -->
                        <div class="mb-3">
                            <label for="api_secret" class="form-label">Secret API</label>
                            <input type="password"
                                   class="form-control"
                                   id="api_secret"
                                   name="credentials[api_secret]"
                                   placeholder="••••••••">
                            <small class="text-muted">Le secret sera chiffré avant stockage</small>
                        </div>

                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Nom d'utilisateur</label>
                            <input type="text"
                                   class="form-control"
                                   id="username"
                                   name="credentials[username]"
                                   value="{{ old('credentials.username') }}"
                                   placeholder="Nom d'utilisateur">
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password"
                                   class="form-control"
                                   id="password"
                                   name="credentials[password]"
                                   placeholder="••••••••">
                        </div>

                        <!-- Database Name (pour SAP, Odoo, etc.) -->
                        <div class="mb-3">
                            <label for="database" class="form-label">Nom de la base de données</label>
                            <input type="text"
                                   class="form-control"
                                   id="database"
                                   name="credentials[database]"
                                   value="{{ old('credentials.database') }}"
                                   placeholder="Nom de la base">
                            <small class="text-muted">Requis pour certains systèmes comme SAP Business One</small>
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
                                <option value="export" {{ old('sync_direction', 'export') == 'export' ? 'selected' : '' }}>Export uniquement (B2B → ERP)</option>
                                <option value="import" {{ old('sync_direction') == 'import' ? 'selected' : '' }}>Import uniquement (ERP → B2B)</option>
                                <option value="bidirectional" {{ old('sync_direction') == 'bidirectional' ? 'selected' : '' }}>Bidirectionnel (les deux sens)</option>
                            </select>
                        </div>

                        <!-- Entités à synchroniser -->
                        <div class="mb-3">
                            <label class="form-label">Entités à synchroniser</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sync_entities[]" value="products" id="sync_products" {{ in_array('products', old('sync_entities', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="sync_products">
                                    Produits
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sync_entities[]" value="orders" id="sync_orders" {{ in_array('orders', old('sync_entities', ['orders'])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="sync_orders">
                                    Commandes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sync_entities[]" value="customers" id="sync_customers" {{ in_array('customers', old('sync_entities', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="sync_customers">
                                    Clients
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sync_entities[]" value="invoices" id="sync_invoices" {{ in_array('invoices', old('sync_entities', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="sync_invoices">
                                    Factures
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sync_entities[]" value="inventory" id="sync_inventory" {{ in_array('inventory', old('sync_entities', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="sync_inventory">
                                    Inventaire/Stock
                                </label>
                            </div>
                        </div>

                        <!-- Fréquence -->
                        <div class="mb-3">
                            <label for="sync_frequency" class="form-label">Fréquence de synchronisation</label>
                            <select class="form-select" id="sync_frequency" name="sync_frequency">
                                <option value="manual" {{ old('sync_frequency', 'manual') == 'manual' ? 'selected' : '' }}>Manuel</option>
                                <option value="hourly" {{ old('sync_frequency') == 'hourly' ? 'selected' : '' }}>Toutes les heures</option>
                                <option value="daily" {{ old('sync_frequency') == 'daily' ? 'selected' : '' }}>Quotidien</option>
                                <option value="weekly" {{ old('sync_frequency') == 'weekly' ? 'selected' : '' }}>Hebdomadaire</option>
                            </select>
                        </div>

                        <!-- Auto Sync -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="auto_sync" id="auto_sync" value="1" {{ old('auto_sync') ? 'checked' : '' }}>
                            <label class="form-check-label" for="auto_sync">
                                Activer la synchronisation automatique
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Créer l'intégration
                        </button>
                        <a href="{{ route('admin.integrations.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sidebar d'aide -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-question-circle"></i> Aide</h5>
                </div>
                <div class="card-body">
                    <h6>Configuration requise</h6>
                    <p class="small">Les champs requis varient selon le type de système sélectionné.</p>

                    <h6 class="mt-3">SAP Business One</h6>
                    <ul class="small">
                        <li>URL API (Service Layer)</li>
                        <li>Nom d'utilisateur</li>
                        <li>Mot de passe</li>
                        <li>Nom de la base</li>
                    </ul>

                    <h6 class="mt-3">QuickBooks/Xero</h6>
                    <ul class="small">
                        <li>Clé API (OAuth Client ID)</li>
                        <li>Secret API (OAuth Secret)</li>
                        <li>URL de redirection configurée</li>
                    </ul>

                    <h6 class="mt-3">Odoo</h6>
                    <ul class="small">
                        <li>URL API (instance Odoo)</li>
                        <li>Base de données</li>
                        <li>Nom d'utilisateur</li>
                        <li>Mot de passe ou clé API</li>
                    </ul>

                    <h6 class="mt-3">API Personnalisée</h6>
                    <ul class="small">
                        <li>URL de base de l'API</li>
                        <li>Méthode d'authentification (Bearer, Basic, etc.)</li>
                        <li>Clés d'API appropriées</li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-warning">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Sécurité</h5>
                </div>
                <div class="card-body">
                    <p class="small">
                        <strong>Tous les identifiants sont chiffrés</strong> avant d'être stockés en base de données.
                    </p>
                    <p class="small">
                        Il est recommandé de créer un compte utilisateur dédié dans votre ERP avec les permissions minimales nécessaires.
                    </p>
                    <p class="small mb-0">
                        Testez toujours la connexion avant d'activer la synchronisation automatique.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateTypeDescription() {
    const type = document.getElementById('type').value;
    const descriptions = {
        'sap_b1': 'ERP complet pour PME avec gestion financière, ventes et inventaire',
        'dynamics_365': 'Suite Microsoft d\'applications d\'entreprise pour ERP et CRM',
        'sage': 'Logiciel de comptabilité et gestion commerciale',
        'quickbooks': 'Logiciel de comptabilité en ligne pour PME',
        'odoo': 'Suite d\'applications open-source pour gestion d\'entreprise',
        'xero': 'Plateforme de comptabilité cloud pour petites entreprises',
        'netsuite': 'ERP cloud complet d\'Oracle pour grandes entreprises',
        'custom_api': 'Intégration avec une API personnalisée ou système propriétaire'
    };

    document.getElementById('type-description').textContent = descriptions[type] || 'Sélectionnez le système ERP/Comptabilité à intégrer';
}
</script>
@endsection
