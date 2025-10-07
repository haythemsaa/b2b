<?php

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/bootstrap/app.php';

use App\Models\Order;
use App\Models\ProductReturn;

echo "=== VÉRIFICATION DES DONNÉES RMA ===\n\n";

// Vérifier les commandes livrées
echo "1. COMMANDES LIVRÉES DISPONIBLES:\n";
echo "---------------------------------\n";
$deliveredOrders = Order::where('status', 'delivered')->with(['items.product', 'user'])->get();

if ($deliveredOrders->count() > 0) {
    foreach ($deliveredOrders as $order) {
        echo "- Commande {$order->order_number}\n";
        echo "  Client: {$order->user->name} ({$order->user->email})\n";
        echo "  Date livraison: " . ($order->delivered_at ? $order->delivered_at->format('d/m/Y') : 'Non définie') . "\n";
        echo "  Articles: {$order->items->count()}\n";
        foreach ($order->items as $item) {
            echo "    * {$item->product->name} (Qté: {$item->quantity})\n";
        }
        echo "\n";
    }
} else {
    echo "Aucune commande livrée trouvée.\n\n";

    // Vérifier toutes les commandes et leurs statuts
    echo "2. STATUTS DES COMMANDES:\n";
    echo "-------------------------\n";
    $allOrders = Order::with('user')->get();
    foreach ($allOrders as $order) {
        echo "- {$order->order_number}: {$order->status} ({$order->user->name})\n";
    }
}

echo "\n";

// Vérifier les retours existants
echo "3. RETOURS EXISTANTS:\n";
echo "---------------------\n";
$returns = ProductReturn::with(['user', 'product', 'order'])->get();

if ($returns->count() > 0) {
    foreach ($returns as $return) {
        echo "- {$return->rma_number}\n";
        echo "  Statut: {$return->status}\n";
        echo "  Client: {$return->user->name}\n";
        echo "  Produit: {$return->product->name}\n";
        echo "  Quantité: {$return->quantity_returned}\n";
        echo "  Créé: {$return->created_at->format('d/m/Y H:i')}\n\n";
    }
} else {
    echo "Aucun retour trouvé.\n";
}

echo "=== VÉRIFICATION TERMINÉE ===\n";