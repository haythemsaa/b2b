<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture {{ $invoice->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10pt;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            margin-bottom: 30px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
        }

        .header-row {
            display: table;
            width: 100%;
        }

        .header-col {
            display: table-cell;
            vertical-align: top;
        }

        .header-col.left {
            width: 50%;
        }

        .header-col.right {
            width: 50%;
            text-align: right;
        }

        .company-name {
            font-size: 24pt;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 10px;
        }

        .company-info {
            font-size: 9pt;
            color: #666;
            line-height: 1.4;
        }

        .invoice-title {
            font-size: 28pt;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 10px;
        }

        .invoice-meta {
            font-size: 9pt;
            line-height: 1.6;
        }

        .invoice-meta strong {
            font-weight: bold;
            color: #333;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 9pt;
            font-weight: bold;
            margin-top: 10px;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-paid {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-overdue {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .status-cancelled {
            background-color: #f3f4f6;
            color: #6b7280;
        }

        .parties {
            display: table;
            width: 100%;
            margin: 30px 0;
        }

        .party {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding: 15px;
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
        }

        .party + .party {
            border-left: none;
        }

        .party-title {
            font-size: 11pt;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .party-content {
            font-size: 9pt;
            line-height: 1.6;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }

        .items-table thead {
            background-color: #2563eb;
            color: white;
        }

        .items-table th {
            padding: 12px 8px;
            text-align: left;
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .items-table th.text-center {
            text-align: center;
        }

        .items-table th.text-right {
            text-align: right;
        }

        .items-table tbody tr {
            border-bottom: 1px solid #e5e7eb;
        }

        .items-table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .items-table td {
            padding: 10px 8px;
            font-size: 9pt;
        }

        .items-table td.text-center {
            text-align: center;
        }

        .items-table td.text-right {
            text-align: right;
        }

        .product-name {
            font-weight: bold;
            color: #333;
        }

        .product-sku {
            font-size: 8pt;
            color: #6b7280;
        }

        .totals {
            margin-top: 20px;
            float: right;
            width: 300px;
        }

        .totals-table {
            width: 100%;
            font-size: 10pt;
        }

        .totals-table tr {
            border-bottom: 1px solid #e5e7eb;
        }

        .totals-table td {
            padding: 8px;
        }

        .totals-table td:first-child {
            font-weight: bold;
            color: #6b7280;
        }

        .totals-table td:last-child {
            text-align: right;
        }

        .totals-table tr.total-row {
            background-color: #2563eb;
            color: white;
            font-size: 12pt;
            font-weight: bold;
        }

        .totals-table tr.total-row td {
            padding: 12px 8px;
        }

        .notes {
            clear: both;
            margin-top: 40px;
            padding: 15px;
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
        }

        .notes-title {
            font-weight: bold;
            color: #92400e;
            margin-bottom: 5px;
        }

        .notes-content {
            font-size: 9pt;
            color: #78350f;
        }

        .payment-info {
            margin-top: 30px;
            padding: 20px;
            background-color: #dbeafe;
            border: 1px solid #2563eb;
            border-radius: 5px;
        }

        .payment-info-title {
            font-size: 11pt;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 10px;
        }

        .payment-info-content {
            font-size: 9pt;
            line-height: 1.6;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            font-size: 8pt;
            color: #6b7280;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        @page {
            margin: 20mm;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-row">
                <div class="header-col left">
                    <div class="company-name">{{ config('app.name', 'B2B Platform') }}</div>
                    <div class="company-info">
                        <strong>Adresse:</strong> [Votre Adresse Complète]<br>
                        <strong>Téléphone:</strong> [Votre Numéro]<br>
                        <strong>Email:</strong> [Votre Email]<br>
                        <strong>Matricule Fiscal:</strong> [Votre Matricule]
                    </div>
                </div>
                <div class="header-col right">
                    <div class="invoice-title">FACTURE</div>
                    <div class="invoice-meta">
                        <strong>N° Facture:</strong> {{ $invoice->invoice_number }}<br>
                        <strong>Date:</strong> {{ $invoice->invoice_date ? $invoice->invoice_date->format('d/m/Y') : ($invoice->issue_date ? $invoice->issue_date->format('d/m/Y') : 'N/A') }}<br>
                        <strong>Date d'échéance:</strong> {{ $invoice->due_date->format('d/m/Y') }}<br>
                        @if($invoice->order)
                            <strong>N° Commande:</strong> {{ $invoice->order->order_number }}
                        @endif
                    </div>
                    <span class="status-badge status-{{ $invoice->status }}">
                        {{ strtoupper($invoice->status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Parties -->
        <div class="parties">
            <div class="party">
                <div class="party-title">Facturé à</div>
                <div class="party-content">
                    @if($invoice->order && $invoice->order->user)
                        <strong>{{ $invoice->order->user->name }}</strong><br>
                        {{ $invoice->order->user->email }}<br>
                        @if($invoice->order->user->phone)
                            Tél: {{ $invoice->order->user->phone }}<br>
                        @endif
                        @if($invoice->order->user->company)
                            Société: {{ $invoice->order->user->company }}<br>
                        @endif
                    @else
                        <em>Informations client non disponibles</em>
                    @endif
                </div>
            </div>
            <div class="party">
                <div class="party-title">Informations Commande</div>
                <div class="party-content">
                    @if($invoice->order)
                        <strong>N° Commande:</strong> {{ $invoice->order->order_number }}<br>
                        <strong>Date Commande:</strong> {{ $invoice->order->created_at->format('d/m/Y') }}<br>
                        <strong>Statut:</strong> {{ ucfirst($invoice->order->status) }}<br>
                        @if($invoice->order->notes)
                            <strong>Notes:</strong> {{ Str::limit($invoice->order->notes, 50) }}
                        @endif
                    @else
                        <em>Commande non associée</em>
                    @endif
                </div>
            </div>
        </div>

        <!-- Items Table -->
        @if($invoice->order && $invoice->order->items->count() > 0)
        <table class="items-table">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th class="text-center">Quantité</th>
                    <th class="text-right">Prix Unitaire</th>
                    <th class="text-right">Total HT</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->order->items as $item)
                <tr>
                    <td>
                        <div class="product-name">{{ $item->product->name ?? 'Produit supprimé' }}</div>
                        <div class="product-sku">SKU: {{ $item->product->sku ?? 'N/A' }}</div>
                    </td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format($item->price, 2, ',', ' ') }} TND</td>
                    <td class="text-right"><strong>{{ number_format($item->total, 2, ',', ' ') }} TND</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- Totals -->
        <div class="clearfix">
            <div class="totals">
                <table class="totals-table">
                    <tr>
                        <td>Sous-total HT:</td>
                        <td>{{ number_format($invoice->subtotal, 2, ',', ' ') }} TND</td>
                    </tr>
                    <tr>
                        <td>TVA (19%):</td>
                        <td>{{ number_format($invoice->tax, 2, ',', ' ') }} TND</td>
                    </tr>
                    <tr class="total-row">
                        <td>TOTAL TTC:</td>
                        <td>{{ number_format($invoice->total, 2, ',', ' ') }} TND</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Notes -->
        @if($invoice->notes)
        <div class="notes">
            <div class="notes-title">Notes:</div>
            <div class="notes-content">{{ $invoice->notes }}</div>
        </div>
        @endif

        <!-- Payment Info -->
        <div class="payment-info">
            <div class="payment-info-title">Informations de Paiement</div>
            <div class="payment-info-content">
                @if($invoice->status == 'paid')
                    <strong>✓ Cette facture a été payée le {{ $invoice->paid_at ? $invoice->paid_at->format('d/m/Y à H:i') : 'N/A' }}</strong>
                @else
                    <strong>Cette facture est en attente de paiement</strong><br>
                    Date d'échéance: <strong>{{ $invoice->due_date->format('d/m/Y') }}</strong><br><br>
                    <strong>Moyens de paiement acceptés:</strong><br>
                    • Virement bancaire: [Vos coordonnées bancaires]<br>
                    • Chèque à l'ordre de: [Nom de votre société]<br>
                    • Carte bancaire (via notre plateforme en ligne)
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>
                <strong>{{ config('app.name', 'B2B Platform') }}</strong> - [Adresse] - Tél: [Téléphone] - Email: [Email]<br>
                Matricule Fiscal: [Matricule] - RCS: [Numéro RCS]<br>
                Capital social: [Montant] TND - TVA Intra: [Numéro TVA]
            </p>
            <p style="margin-top: 10px;">
                Facture générée électroniquement le {{ now()->format('d/m/Y à H:i') }}
            </p>
        </div>
    </div>
</body>
</html>
