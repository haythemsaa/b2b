@extends('layouts.app')

@section('title', 'Demande de Retour - ' . $return->rma_number)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Demande de Retour</h1>
                <div>
                    <a href="{{ route('returns.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Retour à la liste
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
            <!-- Informations principales -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Informations de la Demande</h5>
                    @if($return->status === 'pending')
                        <span class="badge bg-warning fs-6">{{ $return->status_label }}</span>
                    @elseif($return->status === 'approved')
                        <span class="badge bg-success fs-6">{{ $return->status_label }}</span>
                    @elseif($return->status === 'rejected')
                        <span class="badge bg-danger fs-6">{{ $return->status_label }}</span>
                    @elseif($return->status === 'completed')
                        <span class="badge bg-primary fs-6">{{ $return->status_label }}</span>
                    @elseif($return->status === 'refunded')
                        <span class="badge bg-success fs-6">{{ $return->status_label }}</span>
                    @else
                        <span class="badge bg-secondary fs-6">{{ $return->status_label }}</span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Numéro RMA</label>
                                <div class="fw-bold fs-5">{{ $return->rma_number }}</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Date de demande</label>
                                <div>{{ $return->created_at->format('d/m/Y à H:i') }}</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Commande associée</label>
                                <div>
                                    <a href="{{ route('orders.show', $return->order) }}" class="text-primary">
                                        {{ $return->order->order_number }}
                                    </a>
                                    <div class="small text-muted">Livrée le {{ $return->order->delivered_at->format('d/m/Y') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Type de retour demandé</label>
                                <div>
                                    <span class="badge bg-info">{{ $return->return_type_label }}</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Raison du retour</label>
                                <div>
                                    <span class="badge bg-secondary">{{ $return->reason_label }}</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">État du produit</label>
                                <div>
                                    <span class="badge bg-light text-dark">{{ $return->condition_label }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($return->reason_details)
                    <div class="mb-0">
                        <label class="form-label text-muted">Détails supplémentaires</label>
                        <div class="border rounded p-3 bg-light">
                            {{ $return->reason_details }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Informations produit -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Produit Retourné</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6>{{ $return->product->name }}</h6>
                            <div class="text-muted mb-2">SKU: {{ $return->product->sku }}</div>
                            @if($return->product->description)
                                <div class="text-muted">{{ Str::limit($return->product->description, 200) }}</div>
                            @endif
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="mb-2">
                                <span class="badge bg-info fs-6">Quantité: {{ $return->quantity_returned }}</span>
                            </div>
                            <div class="mb-2">
                                <strong>Prix unitaire:</strong> {{ number_format($return->orderItem->unit_price, 2) }} MAD
                            </div>
                            <div>
                                <strong>Total:</strong> {{ number_format($return->orderItem->unit_price * $return->quantity_returned, 2) }} MAD
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Photos du produit -->
            @if($return->images && count($return->images) > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Photos Jointes</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($return->images as $image)
                            <div class="col-md-4 col-sm-6 mb-3">
                                <img src="{{ asset('storage/' . $image) }}"
                                     class="img-thumbnail w-100"
                                     alt="Photo produit retourné"
                                     style="cursor: pointer; height: 200px; object-fit: cover;"
                                     onclick="showImageModal(this.src)">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Réponse admin -->
            @if($return->admin_notes && in_array($return->status, ['approved', 'rejected']))
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        @if($return->status === 'approved')
                            <i class="fas fa-check-circle text-success"></i> Réponse de l'administration
                        @else
                            <i class="fas fa-times-circle text-danger"></i> Réponse de l'administration
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert {{ $return->status === 'approved' ? 'alert-success' : 'alert-danger' }} mb-0">
                        {{ $return->admin_notes }}
                    </div>
                    <div class="text-muted mt-2 small">
                        @if($return->status === 'approved' && $return->approved_at)
                            Approuvé le {{ $return->approved_at->format('d/m/Y à H:i') }}
                        @elseif($return->status === 'rejected' && $return->rejected_at)
                            Refusé le {{ $return->rejected_at->format('d/m/Y à H:i') }}
                        @endif
                        @if($return->approver)
                            par {{ $return->approver->name }}
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Historique de statut -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Suivi de la Demande</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Demande créée</h6>
                                <p class="timeline-description">
                                    {{ $return->created_at->format('d/m/Y à H:i') }}
                                    <br><span class="text-muted">Votre demande a été soumise et est en attente de traitement</span>
                                </p>
                            </div>
                        </div>

                        @if($return->approved_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Demande approuvée</h6>
                                <p class="timeline-description">
                                    {{ $return->approved_at->format('d/m/Y à H:i') }}
                                    @if($return->approver)
                                        par {{ $return->approver->name }}
                                    @endif
                                    <br><span class="text-muted">Votre demande a été acceptée</span>
                                </p>
                            </div>
                        </div>
                        @endif

                        @if($return->rejected_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-danger"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Demande refusée</h6>
                                <p class="timeline-description">
                                    {{ $return->rejected_at->format('d/m/Y à H:i') }}
                                    @if($return->approver)
                                        par {{ $return->approver->name }}
                                    @endif
                                    <br><span class="text-muted">Votre demande a été refusée</span>
                                </p>
                            </div>
                        </div>
                        @endif

                        @if($return->status === 'processing')
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">En traitement</h6>
                                <p class="timeline-description">
                                    <span class="text-muted">Votre retour est actuellement en cours de traitement</span>
                                </p>
                            </div>
                        </div>
                        @endif

                        @if($return->completed_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Retour terminé</h6>
                                <p class="timeline-description">
                                    {{ $return->completed_at->format('d/m/Y à H:i') }}
                                    <br><span class="text-muted">Le processus de retour est terminé</span>
                                </p>
                            </div>
                        </div>
                        @endif

                        @if($return->status === 'refunded')
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Remboursement effectué</h6>
                                <p class="timeline-description">
                                    <span class="text-muted">Le remboursement a été traité</span>
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Résumé -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Résumé</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-12 mb-3">
                            <div class="border-bottom pb-3">
                                <h4 class="text-primary mb-1">{{ number_format($return->orderItem->unit_price * $return->quantity_returned, 2) }}</h4>
                                <small class="text-muted">Montant total</small>
                            </div>
                        </div>
                        @if($return->refund_amount)
                        <div class="col-12">
                            <div class="pt-3">
                                <h4 class="text-success mb-1">{{ number_format($return->refund_amount, 2) }}</h4>
                                <small class="text-muted">Remboursement accordé</small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- État actuel -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">État Actuel</h6>
                </div>
                <div class="card-body text-center">
                    @if($return->status === 'pending')
                        <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                        <h6>En attente de traitement</h6>
                        <p class="text-muted mb-0">Votre demande sera examinée dans les 48h</p>
                    @elseif($return->status === 'approved')
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h6>Demande approuvée</h6>
                        <p class="text-muted mb-0">Votre retour a été accepté</p>
                    @elseif($return->status === 'rejected')
                        <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                        <h6>Demande refusée</h6>
                        <p class="text-muted mb-0">Consultez les raisons ci-dessus</p>
                    @elseif($return->status === 'processing')
                        <i class="fas fa-cog fa-spin fa-3x text-info mb-3"></i>
                        <h6>En cours de traitement</h6>
                        <p class="text-muted mb-0">Votre retour est en cours de traitement</p>
                    @elseif($return->status === 'completed')
                        <i class="fas fa-check fa-3x text-primary mb-3"></i>
                        <h6>Retour terminé</h6>
                        <p class="text-muted mb-0">Le processus est terminé</p>
                    @elseif($return->status === 'refunded')
                        <i class="fas fa-money-bill-wave fa-3x text-success mb-3"></i>
                        <h6>Remboursement effectué</h6>
                        <p class="text-muted mb-0">Le remboursement a été traité</p>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Actions</h6>
                </div>
                <div class="card-body d-grid gap-2">
                    @if($return->status === 'pending')
                        <button class="btn btn-outline-danger" onclick="deleteReturn()">
                            <i class="fas fa-trash"></i> Supprimer la demande
                        </button>
                    @endif

                    <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                        <i class="fas fa-print"></i> Imprimer
                    </button>

                    <a href="{{ route('returns.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-plus"></i> Nouvelle demande
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'affichage d'image -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Photo du produit retourné</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" alt="Photo produit">
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 25px;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -37px;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 0 0 3px #dee2e6;
}

.timeline-title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 5px;
}

.timeline-description {
    color: #6c757d;
    margin-bottom: 0;
    font-size: 14px;
    line-height: 1.4;
}
</style>
@endpush

@push('scripts')
<script>
function showImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}

function deleteReturn() {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette demande de retour ?\n\nCette action est irréversible.')) {
        fetch(`/returns/{{ $return->id }}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                window.location.href = '{{ route("returns.index") }}';
            } else {
                alert(data.error || 'Une erreur est survenue');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Une erreur est survenue');
        });
    }
}
</script>
@endpush
@endsection