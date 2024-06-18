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
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>atau gunakan email Anda untuk mendaftar</span>
                <input type="text" name="name" placeholder="Nama" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Kata Sandi" required>
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Kata Sandi" required>
                {{-- <input type="text" name="address" class="form-control">
                <input type="tel" id="phone" name="phone" placeholder="Telepon">
                <input type="file" name="photo" class="form-control">
                <input type="number" name="social_media_id" class="form-control">
                <input type="number" name="role_id" class="form-control"> --}}

                <button>Daftar</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="{{ route('loginAction') }}" method="POST">
                @csrf
                <h1>Masuk</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>atau gunakan email Anda untuk masuk</span>

                <!-- Tampilkan pesan error jika ada -->
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

    <script src="{{ asset('assets/js/scripts-auth.js') }}"></script>

</body>

</html>
