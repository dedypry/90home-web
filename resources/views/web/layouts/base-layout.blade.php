<!DOCTYPE html>
<html lang="en">

@include('web.layouts.partials.head')

<body>
    <!-- Topbar Start -->
    @include('web.layouts.partials.toolbar')
    <!-- Topbar End -->


    <!-- Navbar Start -->
    @include('web.layouts.partials.navbar')
    <!-- Navbar End -->


    <!-- Under Nav Start -->
    @include('web.layouts.partials.under-nav')
    <!-- Under Nav End -->

@yield('content')


    <!-- Footer Start -->
    @include('web.layouts.partials.footer')
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
   @include('web.layouts.partials.script')
</body>

</html>
