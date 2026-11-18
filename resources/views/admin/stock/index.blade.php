@extends('layouts.admin')

@section('title', 'Histori Stok')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Histori Stok</h1>

        <a href="{{ route('admin.stock.create') }}" class="btn btn-primary">
            Barang Masuk
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('admin.stock.index') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="product_id" class="form-label">Produk</label>
            <select name="product_id" id="product_id" class="form-select">
                <option value="">Semua Produk</option>

                @foreach ($products as $product)
                    <option value="{{ $product->id }}"
                        @selected(request('product_id') == $product->id)>
                        {{ $product->sku }} - {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label for="type" class="form-label">Jenis Pergerakan</label>
            <select name="type" id="type" class="form-select">
                <option value="">Semua Jenis</option>
                <option value="IN" @selected(request('type') === 'IN')>
                    Barang Masuk
                </option>
                <option value="OUT" @selected(request('type') === 'OUT')>
                    Barang Keluar
                </option>
            </select>
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-secondary">
                Filter
            </button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Produk</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Referensi</th>
                    <th>Admin</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($movements as $movement)
                    <tr>
                        <td>{{ $movement->movement_at->format('d-m-Y H:i') }}</td>
                        <td>{{ $movement->product->name }}</td>
                        <td>{{ $movement->type }}</td>
                        <td>{{ $movement->quantity }}</td>
                        <td>{{ $movement->reference ?? '-' }}</td>
                        <td>{{ $movement->user->name ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            Belum ada histori stok.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $movements->links() }}
</div>
@endsection
