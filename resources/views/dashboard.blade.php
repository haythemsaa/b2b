@extends('layouts.app')

@section('title', 'Dashboard Vendeur')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard Vendeur
                </h1>
                <div class="text-muted">
                    Bonjour {{ auth()->user()->name }} !
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Commandes ce mois
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ auth()->user()->orders()->whereMonth('created_at', now()->month)->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                CA du mois (DT)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format(auth()->user()->orders()->whereMonth('created_at', now()->month)->sum('total'), 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Produits disponibles
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Product::where('stock', '>', 0)->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Messages non lus
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ auth()->user()->receivedMessages()->where('read', false)->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation rapide -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-rocket me-2"></i>Accès rapide
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-block">
                                <i class="fas fa-shopping-bag me-2"></i>Voir le catalogue
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-success btn-block">
                                <i class="fas fa-shopping-cart me-2"></i>Mon panier
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-info btn-block">
                                <i class="fas fa-list-alt me-2"></i>Mes commandes
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('messages.index') }}" class="btn btn-outline-warning btn-block">
                                <i class="fas fa-comments me-2"></i>Messagerie
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('returns.index') }}" class="btn btn-outline-secondary btn-block">
                                <i class="fas fa-undo me-2"></i>Retours & SAV
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="#" class="btn btn-outline-dark btn-block" onclick="document.getElementById('profile-form').style.display='block'">
                                <i class="fas fa-user-cog me-2"></i>Mon profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-clock me-2"></i>Dernières commandes
                    </h6>
                </div>
                <div class="card-body">
                    @forelse(auth()->user()->orders()->latest()->take(5)->get() as $order)
                        <div class="d-flex align-items-center border-bottom py-2">
                            <div class="flex-grow-1">
                                <h6 class="mb-0">Commande #{{ $order->id }}</h6>
                                <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <div class="text-end">
                                <strong>{{ number_format($order->total, 2) }} DT</strong>
                                <br>
                                <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-3">
                            <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                            <p>Aucune commande récente</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">
                                Commencer à acheter
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Messages récents -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bell me-2"></i>Notifications récentes
                    </h6>
                </div>
                <div class="card-body">
                    @forelse(auth()->user()->receivedMessages()->latest()->take(3)->get() as $message)
                        <div class="d-flex align-items-center border-bottom py-3">
                            <div class="me-3">
                                <div class="icon-circle bg-primary">
                                    <i class="fas fa-envelope text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="small text-gray-500">{{ $message->created_at->format('d M Y à H:i') }}</div>
                                <strong>{{ $message->subject }}</strong>
                                <p class="mb-0">{{ Str::limit($message->content, 100) }}</p>
                            </div>
                            <div class="text-end">
                                @if(!$message->read)
                                    <span class="badge bg-primary">Nouveau</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-3">
                            <i class="fas fa-bell-slash fa-2x mb-2"></i>
                            <p>Aucune notification récente</p>
                        </div>
                    @endforelse

                    @if(auth()->user()->receivedMessages()->count() > 3)
                        <div class="text-center mt-3">
                            <a href="{{ route('messages.index') }}" class="btn btn-primary btn-sm">
                                Voir tous les messages
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de profil -->
<div id="profile-form" style="display: none;" class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center" style="z-index: 1050;">
    <div class="card" style="width: 400px;">
        <div class="card-header">
            <h5 class="mb-0">Mon profil</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <strong>Nom :</strong> {{ auth()->user()->name }}
            </div>
            <div class="mb-3">
                <strong>Email :</strong> {{ auth()->user()->email }}
            </div>
            <div class="mb-3">
                <strong>Rôle :</strong> {{ ucfirst(auth()->user()->role) }}
            </div>
            <div class="mb-3">
                <strong>Membre depuis :</strong> {{ auth()->user()->created_at->format('d/m/Y') }}
            </div>
        </div>
        <div class="card-footer">
            <button onclick="document.getElementById('profile-form').style.display='none'" class="btn btn-secondary">
                Fermer
            </button>
        </div>
    </div>
</div>

<style>
.border-left-primary { border-left: 0.25rem solid #4e73df !important; }
.border-left-success { border-left: 0.25rem solid #1cc88a !important; }
.border-left-info { border-left: 0.25rem solid #36b9cc !important; }
.border-left-warning { border-left: 0.25rem solid #f6c23e !important; }

.icon-circle {
    height: 2.5rem;
    width: 2.5rem;
    border-radius: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
@endsection