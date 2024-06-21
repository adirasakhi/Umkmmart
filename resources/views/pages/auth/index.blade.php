<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.auth.css') }}">
    <title>Halaman Login Modern | AsmrProg</title>
    <style>
        .error-message {
            color: red;
            font-size: 0.675em;
        }
    </style>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="{{ route('registerAction') }}" method="POST">
                @csrf
                <h1>Daftar Akun</h1>
                @if (session('status'))
                    <div class="alert alert-succes">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="error-message">
                    <input type="text" name="name" placeholder="Nama" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        {{ $errors->first('name') }}
                    @endif

                    <input type="email" name="email" placeholder="Email"
                        value="{{ session('action') == 'register' ? old('email') : '' }}">
                    @if ($errors->has('email'))
                        {{ $errors->first('email') }}
                    @endif

                    <input type="password" name="password" placeholder="Kata Sandi">
                    @if ($errors->has('password'))
                        {{ $errors->first('password') }}
                    @endif

                    <input type="password" name="password_confirmation" placeholder="Konfirmasi Kata Sandi"
                        autocomplete="new-password">
                    @if ($errors->has('password_confirmation'))
                        {{ $errors->first('password_confirmation') }}
                    @endif

                    <input type="text" name="address" placeholder="Alamat" value="{{ old('address') }}">
                    @if ($errors->has('address'))
                        {{ $errors->first('address') }}
                    @endif

                    <input type="tel" name="phone" placeholder="Telepon" value="{{ old('phone') }}"
                        pattern="[0-9]+" title="Masukkan hanya angka">
                    @if ($errors->has('phone'))
                        {{ $errors->first('phone') }}
                    @endif
                </div>

                <button type="submit">Daftar</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="{{ route('loginAction') }}" method="POST">
                @csrf
                <h1>Masuk</h1>

                @if (session('status-login'))
                    <div class="alert alert-succes">
                        {{ session('message') }}
                    </div>
                @endif

                @if ($errors->has('email-login'))
                    <div class="alert alert-danger">
                        {{ $errors->first('email-login') }}
                    </div>
                @endif

                <input type="email" name="email" placeholder="Email" required
                    value="{{ session('action') == 'login' ? old('email') : '' }}">
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
        const action = '{{ session('action') }}';
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

        // Tambahkan event listener untuk mencegah input karakter non-angka
        document.querySelector('input[name="phone"]').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>

</html>
