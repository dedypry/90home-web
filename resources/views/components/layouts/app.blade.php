<!DOCTYPE html>
<html lang="en">

@include('components.layouts.partials.head')

<body>
    <!-- Topbar Start -->
    @include('components.layouts.partials.toolbar')
    <!-- Topbar End -->


    <!-- Navbar Start -->
    @include('components.layouts.partials.navbar')
    <!-- Navbar End -->


    <!-- Under Nav Start -->
    @include('components.layouts.partials.under-nav')
    <!-- Under Nav End -->
    {{ $slot }}


    <!-- Footer Start -->
    @include('components.layouts.partials.footer')
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    @include('components.layouts.partials.script')
    @livewireScripts
</body>

</html>
