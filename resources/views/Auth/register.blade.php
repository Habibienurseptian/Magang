<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    <div class="w-100 min-vh-100 d-flex align-items-center justify-content-center" style="background: none;">
        <div class="liquid-glass mx-auto w-100" style="max-width:400px;float:none;">
            <div class="text-center mb-4">
                <img src="{{ asset('images/logo1.png') }}" alt="Logo" width="56" height="56" class="mb-2" style="object-fit:contain;">
                <h4 class="fw-bold mb-0">Registrasi</h4>
                <p class="text-black mt-2 mb-0">Masukkan data untuk daftar akun.</p>
            </div>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="name" name="name" required placeholder="Nama lengkap">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="you@email.com">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div style="position:relative;">
                        <input type="password" class="form-control pr-5" id="password" name="password" required placeholder="Password" style="padding-right:2.5rem;">
                        <span onclick="togglePassword('password', 'togglePasswordIcon')" style="position:absolute;top:50%;right:0.75rem;transform:translateY(-50%);cursor:pointer;z-index:3;">
                            <i class="fa fa-eye" id="togglePasswordIcon"></i>
                        </span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <div style="position:relative;">
                        <input type="password" class="form-control pr-5" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi password" style="padding-right:2.5rem;">
                        <span onclick="togglePassword('password_confirmation', 'togglePasswordIcon2')" style="position:absolute;top:50%;right:0.75rem;transform:translateY(-50%);cursor:pointer;z-index:3;">
                            <i class="fa fa-eye" id="togglePasswordIcon2"></i>
                        </span>
                    </div>
                </div>
                <div class="d-grid gap-2 mb-2">
                    <button type="submit" class="btn btn-primary">Daftar</button>
                </div>
            </form>
            <div class="text-center mt-3">
                <span class="small text-secondary">Sudah punya akun?</span>
                <a href="{{ route('login') }}" class="small ms-1">Login</a>
            </div>
        </div>
    </div>
    <script>
function togglePassword(inputId, iconId) {
    const pwd = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
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
