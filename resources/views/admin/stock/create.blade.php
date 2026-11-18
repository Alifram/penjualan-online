@extends('layouts.admin')

@section('title', 'Barang Masuk')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Catat Barang Masuk</h1>

        <a href="{{ route('admin.stock.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.stock.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="product_id" class="form-label">Produk</label>
                    <select name="product_id" id="product_id" class="form-select" required>
                        <option value="">-- Pilih Produk --</option>

                        @foreach ($products as $product)
                            <option value="{{ $product->id }}"
                                @selected(old('product_id') == $product->id)>
                                {{ $product->sku }} - {{ $product->name }}
                                (Stok saat ini: {{ $product->stock }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Jumlah Barang Masuk</label>
                    <input
                        type="number"
                        name="quantity"
                        id="quantity"
                        class="form-control"
                        min="1"
                        value="{{ old('quantity') }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="unit_cost" class="form-label">Harga Modal per Unit</label>
                    <input
                        type="number"
                        name="unit_cost"
                        id="unit_cost"
                        class="form-control"
                        min="0"
                        step="0.01"
                        value="{{ old('unit_cost') }}"
                    >
                </div>

                <div class="mb-3">
                    <label for="reference" class="form-label">Referensi / Nomor Invoice</label>
                    <input
                        type="text"
                        name="reference"
                        id="reference"
                        class="form-control"
                        maxlength="120"
                        value="{{ old('reference') }}"
                    >
                </div>

                <div class="mb-3">
                    <label for="movement_at" class="form-label">Tanggal Barang Masuk</label>
                    <input
                        type="datetime-local"
                        name="movement_at"
                        id="movement_at"
                        class="form-control"
                        value="{{ old('movement_at', now()->format('Y-m-d\TH:i')) }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="note" class="form-label">Catatan</label>
                    <textarea
                        name="note"
                        id="note"
                        class="form-control"
                        rows="3"
                    >{{ old('note') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    Simpan Barang Masuk
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
