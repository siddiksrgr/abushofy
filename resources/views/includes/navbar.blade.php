<nav class="navbar navbar-expand-lg navbar-light bg-white" data-aos="fade-down">
  <div class="container">
    <a class="navbar-brand" href="/"><h3 class="text-dark font-weight-bolder">AbuShofy</h3></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav"> 
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle {{ (request()->is('category*')) ? 'active' : '' }}" href="#" id="navbarDropdownMenuLink" role="button"
            data-toggle="dropdown" aria-expanded="false">
            Kategori
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li>
              <a class="dropdown-item" href="#"> Pakaian &raquo; </a>
              <ul class="dropdown-menu dropdown-submenu">
                <li>
                  <a class="dropdown-item" href="#">Pakaian Pria &raquo; </a>
                    <ul class="dropdown-menu dropdown-submenu">
                      @php $pakaian_prias = \App\Models\Category::where('main_category', 'pakaian')->where('gender_category', 'pria')->get() @endphp
                      @foreach($pakaian_prias as $pakaian_pria)
                      <li>
                        <a class="dropdown-item" href="/category/{{$pakaian_pria->name_category}}">{{$pakaian_pria->name_category}}</a>
                      </li>
                      @endforeach
                    </ul>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Pakaian Wanita &raquo; </a>
                  <ul class="dropdown-menu dropdown-submenu">
                    @php $pakaian_wanitas = \App\Models\Category::where('main_category', 'pakaian')->where('gender_category', 'wanita')->get() @endphp
                    @foreach($pakaian_wanitas as $pakaian_wanita)
                    <li>
                      <a class="dropdown-item" href="/category/{{$pakaian_wanita->name_category}}">{{$pakaian_wanita->name_category}}</a>
                    </li>
                    @endforeach
                  </ul>
                </li>
              </ul>
            </li>
            <li>
              <a class="dropdown-item" href="#"> Aksesoris &raquo; </a>
              <ul class="dropdown-menu dropdown-submenu">
                <li>
                  <a class="dropdown-item" href="#">Aksesoris Pria &raquo; </a>
                  <ul class="dropdown-menu dropdown-submenu">
                    @php $aksesoris_prias = \App\Models\Category::where('main_category', 'aksesoris')->where('gender_category', 'pria')->get() @endphp
                    @foreach($aksesoris_prias as $aksesoris_pria)
                    <li>
                      <a class="dropdown-item" href="/category/{{$aksesoris_pria->name_category}}">{{$aksesoris_pria->name_category}}</a>
                    </li>
                    @endforeach
                  </ul>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Aksesoris Wanita &raquo; </a>
                  <ul class="dropdown-menu dropdown-submenu">
                    @php $aksesoris_wanitas = \App\Models\Category::where('main_category', 'aksesoris')->where('gender_category', 'wanita')->get() @endphp
                    @foreach($aksesoris_wanitas as $aksesoris_wanita)
                    <li>
                      <a class="dropdown-item" href="/category/{{$aksesoris_wanita->name_category}}">{{$aksesoris_wanita->name_category}}</a>
                    </li>
                    @endforeach
                  </ul>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Aksesoris Pria & Wanita &raquo; </a>
                  <ul class="dropdown-menu dropdown-submenu">
                    @php $aksesoris = \App\Models\Category::where('main_category', 'aksesoris')->where('gender_category', 'pria & wanita')->get() @endphp
                    @foreach($aksesoris as $aksesoris)
                    <li>
                      <a class="dropdown-item" href="/category/{{$aksesoris->name_category}}">{{$aksesoris->name_category}}</a>
                    </li>
                    @endforeach
                  </ul>
                </li>
              </ul>
            </li>
          </ul>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        @guest
        <li class="nav-item">
          <a class="btn bg-white text-primary border-primary nav-link mx-2 px-3" href="/login">Sign In</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-primary nav-link px-3 text-white" href="/register">Sign Up</a>
        </li>
        @endguest

        @auth
        <li class="nav-item ">
          <a class="nav-link" href="{{ route('pre-order-cart.index') }}">
              @php $cart = \App\Models\Cart::where('user_id', Auth::user()->id)->where('description', 'pre-order')->count(); @endphp
              <img src="{{ asset('storage/icon-pre-order-cart.svg') }}" alt="" data-toggle="tooltip" data-placement="bottom" title="Pre Order Cart">
              @if($cart)
              <div class="cart-badge">{{ $cart }}</div>
              @endif
          </a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link" href="{{ route('cart.index') }}">
              @php $carts = \App\Models\Cart::where('user_id', Auth::user()->id)->where('description', '-')->count(); @endphp
              <img src="{{ asset('storage/icon-cart-filled.svg') }}" alt="" data-toggle="tooltip" data-placement="bottom" title="Cart">
              @if($carts)
              <div class="cart-badge">{{ $carts }}</div>
              @endif
          </a>
        </li>
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown">
            <img src="{{ asset('storage/'. Auth::user()->photo) }}" alt="" class="rounded-circle profile-picture"> {{Auth::user()->name}}
          </a>
          <div class="dropdown-menu">
            <a href="/transaction" class="dropdown-item">Transaksi</a>
            <a href="/pre-orders" class="dropdown-item">Pre Order</a>
            <a href="/complains" class="dropdown-item">Komplain</a>
            <a href="/account" class="dropdown-item">Akun</a>
            <div class="dropdown-divider"></div>
              <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">
                Logout
              </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </div>
        </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>