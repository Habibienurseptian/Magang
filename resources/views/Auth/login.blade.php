<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <!-- Jika menggunakan .png -->
    <link rel="icon" href="{{ asset('images/logo1.png') }}" type="image/png">

    <!-- Jika ingin dukungan Apple -->
    <link rel="apple-touch-icon" href="{{ asset('images/logo1.png') }}">
</head>
<body>
    <div class="w-100 min-vh-100 d-flex align-items-center justify-content-center" style="background: none;">
        <div class="liquid-glass mx-auto w-100" style="max-width:400px;float:none;">
            <div class="text-center mb-4">
                <img src="{{ asset('images/logo1.png') }}" alt="Logo" width="56" height="56" class="mb-2" style="object-fit:contain;">
                <h4 class="fw-bold mb-0">Yuk, Masuk Dulu!</h4>
                <p class="text-black mt-2 mb-0">Belajar skill baru dan siapkan masa depan kariermu.</p>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                @if(session('success'))
                    <div class="alert alert-success text-center py-2 mb-3">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger text-center py-2 mb-3">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required autofocus placeholder="Masukkan Email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div style="position:relative;">
                        <input type="password" class="form-control pr-5" id="password" name="password" required placeholder="Password" style="padding-right:2.5rem;">
                        <span onclick="togglePassword()" style="position:absolute;top:50%;right:0.75rem;transform:translateY(-50%);cursor:pointer;z-index:3;">
                            <i class="fa fa-eye" id="togglePasswordIcon"></i>
                        </span>
                    </div>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <div class="text-end mt-3">
                <a href="{{ route('password.forgot.direct') }}" class="small">Lupa Password?</a>
            </div>
        </div>
    </div>
<script>
function togglePassword() {
    const pwd = document.getElementById('password');
    const icon = document.getElementById('togglePasswordIcon');
    if (pwd.type === 'password') {
        pwd.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        pwd.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
</body>
</html>