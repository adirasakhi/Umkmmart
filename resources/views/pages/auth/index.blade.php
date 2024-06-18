<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.auth.css') }}">
    <title>Halaman Login Modern | AsmrProg</title>
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="{{ route('registerAction') }}" method="POST">
                @csrf
                <h1>Daftar Akun</h1>
                <span>atau gunakan email Anda untuk mendaftar</span>
                <input type="text" name="name" placeholder="Nama" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Kata Sandi" required>
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Kata Sandi" required>
                <input type="text" name="address" placeholder="Alamat">
                <input type="text" name="phone" placeholder="Telepon">
                <button type="submit">Daftar</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="{{ route('loginAction') }}" method="POST">
                @csrf
                <h1>Masuk</h1>
                @if ($errors->has('email'))
                    <div class="alert alert-danger">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                <input type="password" name="password" placeholder="Kata Sandi" required>
                <a href="#">Lupa Kata Sandi Anda?</a>
                <button type="submit">Masuk</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Selamat Datang Kembali!</h1>
                    <p>Masukkan detail pribadi Anda untuk menggunakan semua fitur situs</p>
                    <button class="hidden" id="login">Masuk</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Halo, Teman!</h1>
                    <p>Daftarkan detail pribadi Anda untuk menggunakan semua fitur situs</p>
                    <button class="hidden" id="register">Daftar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        const container = document.getElementById('container');
        const registerBtn = document.getElementById('register');
        const loginBtn = document.getElementById('login');

        // Check action from the server
        const action = '{{ $action }}';
        if (action === 'register') {
            container.classList.add("active");
            history.pushState(null, null, '/register');
        } else {
            container.classList.remove("active");
            history.pushState(null, null, '/login');
        }

        registerBtn.addEventListener('click', () => {
            container.classList.add("active");
            history.pushState(null, null, '/register');
        });

        loginBtn.addEventListener('click', () => {
            container.classList.remove("active");
            history.pushState(null, null, '/login');
        });
    </script>
</body>
</html>
