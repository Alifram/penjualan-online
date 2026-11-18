@extends('layouts.admin')

@section('title', 'Layanan Ekspedisi')

@section('content')
<div class="container">
    <h1 class="mb-4">Layanan Ekspedisi</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            Tambah Layanan Ekspedisi
        </div>

        <div class="card-body">
            <form action="{{ route('admin.shipping.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="courier" class="form-label">
                            Nama Ekspedisi
                        </label>
                        <input
                            type="text"
                            name="courier"
                            id="courier"
                            class="form-control"
                            maxlength="80"
                            value="{{ old('courier') }}"
                            placeholder="Contoh: JNE"
                            required
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="service" class="form-label">
                            Jenis Layanan
                        </label>
                        <input
                            type="text"
                            name="service"
                            id="service"
                            class="form-control"
                            maxlength="80"
                            value="{{ old('service') }}"
                            placeholder="Contoh: REG"
                            required
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="eta" class="form-label">
                            Estimasi Pengiriman
                        </label>
                        <input
                            type="text"
                            name="eta"
                            id="eta"
                            class="form-control"
                            maxlength="80"
                            value="{{ old('eta') }}"
                            placeholder="Contoh: 2-4 hari"
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="cost" class="form-label">
                            Biaya Pengiriman (Rp)
                        </label>
                        <input
                            type="number"
                            name="cost"
                            id="cost"
                            class="form-control"
                            min="0"
                            step="0.01"
                            value="{{ old('cost') }}"
                            placeholder="Contoh: 18000"
                            required
                        >
                    </div>
                </div>

                <input type="hidden" name="is_active" value="1">

                <button type="submit" class="btn btn-primary">
                    Simpan Layanan
                </button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Daftar Layanan Ekspedisi
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Ekspedisi</th>
                            <th>Layanan</th>
                            <th>Estimasi</th>
                            <th>Biaya</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($services as $service)
                            <tr>
                                <td>{{ $service->courier }}</td>
                                <td>{{ $service->service }}</td>
                                <td>{{ $service->eta ?? '-' }}</td>
                                <td>Rp{{ number_format($service->cost, 0, ',', '.') }}</td>
                                <td>
                                    @if ($service->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($service->is_active)
                                        <form
                                            action="{{ route('admin.shipping.destroy', $service) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menonaktifkan layanan ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Nonaktifkan
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    Belum ada layanan ekspedisi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection