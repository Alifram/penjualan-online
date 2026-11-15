<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
</head>
<body>
    <h1>Registrasi Pelanggan</h1>

    <form method="POST" action="{{ route('register.store') }}">
        @csrf

        <label>Nama</label>
        <input type="text" name="name" value="{{ old('name') }}" required>

        <br><br>

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>

        <br><br>

        <label>Password</label>
        <input type="password" name="password" required>

        <br><br>

        <label>Konfirmasi Password</label>
        <input type="password" name="password_confirmation" required>

        <br><br>

        <button type="submit">Daftar</button>
    </form>

    <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p style="color:red">{{ $error }}</p>
        @endforeach
    @endif
</body>
</html>