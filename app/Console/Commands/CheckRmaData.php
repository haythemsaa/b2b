<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckRmaData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:rma-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check RMA system data and integration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== VÉRIFICATION DES DONNÉES RMA ===');
        $this->newLine();

        // Vérifier les commandes livrées
        $this->info('1. COMMANDES LIVRÉES DISPONIBLES:');
        $this->line('---------------------------------');

        $deliveredOrders = \App\Models\Order::where('status', 'delivered')->with(['items.product', 'user'])->get();

        if ($deliveredOrders->count() > 0) {
            foreach ($deliveredOrders as $order) {
                $this->line("- Commande {$order->order_number}");
                $this->line("  Client: {$order->user->name} ({$order->user->email})");
                $deliveryDate = $order->delivered_at ? $order->delivered_at->format('d/m/Y') : 'Non définie';
                $this->line("  Date livraison: {$deliveryDate}");
                $this->line("  Articles: {$order->items->count()}");
                foreach ($order->items as $item) {
                    $productName = $item->product_name ?: ($item->product ? $item->product->name : 'Produit inconnu');
                    $this->line("    * {$productName} (Qté: {$item->quantity})");
                }
                $this->newLine();
            }
        } else {
            $this->warn('Aucune commande livrée trouvée.');
            $this->newLine();

            // Vérifier toutes les commandes et leurs statuts
            $this->info('2. STATUTS DES COMMANDES:');
            $this->line('-------------------------');
            $allOrders = \App\Models\Order::with('user')->get();
            foreach ($allOrders as $order) {
                $this->line("- {$order->order_number}: {$order->status} ({$order->user->name})");
            }
        }

        $this->newLine();

        // Vérifier les retours existants
        $this->info('3. RETOURS EXISTANTS:');
        $this->line('---------------------');
        $returns = \App\Models\ProductReturn::with(['user', 'product', 'order'])->get();

        if ($returns->count() > 0) {
            foreach ($returns as $return) {
                $this->line("- {$return->rma_number}");
                $this->line("  Statut: {$return->status}");
                $this->line("  Client: {$return->user->name}");
                $this->line("  Produit: {$return->product->name}");
                $this->line("  Quantité: {$return->quantity_returned}");
                $this->line("  Créé: {$return->created_at->format('d/m/Y H:i')}");
                $this->newLine();
            }
        } else {
            $this->warn('Aucun retour trouvé.');
        }

        $this->info('=== VÉRIFICATION TERMINÉE ===');
        return Command::SUCCESS;
    }
}
