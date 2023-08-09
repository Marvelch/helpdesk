<!DOCTYPE html>
<html lang="en">

@include('components.head')
@include('sweetalert::alert')

<body class="g-sidenav-show bg-gray-100">
    <!-- Start Aside -->
    @include('components.sidebar')
    <!-- End Aside -->
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('components.navbar')
        <!-- End Navbar -->
        @yield('contents')
        @stack('custom-scripts')
        @include('components.footer')
    </main>

    <!--   Core JS Files   -->
    <script src="{{asset('./assets/js/core/popper.min.js')}}"></script>
    <script src="{{asset('./assets/js/core/bootstrap.min.js')}}"></script>
    <script src="{{asset('./assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('./assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
    <script src="{{asset('./assets/js/plugins/chartjs.min.js')}}"></script>
    @stack('diagram')
    @stack('zoom_images')
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }

    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{asset('./assets/js/soft-ui-dashboard.min.js')}}"></script>
</body>

</html>
