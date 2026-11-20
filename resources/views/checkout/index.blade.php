@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<h1>Checkout</h1>

<div class="grid">
    <section class="card">
        <h2>Informasi Pengiriman</h2>

        <form method="POST" action="{{ route('checkout.store') }}">
            @csrf

            <div class="form-group">
                <label for="recipient_name">Nama Penerima</label>
                <input
                    type="text"
                    id="recipient_name"
                    name="recipient_name"
                    value="{{ old('recipient_name', auth()->user()->name) }}"
                    required
                >
                @error('recipient_name')
                    <small class="error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Nomor Telepon</label>
                <input
                    type="text"
                    id="phone"
                    name="phone"
                    value="{{ old('phone') }}"
                    required
                >
                @error('phone')
                    <small class="error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="address">Alamat Lengkap</label>
                <textarea
                    id="address"
                    name="address"
                    rows="4"
                    required
                >{{ old('address') }}</textarea>
                @error('address')
                    <small class="error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="shipping_service_id">Layanan Pengiriman</label>
                <select
                    id="shipping_service_id"
                    name="shipping_service_id"
                    required
                >
                    <option value="">-- Pilih Pengiriman --</option>

                    @foreach($shippingServices as $service)
                        <option
                            value="{{ $service->id }}"
                            @selected(old('shipping_service_id') == $service->id)
                        >
                            {{ $service->courier }}
                            {{ $service->service }}
                            - Rp{{ number_format($service->cost, 0, ',', '.') }}
                            ({{ $service->eta }})
                        </option>
                    @endforeach
                </select>
                @error('shipping_service_id')
                    <small class="error">{{ $message }}</small>
                @enderror
            </div>

            @error('cart')
                <p class="error">{{ $message }}</p>
            @enderror

            <button type="submit">Buat Pesanan</button>
        </form>
    </section>

    <section class="card">
        <h2>Ringkasan Belanja</h2>

        @foreach($items as $item)
            <div class="cart-item">
                <strong>{{ $item['product']->name }}</strong>
                <p>
                    {{ $item['quantity'] }} x
                    Rp{{ number_format($item['product']->price, 0, ',', '.') }}
                </p>
                <p>
                    Subtotal:
                    Rp{{ number_format($item['lineTotal'], 0, ',', '.') }}
                </p>
            </div>
        @endforeach

        <hr>

        <h3>
            Subtotal:
            Rp{{ number_format($subtotal, 0, ',', '.') }}
        </h3>

        <p>Ongkos kirim dihitung berdasarkan layanan yang dipilih.</p>
    </section>
</div>
@endsection
