<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl
        {{ str_contains(Request::url(), 'virtual-reality') == true ? ' mt-3 mx-3 bg-primary' : '' }}"
    id="navbarBlur" data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav class="d-flex align-items-center jusctify-content-between container">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link fs-6 fw-bold active text-white"
                        href="{{ route('pegawai.profil.index') }}">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-6 fw-bold text-white" href="#">Presensi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-6 fw-bold text-white"href="#">Notifikasi</a>
                </li>
            </ul>
            <form role="form" method="post" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <button type="submit" class="btn btn-white text-primary px-4 font-weight-bold">
                    <i class="fa fa-user me-sm-1"></i>
                    <span class="d-sm-inline fs-6 fw-bold">Log out</span>
                </button>
            </form>
        </nav>
    </div>
</nav>
<!-- End Navbar -->
