<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    private function cartData(): array
    {
        $cart = session('cart', []);
        $items = collect();
        $subtotal = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);

            if (!$product || !$product->is_active) {
                continue;
            }

            $lineTotal = $product->price * $quantity;
            $subtotal += $lineTotal;

            $items->push([
                'product' => $product,
                'quantity' => $quantity,
                'lineTotal' => $lineTotal,
            ]);
        }

        return compact('items', 'subtotal');
    }

    public function index(): View
    {
        return view('cart.index', $this->cartData());
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        abort_unless($product->is_active, 404);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = session('cart', []);
        $newQuantity = ($cart[$product->id] ?? 0) + $validated['quantity'];

        if ($newQuantity > $product->stock) {
            return back()->withErrors([
                'quantity' => 'Jumlah produk melebihi stok yang tersedia.',
            ]);
        }

        $cart[$product->id] = $newQuantity;
        session(['cart' => $cart]);

        return redirect()->route('cart.index')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        if ($validated['quantity'] > $product->stock) {
            return back()->withErrors([
                'quantity' => 'Jumlah produk melebihi stok yang tersedia.',
            ]);
        }

        $cart = session('cart', []);

        if (array_key_exists($product->id, $cart)) {
            $cart[$product->id] = $validated['quantity'];
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $cart = session('cart', []);
        unset($cart[$product->id]);

        session(['cart' => $cart]);

        return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}
