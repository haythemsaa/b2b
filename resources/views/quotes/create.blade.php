@extends('layouts.app')

@section('title', 'Créer un Devis')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><i class="fas fa-file-invoice me-2 text-primary"></i>Créer un Devis</h1>
                <a href="{{ route('quotes.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                </a>
            </div>
        </div>
    </div>

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h6 class="mb-2"><i class="fas fa-exclamation-triangle me-2"></i>Erreurs de validation:</h6>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <form action="{{ route('quotes.store') }}" method="POST" id="quoteForm">
        @csrf

        <div class="row">
            <!-- Informations Client -->
            <div class="col-md-6">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Informations Client</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Nom du Client <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="customer_email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="customer_email" name="customer_email" value="{{ old('customer_email') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="customer_phone" class="form-label">Téléphone</label>
                            <input type="text" class="form-control" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}">
                        </div>

                        <div class="mb-3">
                            <label for="customer_address" class="form-label">Adresse</label>
                            <textarea class="form-control" id="customer_address" name="customer_address" rows="3">{{ old('customer_address') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations Devis -->
            <div class="col-md-6">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informations Devis</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="grossiste_id" class="form-label">Grossiste <span class="text-danger">*</span></label>
                            <select class="form-select" id="grossiste_id" name="grossiste_id" required>
                                <option value="">Sélectionner un grossiste</option>
                                @foreach($grossistes as $grossiste)
                                <option value="{{ $grossiste->id }}" {{ old('grossiste_id') == $grossiste->id ? 'selected' : '' }}>
                                    {{ $grossiste->name }} - {{ $grossiste->email }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="valid_until" class="form-label">Valide jusqu'au</label>
                            <input type="date" class="form-control" id="valid_until" name="valid_until"
                                   value="{{ old('valid_until', now()->addDays(30)->format('Y-m-d')) }}">
                            <small class="text-muted">Par défaut: 30 jours à partir d'aujourd'hui</small>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="terms_conditions" class="form-label">Conditions Générales</label>
                            <textarea class="form-control" id="terms_conditions" name="terms_conditions" rows="3">{{ old('terms_conditions', 'Paiement à 30 jours. Les prix sont valables pour la durée indiquée.') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Articles du Devis -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Articles du Devis</h5>
                <button type="button" class="btn btn-light btn-sm" onclick="addItem()">
                    <i class="fas fa-plus me-1"></i>Ajouter un Article
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="itemsTable">
                        <thead class="table-light">
                            <tr>
                                <th width="35%">Produit</th>
                                <th width="15%">Quantité</th>
                                <th width="15%">Prix Unitaire</th>
                                <th width="15%">Remise (%)</th>
                                <th width="15%">Sous-total</th>
                                <th width="5%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemsBody">
                            <!-- Les items seront ajoutés ici dynamiquement -->
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="4" class="text-end"><strong>Total HT:</strong></td>
                                <td colspan="2"><strong id="totalHT">0.000 TND</strong></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end"><strong>TVA (19%):</strong></td>
                                <td colspan="2"><strong id="totalTVA">0.000 TND</strong></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Total TTC:</strong></td>
                                <td colspan="2"><strong class="text-success" id="totalTTC">0.000 TND</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 text-end">
                <button type="button" class="btn btn-outline-secondary me-2" onclick="window.location='{{ route('quotes.index') }}'">
                    <i class="fas fa-times me-2"></i>Annuler
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Enregistrer le Devis
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
let itemIndex = 0;
const products = @json($products);

function addItem() {
    const tbody = document.getElementById('itemsBody');
    const row = document.createElement('tr');
    row.id = `item-${itemIndex}`;

    row.innerHTML = `
        <td>
            <select class="form-select form-select-sm" name="items[${itemIndex}][product_id]" onchange="updatePrice(${itemIndex})" required>
                <option value="">Sélectionner un produit</option>
                ${products.map(p => `<option value="${p.id}" data-price="${p.price}">${p.name} - ${p.sku}</option>`).join('')}
            </select>
        </td>
        <td>
            <input type="number" class="form-control form-control-sm" name="items[${itemIndex}][quantity]"
                   min="1" value="1" onchange="calculateSubtotal(${itemIndex})" required>
        </td>
        <td>
            <input type="number" class="form-control form-control-sm" name="items[${itemIndex}][unit_price]"
                   step="0.001" min="0" value="0" onchange="calculateSubtotal(${itemIndex})" required>
        </td>
        <td>
            <input type="number" class="form-control form-control-sm" name="items[${itemIndex}][discount_percent]"
                   step="0.01" min="0" max="100" value="0" onchange="calculateSubtotal(${itemIndex})">
        </td>
        <td>
            <strong id="subtotal-${itemIndex}">0.000 TND</strong>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-danger btn-sm" onclick="removeItem(${itemIndex})">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    `;

    tbody.appendChild(row);
    itemIndex++;
}

function removeItem(index) {
    const row = document.getElementById(`item-${index}`);
    if (row) {
        row.remove();
        calculateTotal();
    }
}

function updatePrice(index) {
    const select = document.querySelector(`select[name="items[${index}][product_id]"]`);
    const priceInput = document.querySelector(`input[name="items[${index}][unit_price]"]`);

    if (select && select.selectedOptions[0]) {
        const price = select.selectedOptions[0].dataset.price || 0;
        priceInput.value = parseFloat(price).toFixed(3);
        calculateSubtotal(index);
    }
}

function calculateSubtotal(index) {
    const quantity = parseFloat(document.querySelector(`input[name="items[${index}][quantity]"]`).value) || 0;
    const unitPrice = parseFloat(document.querySelector(`input[name="items[${index}][unit_price]"]`).value) || 0;
    const discount = parseFloat(document.querySelector(`input[name="items[${index}][discount_percent]"]`).value) || 0;

    const subtotal = quantity * unitPrice * (1 - discount / 100);
    document.getElementById(`subtotal-${index}`).textContent = subtotal.toFixed(3) + ' TND';

    calculateTotal();
}

function calculateTotal() {
    let total = 0;
    const tbody = document.getElementById('itemsBody');
    const rows = tbody.querySelectorAll('tr');

    rows.forEach((row, index) => {
        const subtotalText = row.querySelector('strong[id^="subtotal-"]')?.textContent || '0.000 TND';
        const subtotal = parseFloat(subtotalText.replace(' TND', '')) || 0;
        total += subtotal;
    });

    const tva = total * 0.19;
    const totalTTC = total + tva;

    document.getElementById('totalHT').textContent = total.toFixed(3) + ' TND';
    document.getElementById('totalTVA').textContent = tva.toFixed(3) + ' TND';
    document.getElementById('totalTTC').textContent = totalTTC.toFixed(3) + ' TND';
}

// Validation du formulaire
document.getElementById('quoteForm').addEventListener('submit', function(e) {
    const tbody = document.getElementById('itemsBody');
    if (tbody.querySelectorAll('tr').length === 0) {
        e.preventDefault();
        alert('Veuillez ajouter au moins un article au devis.');
        return false;
    }
});

// Ajouter un item au chargement
window.addEventListener('DOMContentLoaded', function() {
    addItem();
});
</script>
@endpush
@endsection
