<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/btn.css') }}">
    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            {{-- Sidebar Include --}}
            @include('layouts.sidebar')

            {{-- Main Content --}}
            <main class="col-12 col-lg-10 px-3 px-lg-4 offset-lg-2">
                <nav class="navbar navbar-light bg-white py-3 mb-4 d-none d-lg-flex">
                    <span class="navbar-brand mb-0 h1">@yield('page_title')</span>
                    <div class="d-flex align-items-center gap-2">
                        @if(Auth::user())
                            <span class="badge bg-primary text-white mt-1" style="font-size:0.85em;">{{ ucfirst(Auth::user()->role) }}</span>
                        @endif
                        <span class="me-3">Hello, {{ Auth::user()->name ?? 'User' }}</span>
                        <img src="https://i.pravatar.cc/40" class="rounded-circle me-2" alt="User">
                    </div>
                </nav>
                {{-- Konten halaman --}}
                @yield('content')
            </main>
        </div>
        <footer class="bg-white border-top py-3 mt-4">
            <div class="container-fluid text-end small text-muted">
                &copy; {{ date('Y') }} MagangApp. All rights reserved.
            </div>
        </footer>
    </div>

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts') {{-- Optional tambahan JS --}}
</body>
</html>
