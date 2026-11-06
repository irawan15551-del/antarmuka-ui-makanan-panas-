<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SlotMappingController extends Controller
{
    private const SLOTS = ['A01', 'A02', 'A03', 'A04', 'A05', 'A06'];

    public function index(): View
    {
        $slots = self::SLOTS;
        $products = Product::query()
            ->where('status', 'active')
            ->orderBy('name')
            ->get(['id', 'name', 'slot']);
        $productsBySlot = $products->whereNotNull('slot')->keyBy('slot');

        return view('slots.index', compact('slots', 'products', 'productsBySlot'));
    }

    public function update(Request $request): RedirectResponse
    {
        $rules = [
            'slots' => ['required', 'array:'.implode(',', self::SLOTS)],
        ];

        foreach (self::SLOTS as $slot) {
            $rules['slots.'.$slot] = [
                'present',
                'nullable',
                'integer',
                Rule::exists('products', 'id')
                    ->where('status', 'active')
                    ->whereNull('deleted_at'),
            ];
        }

        $validated = $request->validate($rules);
        $productIds = array_values(array_filter(
            $validated['slots'],
            static fn (?int $productId): bool => $productId !== null,
        ));

        if (count($productIds) !== count(array_unique($productIds))) {
            return back()
                ->withErrors(['slots' => 'Satu produk hanya dapat dipetakan ke satu slot.'])
                ->withInput();
        }

        DB::transaction(function () use ($validated): void {
            Product::query()->whereNotNull('slot')->update(['slot' => null]);

            foreach ($validated['slots'] as $slot => $productId) {
                if ($productId !== null) {
                    Product::query()->whereKey($productId)->update(['slot' => $slot]);
                }
            }
        });

        return redirect()
            ->route('slots.index')
            ->with('success', 'Pemetaan slot berhasil diperbarui.');
    }
}
