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
            <form action="{{ route('registerAction') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h1>Daftar Akun</h1>
                @if (session('status'))
                    <div class="alert alert-success">
                        {!! session('message') !!}
                    </div>
                @endif

                <div class="error-message">
                    <input type="text" name="name" placeholder="Nama" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <div class="error">{{ $errors->first('name') }}</div>
                    @endif

                    <input type="email" name="email" placeholder="Email"
                        value="{{ session('action') == 'register' ? old('email') : '' }}">
                    @if ($errors->has('email'))
                        <div class="error">{{ $errors->first('email') }}</div>
                    @endif

                    <input type="password" name="password" placeholder="Kata Sandi">
                    @if ($errors->has('password'))
                        <div class="error">{{ $errors->first('password') }}</div>
                    @endif

                    <input type="password" name="password_confirmation" placeholder="Konfirmasi Kata Sandi"
                        autocomplete="new-password">
                    @if ($errors->has('password_confirmation'))
                        <div class="error">{{ $errors->first('password_confirmation') }}</div>
                    @endif

                    <div style="display: flex; align-items: center;">
                        <span
                            style="padding: 11px 0px 10px 11px;  background-color: #eee; border-radius: 7px 0 0 7px; color: grey">+62</span>
                        <input type="tel" name="phone" placeholder="No. Telepon"
                            value="{{ old('phone') ? substr(old('phone'), 3) : '' }}" pattern="[0-9]+"
                            title="Masukkan hanya angka" style="flex: 1; padding: 10px; border-radius: 0 7px 7px 0;">
                    </div>
                    @if ($errors->has('phone'))
                        <div class="error">{{ $errors->first('phone') }}</div>
                    @endif

                    <input type="file" name="support_documents" id="support_documents" accept=".jpeg,.png,.jpg,.pdf"
                        style="color: #404040">
                    <label for="support_documents" style="color: #404040">
                        Dokumen Pendukung: KTP, Surat Domisili, Surat Keterangan Usaha<br>
                        <small>Jenis file yang dapat dikirimkan: jpeg, png, jpg, pdf</small>
                    </label>
                    @if ($errors->has('support_documents'))
                        <div class="error">{{ $errors->first('support_documents') }}</div>
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
                    <div class="alert alert-success error-message">
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

        // Prevent non-numeric input for phone
        document.querySelector('input[name="phone"]').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>

</html>
