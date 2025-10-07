<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    /**
     * Créer une notification
     */
    public function create(array $data)
    {
        return Notification::create($data);
    }

    /**
     * Notifier un utilisateur
     */
    public function notify(User $user, string $type, string $title, string $message, array $options = [])
    {
        return Notification::create([
            'user_id' => $user->id,
            'tenant_id' => $user->tenant_id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $options['data'] ?? null,
            'icon' => $options['icon'] ?? null,
            'link' => $options['link'] ?? null,
            'priority' => $options['priority'] ?? 'normal',
        ]);
    }

    /**
     * Notifier plusieurs utilisateurs
     */
    public function notifyMultiple(array $userIds, string $type, string $title, string $message, array $options = [])
    {
        $notifications = [];

        foreach ($userIds as $userId) {
            $user = User::find($userId);
            if ($user) {
                $notifications[] = $this->notify($user, $type, $title, $message, $options);
            }
        }

        return $notifications;
    }

    /**
     * Notification pour nouvelle commande
     */
    public function notifyNewOrder($order, $adminUsers)
    {
        foreach ($adminUsers as $admin) {
            $this->notify(
                $admin,
                'order',
                'Nouvelle commande',
                "Commande #{$order->id} de {$order->user->name} - Montant: {$order->total_amount} DT",
                [
                    'link' => route('admin.orders.show', $order->id),
                    'priority' => 'high',
                    'data' => [
                        'order_id' => $order->id,
                        'amount' => $order->total_amount,
                    ]
                ]
            );
        }
    }

    /**
     * Notification pour changement de statut de commande
     */
    public function notifyOrderStatusChange($order, $oldStatus, $newStatus)
    {
        $statusLabels = [
            'pending' => 'En attente',
            'processing' => 'En traitement',
            'completed' => 'Complétée',
            'cancelled' => 'Annulée',
        ];

        $this->notify(
            $order->user,
            'order',
            'Statut de commande mis à jour',
            "Votre commande #{$order->id} est maintenant: {$statusLabels[$newStatus]}",
            [
                'link' => route('orders.show', $order->id),
                'priority' => $newStatus === 'completed' ? 'high' : 'normal',
                'data' => [
                    'order_id' => $order->id,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                ]
            ]
        );
    }

    /**
     * Notification pour demande de retour
     */
    public function notifyNewReturn($return, $adminUsers)
    {
        foreach ($adminUsers as $admin) {
            $this->notify(
                $admin,
                'return',
                'Nouvelle demande de retour',
                "Demande de retour #{$return->id} de {$return->user->name}",
                [
                    'link' => route('admin.returns.show', $return->id),
                    'priority' => 'high',
                    'data' => [
                        'return_id' => $return->id,
                    ]
                ]
            );
        }
    }

    /**
     * Notification pour retour approuvé/refusé
     */
    public function notifyReturnStatusChange($return, $status)
    {
        $title = $status === 'approved' ? 'Retour approuvé' : 'Retour refusé';
        $message = $status === 'approved'
            ? "Votre demande de retour #{$return->id} a été approuvée"
            : "Votre demande de retour #{$return->id} a été refusée";

        $this->notify(
            $return->user,
            'return',
            $title,
            $message,
            [
                'link' => route('returns.show', $return->id),
                'priority' => 'high',
                'data' => [
                    'return_id' => $return->id,
                    'status' => $status,
                ]
            ]
        );
    }

    /**
     * Notification pour nouveau message
     */
    public function notifyNewMessage($message, $recipient)
    {
        $this->notify(
            $recipient,
            'message',
            'Nouveau message',
            "Vous avez reçu un nouveau message de {$message->sender->name}",
            [
                'link' => route('messages.index'),
                'priority' => 'normal',
                'data' => [
                    'message_id' => $message->id,
                    'sender_id' => $message->sender_id,
                ]
            ]
        );
    }

    /**
     * Notification pour stock faible
     */
    public function notifyLowStock($product, $adminUsers)
    {
        foreach ($adminUsers as $admin) {
            $this->notify(
                $admin,
                'product',
                'Stock faible',
                "Le produit '{$product->name}' a un stock faible ({$product->stock} unités)",
                [
                    'link' => route('admin.products.edit', $product->id),
                    'priority' => 'high',
                    'data' => [
                        'product_id' => $product->id,
                        'stock' => $product->stock,
                    ]
                ]
            );
        }
    }

    /**
     * Notification système
     */
    public function notifySystem($users, string $title, string $message, string $priority = 'normal')
    {
        if (!is_array($users)) {
            $users = [$users];
        }

        foreach ($users as $user) {
            $this->notify(
                $user,
                'system',
                $title,
                $message,
                [
                    'priority' => $priority,
                ]
            );
        }
    }
}
