<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Abushofy @yield('title')</title>

    <!-- Bootstrap CSS -->
    @stack('prepend-style')
    <link href="/vendor/css/style.css" rel="stylesheet">
    <link href="/vendor/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
    @stack('addon-style')

  </head>
  <body>

    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/"><h5>ADMINISTRATOR </h5></a>
            <button class="navbar-toggler d-md-none collapsed " type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
    
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-light text-capitalize" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                    {{auth()->user()->name}} ({{ auth()->user()->role }})
                </a>
        
                <div class="dropdown-menu">
                    <a href="/admin/account" class="dropdown-item"><i class="bi bi-person"></i> Akun</a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">
                        <i class="bi bi-box-arrow-left"></i> Sign Out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                    </form>
                </div>
            </div>
        </div>
        
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse p-0"> 
                <ul class="nav flex-column list-group list-group-flush">
                    @if(auth()->user()->role !== 'admin')
                    <li class="nav-item list-group-item {{ (request()->is('admin/dashboard*')) ? 'active' : '' }}">
                        <a class="nav-link text-dark" href="/admin/dashboard"><i class="bi bi-house-door"></i> Dashboard</a>
                    </li>
                    @endif

                    <!-- master -->
                    <li class="nav-item list-group-item {{ (request()->is('admin/users*')) ? 'active' : '' }}">
                        <a href="/admin/users" class="nav-link text-dark">
                            <i class="bi bi-people"></i> User
                        </a>
                    </li>

                    @if(auth()->user()->role !== 'admin')
                    <li class="nav-item list-group-item {{ (request()->is('admin/category*')) ? 'active' : '' }}">
                        <a class="nav-link text-dark" href="/admin/category"><i class="bi bi-tag"></i> Kategori</a>
                    </li>
                    <li class="nav-item list-group-item {{ (request()->is('admin/product*')) ? 'active' : '' }}">
                        <a class="nav-link text-dark" href="/admin/product"><i class="bi bi-card-list"></i> Produk</a>
                    </li>
                    <li class="nav-item list-group-item {{ (request()->is('admin/clothing-size*')) ? 'active' : '' }}">
                        <a class="nav-link text-dark" href="/admin/clothing-size"><i class="bi bi-aspect-ratio"></i> Ukuran Pakaian</a>
                    </li>
                    <li class="nav-item list-group-item {{ (request()->is('admin/accessories-size*')) ? 'active' : '' }}">
                        <a class="nav-link text-dark" href="/admin/accessories-size"><i class="bi bi-aspect-ratio"></i> Ukuran Aksesoris</a>
                    </li>
                    <li class="nav-item list-group-item {{ (request()->is('admin/clothing-stock*')) ? 'active' : '' }}"> 
                        <a class="nav-link text-dark" href="/admin/clothing-stock"><i class="bi bi-list-ol"></i> Stok Pakaian</a>
                    </li>
                    <li class="nav-item list-group-item {{ (request()->is('admin/accessories-stock*')) ? 'active' : '' }}">
                        <a class="nav-link text-dark" href="/admin/accessories-stock"><i class="bi bi-list-ol"></i> Stok Aksesoris</a>
                    </li>

                    <!-- transaksi -->
                    <li class="nav-item list-group-item {{ (request()->is('admin/transactions*')) ? 'active' : '' }}">
                        <a class="nav-link text-dark" href="/admin/transactions"><i class="bi bi-cart3"></i> Transaksi</a>
                    </li>
                    <li class="nav-item list-group-item {{ (request()->is('admin/confirmations*')) ? 'active' : '' }}">
                        <a class="nav-link text-dark" href="/admin/confirmations"><i class="bi bi-currency-dollar"></i> Pembayaran</a>
                    </li>
                    <li class="nav-item list-group-item {{ (request()->is('admin/shippings*')) ? 'active' : '' }}">
                        <a class="nav-link text-dark" href="/admin/shippings"><i class="bi bi-truck"></i> Pengiriman</a>
                    </li>
                    <li class="nav-item list-group-item {{ (request()->is('admin/complains*')) ? 'active' : '' }}">
                        <a class="nav-link text-dark" href="/admin/complains"><i class="bi bi-x-circle"></i> Komplain </a>
                    </li>
                    @endif

                    <li class="nav-item list-group-item">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link text-dark">
                            <i class="bi bi-box-arrow-left"></i> Sign Out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>

            <!-- Section Content -->
            @yield('content')

        </div>
    </div>

    <footer class="footer bg-light py-3 mt-3">
        <div class="container text-center">
        <span class="text-muted">@2022 All Right Reserved</span>
        </div>
    </footer>
 
    @stack('prepend-script')
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            $('#dataTable').DataTable();
        });
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>
    @stack('addon-script')
  </body>
</html> 