<!-- Navbar (Desktop)-->
<nav class="col-lg-2 d-none d-lg-block sidebar py-4 position-fixed bg-dark text-white" style="height:100vh;z-index:1040;">
        <div class="text-center mb-4">
            <img src="{{ asset('images/logo1.png') }}" alt="Logo MyApp" style="height: 60px;">
            <h4 class="mt-2">PelaonApp</h4>
        </div>
    <ul class="nav flex-column">
        @if(Auth::user() && Auth::user()->role === 'admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard.admin') }}"><i class="fas fa-home me-2"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.users.index') }}"><i class="fas fa-users me-2"></i> Pengguna</a>
            </li>
            <li><hr class="my-3 text-white" style="border-top: 2px solid #fff; opacity:1;"></li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-user me-2"></i> Profile</a>
            </li> -->
        @elseif(Auth::user() && Auth::user()->role === 'inspektur')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard.inspektur') }}"><i class="fas fa-home me-2"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('inspektur.learning.index') }}"><i class="fas fa-route me-2"></i> Learning Skill</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('inspektur.kompetensi.index') }}"><i class="fas fa-clipboard-check me-2"></i> Uji Kompetensi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('inspektur.bidang.index') }}"><i class="fas fa-layer-group me-2"></i> Bidang Keahlian</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('inspektur.sertifikat.index') }}"><i class="fas fa-certificate me-2"></i> Sertifikat</a>
            </li>
            <li><hr class="my-3 text-white" style="border-top: 2px solid #fff; opacity:1;"></li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-user me-2"></i> Profile</a>
            </li> -->
        @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard.users') }}"><i class="fas fa-home me-2"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.learning.index') }}"><i class="fas fa-route me-2"></i> Learning Skill</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.kompetensi.index') }}"><i class="fas fa-clipboard-check me-2"></i> Uji Kompetensi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user.sertifikat') }}"><i class="fas fa-certificate me-2"></i> Sertifikat</a>
            </li>
            <li><hr class="my-3 text-white" style="border-top: 2px solid #fff; opacity:1;"></li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.profile.index') }}"><i class="fas fa-user me-2"></i> Profile</a>
            </li>
        @endif
    </ul>
    <div class="px-3 mt-3">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm w-100"><i class="fas fa-sign-out-alt me-1"></i> Logout</button>
        </form>
    </div>
</nav>
<!-- Navbar (Mobile & Tablet) -->
<nav class="navbar navbar-dark bg-dark d-lg-none">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('images/logo1.png') }}" alt="Logo" style="height: 30px;">PelaonApp
        </a>
        <button class="navbar-toggler" type="button" id="sidebarToggle" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <!-- Overlay -->
    <div id="sidebarOverlay" class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50" style="z-index:1049;display:none;"></div>
    <div id="mobileSidebar" class="mobile-sidebar bg-dark text-white position-fixed top-0 start-0 vh-100" style="z-index:1050;transform:translateX(-100%);transition:transform 0.3s cubic-bezier(.4,0,.2,1);min-width:220px;max-width:85vw;">
        <div class="d-flex flex-column h-100">
            <div class="d-flex align-items-center justify-content-between p-3 border-bottom border-secondary">
                <span class="fw-bold"><img src="{{ asset('images/logo1.png') }}" alt="Logo" style="height: 30px;">PelaonApp</span>
                <button class="btn btn-link text-white fs-3 p-0" id="sidebarClose" aria-label="Close menu"><i class="fas fa-times"></i></button>
            </div>
            <ul class="navbar-nav px-3 mt-3">
                @if(Auth::user() && Auth::user()->role === 'admin')
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="{{ route('dashboard.admin') }}"><i class="fas fa-home me-2"></i> Dashboard</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="{{ route('admin.users.index') }}"><i class="fas fa-users me-2"></i> Pengguna</a>
                    </li>
                    <!-- <li><hr class="my-2 text-white" style="border-top: 2px solid #fff; opacity:1;"></li> -->
                    <!-- <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="#"><i class="fas fa-user me-2"></i> Profile</a>
                    </li> -->
                @elseif(Auth::user() && Auth::user()->role === 'inspektur')
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="{{ route('dashboard.inspektur') }}"><i class="fas fa-home me-2"></i> Dashboard</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="{{ route('inspektur.learning.index') }}"><i class="fas fa-route me-2"></i> Learning Skill</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="{{ route('inspektur.kompetensi.index') }}"><i class="fas fa-clipboard-check me-2"></i> Uji Kompetensi</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="{{ route('inspektur.bidang.index') }}  "><i class="fas fa-layer-group me-2"></i> Bidang Keahlian</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="{{ route('inspektur.sertifikat.index') }}"><i class="fas fa-certificate me-2"></i> Sertifikat</a>
                    </li>
                    <!-- <li><hr class="my-2 text-white" style="border-top: 2px solid #fff; opacity:1;"></li> -->
                    <!-- <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="#"><i class="fas fa-user me-2"></i> Profile</a>
                    </li> -->
                @else
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="{{ route('dashboard.users') }}"><i class="fas fa-home me-2"></i> Dashboard</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="{{ route('users.learning.index') }}"><i class="fas fa-route me-2"></i> Learning Skill</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="{{ route('users.kompetensi.index') }}"><i class="fas fa-clipboard-check me-2"></i> Uji Kompetensi</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="{{ route('user.sertifikat') }}"><i class="fas fa-certificate me-2"></i> Sertifikat</a>
                    </li>
                    <li><hr class="my-2 text-white" style="border-top: 2px solid #fff; opacity:1;"></li>
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="{{ route('users.profile.index') }}"><i class="fas fa-user me-2"></i> Profile</a>
                    </li>
                @endif
                <li class="nav-item">
                    <div class="d-flex align-items-center gap-2 py-2 border-top border-secondary" style="border-width:2px !important;">
                        <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=4f8cff&color=fff&size=40' }}" alt="Avatar" class="rounded-circle shadow" style="object-fit:cover;">
                        <span class="me-3">Hello, {{ Auth::user()->name ?? 'User' }}</span>
                        @if(Auth::user())
                            <span class="badge bg-primary text-white" style="font-size:0.85em;">{{ ucfirst(Auth::user()->role) }}</span>
                        @endif
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav px-3 mt-auto mb-3">
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100"><i class="fas fa-sign-out-alt me-1"></i> Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script>
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mobileSidebar = document.getElementById('mobileSidebar');
    const sidebarClose = document.getElementById('sidebarClose');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    sidebarToggle.addEventListener('click', function() {
        mobileSidebar.style.transform = 'translateX(0)';
        sidebarOverlay.style.display = 'block';
        document.body.style.overflow = 'hidden';
    });
    sidebarClose.addEventListener('click', function() {
        mobileSidebar.style.transform = 'translateX(-100%)';
        sidebarOverlay.style.display = 'none';
        document.body.style.overflow = '';
    });
    sidebarOverlay.addEventListener('click', function() {
        mobileSidebar.style.transform = 'translateX(-100%)';
        sidebarOverlay.style.display = 'none';
        document.body.style.overflow = '';
    });
</script>
