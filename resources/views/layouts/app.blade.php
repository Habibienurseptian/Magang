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
                            @php
                                $role = Auth::user()->role;
                                $roleColor = 'bg-secondary';
                                if($role === 'admin') $roleColor = 'bg-danger';
                                elseif($role === 'inspektur') $roleColor = 'bg-primary';
                            @endphp
                            <span class="badge {{ $roleColor }} text-white mt-1" style="font-size:0.85em; text-transform:capitalize;">{{ $role }}</span>
                        @endif
                        <span class="me-3">Hello, {{ Auth::user()->name ?? 'User' }}</span>
                        <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=4f8cff&color=fff&size=40' }}" alt="Avatar" class="rounded-circle shadow" style="object-fit:cover;">
                    </div>
                </nav>
                {{-- Konten halaman --}}
                @yield('content')
            </main>
        </div>
        <footer class="bg-white border-top py-3 mt-4">
            <div class="container-fluid text-end small text-muted">
                &copy; {{ date('Y') }} PelaonApp. All rights reserved.
            </div>
        </footer>
    </div>

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts') {{-- Optional tambahan JS --}}
</body>
</html>
