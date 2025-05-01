<!doctype html>

@include('admin.body.header')

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

     @include('admin.body.side_nav')
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

      
          @include('admin.body.top_nav')

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
          
                @yield('content')

                
            </div>
            <!-- / Content -->

            @include('admin.body.footer')

  </body>
</html>
