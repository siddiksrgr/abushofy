<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>AbuShofy @yield('title')</title>

    @stack('prepend-style')
    @include('includes.style')
    @stack('addon-style')
  </head>
  <body> 

   <!-- Navbar -->
   <div class="container" data-aos="fade-down">
    <div class="row justify-content-center my-3">
        <h3 class="text-dark font-weight-bolder">AbuShofy</h3>
    </div>
    <hr>
   </div>

    <!-- Page Content -->
    @yield('content')

    <!-- Footer -->
    @include('includes.footer')

    <!-- Script -->
    @stack('prepend-script')
    @include('includes.script')
    @stack('addon-script')   
  </body>
</html>