<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ProductStockResource;
use App\Models\Product;

class ProductStockController extends Controller
{
    public function show(Product $product)
    {
        return ProductStockResource::make($product)
            ->additional([
                'message' => 'Stok produk berhasil diambil.',
            ]);
    }
}
