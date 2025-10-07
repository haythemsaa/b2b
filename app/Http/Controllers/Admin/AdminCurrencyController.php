<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class AdminCurrencyController extends Controller
{
    /**
     * Display a listing of currencies.
     */
    public function index()
    {
        $currencies = Currency::orderBy('position')->get();

        $stats = [
            'total' => Currency::count(),
            'active' => Currency::where('is_active', true)->count(),
            'default' => Currency::where('is_default', true)->first(),
        ];

        return view('admin.currencies.index', compact('currencies', 'stats'));
    }

    /**
     * Show the form for creating a new currency.
     */
    public function create()
    {
        return view('admin.currencies.create');
    }

    /**
     * Store a newly created currency.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|size:3|unique:currencies,code',
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
            'decimal_places' => 'required|integer|min:0|max:4',
            'format' => 'required|string',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
            'position' => 'integer|min:0',
        ]);

        // Si cette devise est définie comme défaut, retirer le flag des autres
        if ($request->is_default) {
            Currency::where('is_default', true)->update(['is_default' => false]);
        }

        $currency = Currency::create($validated);

        return redirect()->route('admin.currencies.index')
            ->with('success', "Devise {$currency->code} créée avec succès.");
    }

    /**
     * Display the specified currency.
     */
    public function show(Currency $currency)
    {
        $currency->load(['exchangeRatesFrom', 'exchangeRatesTo']);

        // Taux de change récents
        $recentRates = ExchangeRate::where('from_currency', $currency->code)
            ->orWhere('to_currency', $currency->code)
            ->with(['fromCurrency', 'toCurrency'])
            ->latest('date')
            ->limit(20)
            ->get();

        return view('admin.currencies.show', compact('currency', 'recentRates'));
    }

    /**
     * Show the form for editing the specified currency.
     */
    public function edit(Currency $currency)
    {
        return view('admin.currencies.edit', compact('currency'));
    }

    /**
     * Update the specified currency.
     */
    public function update(Request $request, Currency $currency)
    {
        $validated = $request->validate([
            'code' => 'required|string|size:3|unique:currencies,code,' . $currency->id,
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
            'decimal_places' => 'required|integer|min:0|max:4',
            'format' => 'required|string',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
            'position' => 'integer|min:0',
        ]);

        // Si cette devise est définie comme défaut, retirer le flag des autres
        if ($request->is_default && !$currency->is_default) {
            Currency::where('is_default', true)->update(['is_default' => false]);
        }

        $currency->update($validated);

        return redirect()->route('admin.currencies.index')
            ->with('success', "Devise {$currency->code} mise à jour avec succès.");
    }

    /**
     * Remove the specified currency.
     */
    public function destroy(Currency $currency)
    {
        if ($currency->is_default) {
            return back()->with('error', 'La devise par défaut ne peut pas être supprimée.');
        }

        $code = $currency->code;
        $currency->delete();

        return redirect()->route('admin.currencies.index')
            ->with('success', "Devise {$code} supprimée avec succès.");
    }

    /**
     * Display exchange rates management.
     */
    public function rates()
    {
        $currencies = Currency::active()->orderBy('position')->get();

        $rates = ExchangeRate::with(['fromCurrency', 'toCurrency'])
            ->whereDate('date', Carbon::today())
            ->get();

        return view('admin.currencies.rates', compact('currencies', 'rates'));
    }

    /**
     * Update exchange rates manually.
     */
    public function updateRates(Request $request)
    {
        $validated = $request->validate([
            'rates' => 'required|array',
            'rates.*.from_currency' => 'required|exists:currencies,code',
            'rates.*.to_currency' => 'required|exists:currencies,code',
            'rates.*.rate' => 'required|numeric|min:0',
        ]);

        $count = 0;
        foreach ($validated['rates'] as $rateData) {
            ExchangeRate::updateOrCreateRate(
                $rateData['from_currency'],
                $rateData['to_currency'],
                $rateData['rate'],
                'manual'
            );
            $count++;
        }

        return back()->with('success', "{$count} taux de change mis à jour avec succès.");
    }

    /**
     * Fetch exchange rates from external API.
     */
    public function fetchRates(Request $request)
    {
        $baseCurrency = $request->input('base_currency', 'TND');

        try {
            // Utiliser une API de taux de change (exemple: exchangerate-api.com)
            // NOTE: Remplacer YOUR_API_KEY par une vraie clé API
            $response = Http::get("https://api.exchangerate-api.com/v4/latest/{$baseCurrency}");

            if ($response->successful()) {
                $data = $response->json();
                $rates = $data['rates'];

                $count = 0;
                $currencies = Currency::active()->pluck('code')->toArray();

                foreach ($rates as $currencyCode => $rate) {
                    if (in_array($currencyCode, $currencies) && $currencyCode !== $baseCurrency) {
                        ExchangeRate::updateOrCreateRate(
                            $baseCurrency,
                            $currencyCode,
                            $rate,
                            'api'
                        );
                        $count++;
                    }
                }

                return back()->with('success', "{$count} taux de change récupérés depuis l'API.");
            }

            return back()->with('error', 'Erreur lors de la récupération des taux de change.');

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    /**
     * Get exchange rate for AJAX.
     */
    public function getRate(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $date = $request->input('date');

        $rate = ExchangeRate::getRate($from, $to, $date);

        if ($rate) {
            return response()->json([
                'success' => true,
                'rate' => $rate,
                'from' => $from,
                'to' => $to,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Taux de change non trouvé',
        ], 404);
    }

    /**
     * Convert amount between currencies (AJAX).
     */
    public function convert(Request $request)
    {
        $amount = $request->input('amount');
        $from = $request->input('from');
        $to = $request->input('to');

        $converted = ExchangeRate::convert($amount, $from, $to);

        if ($converted !== null) {
            $toCurrency = Currency::where('code', $to)->first();

            return response()->json([
                'success' => true,
                'amount' => $amount,
                'from' => $from,
                'to' => $to,
                'converted' => $converted,
                'formatted' => $toCurrency ? $toCurrency->formatAmount($converted) : $converted,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Conversion impossible',
        ], 400);
    }

    /**
     * Set default currency.
     */
    public function setDefault(Currency $currency)
    {
        Currency::where('is_default', true)->update(['is_default' => false]);
        $currency->update(['is_default' => true]);

        return back()->with('success', "{$currency->code} définie comme devise par défaut.");
    }

    /**
     * Toggle currency active status.
     */
    public function toggleActive(Currency $currency)
    {
        $currency->update(['is_active' => !$currency->is_active]);

        $status = $currency->is_active ? 'activée' : 'désactivée';
        return back()->with('success', "Devise {$currency->code} {$status}.");
    }
}
