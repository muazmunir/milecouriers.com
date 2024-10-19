<!DOCTYPE html>
<html lang="en">
    <head>
        @include('includes.backend.head')
    </head>
    <body>
        <!-- loader starts-->
        <div class="loader-wrapper">
            <div class="loader">
                <div class="loader4"></div>
            </div>
        </div>
        <!-- loader ends-->
        <!-- tap on top starts-->
        <div class="tap-top"><i data-feather="chevrons-up"></i></div>
        <!-- tap on tap ends-->
        <!-- page-wrapper Start-->
        <div class="page-wrapper compact-wrapper" id="pageWrapper">
            <!-- Page Header Start-->
            @include('includes.backend.header')
            <!-- Page Header Ends                              -->
            <!-- Page Body Start-->
            <div class="page-body-wrapper">
                <!-- Page Sidebar Start-->
                @include('includes.backend.sidebar')
                <!-- Page Sidebar Ends-->
                <div class="page-body">
                    @yield('content') 
                    <!-- Container-fluid Ends-->
                </div>
                <!-- footer start-->
                @include('includes.backend.footer')
            </div>
        </div>
        @include('includes.backend.script')
        @stack('scripts')
    </body>
</html>