@extends('layouts.admin')

@section('title', 'Commande #' . $order->order_number)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Commande #{{ $order->order_number }}</h1>
                <div>
                    @php
                        $statusClass = [
                            'pending' => 'warning',
                            'confirmed' => 'info',
                            'processing' => 'primary',
                            'shipped' => 'secondary',
                            'delivered' => 'success',
                            'cancelled' => 'danger'
                        ][$order->status] ?? 'secondary';

                        $statusText = [
                            'pending' => 'En attente',
                            'confirmed' => 'Confirmée',
                            'processing' => 'En traitement',
                            'shipped' => 'Expédiée',
                            'delivered' => 'Livrée',
                            'cancelled' => 'Annulée'
                        ][$order->status] ?? ucfirst($order->status);
                    @endphp
                    <span class="badge bg-{{ $statusClass }} fs-6 me-2">{{ $statusText }}</span>

                    @php
                        $invoice = \App\Models\Invoice::where('order_id', $order->id)->first();
                    @endphp

                    @if($invoice)
                        <a href="{{ route('admin.invoices.show', $invoice->id) }}" class="btn btn-success me-2">
                            <i class="fas fa-file-invoice"></i> Voir la facture
                        </a>
                    @else
                        <form action="{{ route('admin.invoices.generate-from-order', $order->id) }}" method="POST" class="d-inline me-2">
                            @csrf
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Générer une facture pour cette commande ?')">
                                <i class="fas fa-file-invoice-dollar"></i> Générer Facture
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <!-- Informations de la commande -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Détails de la Commande</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Numéro de Commande</label>
                                <div class="fw-bold">{{ $order->order_number }}</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Date de Commande</label>
                                <div>{{ $order->created_at->format('d/m/Y à H:i') }}</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Statut</label>
                                <div>
                                    <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Montant Total</label>
                                <div class="fw-bold text-success fs-4">{{ number_format($order->total_amount, 2) }} MAD</div>
                            </div>

                            @if($order->notes)
                            <div class="mb-3">
                                <label class="form-label text-muted">Notes</label>
                                <div class="border rounded p-2 bg-light">{{ $order->notes }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations client -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informations Client</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Nom</label>
                                <div class="fw-bold">{{ $order->user->name }}</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Email</label>
                                <div>{{ $order->user->email }}</div>
                            </div>

                            @if($order->user->company_name)
                            <div class="mb-3">
                                <label class="form-label text-muted">Entreprise</label>
                                <div>{{ $order->user->company_name }}</div>
                            </div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            @if($order->user->phone)
                            <div class="mb-3">
                                <label class="form-label text-muted">Téléphone</label>
                                <div>{{ $order->user->phone }}</div>
                            </div>
                            @endif

                            @if($order->user->address)
                            <div class="mb-3">
                                <label class="form-label text-muted">Adresse</label>
                                <div>
                                    {{ $order->user->address }}
                                    @if($order->user->city)
                                        <br>{{ $order->user->city }}
                                        @if($order->user->postal_code)
                                            {{ $order->user->postal_code }}
                                        @endif
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Articles commandés -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Articles Commandés ({{ $order->items->count() }})</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead class="table-light">
                                <tr>
                                    <th>Produit</th>
                                    <th width="100" class="text-center">Quantité</th>
                                    <th width="120" class="text-end">Prix Unitaire</th>
                                    <th width="120" class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div>
                                                <strong>{{ $item->product->name }}</strong>
                                                <div class="small text-muted">SKU: {{ $item->product->sku }}</div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark">{{ $item->quantity }}</span>
                                        </td>
                                        <td class="text-end">{{ number_format($item->price, 2) }} MAD</td>
                                        <td class="text-end fw-bold">{{ number_format($item->quantity * $item->price, 2) }} MAD</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="3" class="text-end">Total de la Commande :</th>
                                    <th class="text-end text-success fs-5">{{ number_format($order->total_amount, 2) }} MAD</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Actions</h6>
                </div>
                <div class="card-body">
                    @if($order->status !== 'cancelled' && $order->status !== 'delivered')
                        <div class="d-grid gap-2 mb-3">
                            @if($order->status === 'pending')
                                <button type="button" class="btn btn-info update-status" data-status="confirmed">
                                    <i class="fas fa-check"></i> Confirmer la Commande
                                </button>
                            @endif

                            @if(in_array($order->status, ['pending', 'confirmed']))
                                <button type="button" class="btn btn-primary update-status" data-status="processing">
                                    <i class="fas fa-cog"></i> Mettre en Traitement
                                </button>
                            @endif

                            @if(in_array($order->status, ['confirmed', 'processing']))
                                <button type="button" class="btn btn-secondary update-status" data-status="shipped">
                                    <i class="fas fa-truck"></i> Marquer comme Expédiée
                                </button>
                            @endif

                            @if($order->status === 'shipped')
                                <button type="button" class="btn btn-success update-status" data-status="delivered">
                                    <i class="fas fa-check-circle"></i> Marquer comme Livrée
                                </button>
                            @endif
                        </div>

                        <hr>
                    @endif

                    <div class="d-grid gap-2">
                        @if($order->status !== 'cancelled')
                            <button type="button" class="btn btn-outline-danger update-status" data-status="cancelled">
                                <i class="fas fa-times"></i> Annuler la Commande
                            </button>
                        @endif

                        <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#notesModal">
                            <i class="fas fa-sticky-note"></i> Ajouter une Note
                        </button>

                        <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                            <i class="fas fa-print"></i> Imprimer
                        </button>
                    </div>
                </div>
            </div>

            <!-- Historique -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Historique</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-0">Commande créée</h6>
                                <small class="text-muted">{{ $order->created_at->format('d/m/Y à H:i') }}</small>
                            </div>
                        </div>

                        @if($order->updated_at != $order->created_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="mb-0">Dernière mise à jour</h6>
                                <small class="text-muted">{{ $order->updated_at->format('d/m/Y à H:i') }}</small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour ajouter des notes -->
<div class="modal fade" id="notesModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter une Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="notesForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="notes" class="form-label">Note</label>
                        <textarea class="form-control" id="notes" name="notes" rows="4" placeholder="Ajouter une note à cette commande...">{{ $order->notes }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
}

.timeline-item:before {
    content: '';
    position: absolute;
    left: -25px;
    top: 20px;
    height: calc(100% - 20px);
    width: 2px;
    background: #e9ecef;
}

.timeline-item:last-child:before {
    display: none;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 0;
    width: 10px;
    height: 10px;
    border-radius: 50%;
}

.timeline-content h6 {
    margin-bottom: 5px;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusButtons = document.querySelectorAll('.update-status');
    const notesForm = document.getElementById('notesForm');

    statusButtons.forEach(button => {
        button.addEventListener('click', function() {
            const newStatus = this.dataset.status;
            const statusText = this.textContent.trim();

            if (confirm(`Êtes-vous sûr de vouloir ${statusText.toLowerCase()} ?`)) {
                fetch(`/admin/orders/{{ $order->id }}/update-status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        location.reload();
                    } else {
                        alert(data.error || 'Une erreur est survenue');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Une erreur est survenue');
                });
            }
        });
    });

    notesForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch(`/admin/orders/{{ $order->id }}/add-notes`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                location.reload();
            } else {
                alert(data.error || 'Une erreur est survenue');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Une erreur est survenue');
        });
    });
});
</script>
@endpush
@endsection
