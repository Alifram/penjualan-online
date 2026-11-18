<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStockInRequest;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StockController extends Controller
{
    public function index(Request $request): View
    {
        $movements = StockMovement::with(['product', 'user'])
            ->when($request->filled('product_id'), function ($query) use ($request) {
                $query->where('product_id', $request->product_id);
            })
            ->when($request->filled('type'), function ($query) use ($request) {
                $query->where('type', $request->type);
            })
            ->latest('movement_at')
            ->paginate(20)
            ->withQueryString();

        $products = Product::orderBy('name')->get();

        return view('admin.stock.index', compact('movements', 'products'));
    }

    public function create(): View
    {
        $products = Product::orderBy('name')->get();

        return view('admin.stock.create', compact('products'));
    }

    public function store(StoreStockInRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $product = Product::whereKey($request->integer('product_id'))
                ->lockForUpdate()
                ->firstOrFail();

            $quantity = $request->integer('quantity');

            $product->increment('stock', $quantity);

            StockMovement::create([
                'product_id' => $product->id,
                'user_id' => $request->user()->id,
                'type' => 'IN',
                'quantity' => $quantity,
                'unit_cost' => $request->input('unit_cost'),
                'reference' => $request->input('reference'),
                'note' => $request->input('note'),
                'movement_at' => $request->date('movement_at') ?? now(),
            ]);
        });

        return redirect()
            ->route('admin.stock.index')
            ->with('success', 'Barang masuk dicatat dan stok bertambah.');
    }
}