
@extends('layouts.app')

@section('title', 'Toko Online')

@section('content')
<div class="card">
    <h1>Selamat Datang di Toko Online</h1>

    <p>Halaman utama toko berhasil dibuka.</p>

    @auth
        <p>Halo, {{ auth()->user()->name }}!</p>
    @else
        <p>Silakan login atau registrasi untuk melanjutkan.</p>
    @endauth
</div>
@endsection
