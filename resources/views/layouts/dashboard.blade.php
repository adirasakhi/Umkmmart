<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>UMKMART @yield('title')</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">
  {{-- datatable --}}
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css"/>
  <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
  <!-- Template CSS -->
  <link rel="stylesheet"  href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet"  href="{{ asset('assets/css/components.css') }}">
  <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
  <!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- End SweetAlert2 -->
  <style >
    .sorting-form {
        display: none;
    }
</style>
</head>

  <body>
    <div id="app">
      <div class="main-wrapper main-wrapper-1">
        @include("partials.dashboard.navbar")
        @include("partials.dashboard.sidebar")
      </div>
      @yield("content")
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2024 <div class="bullet"></div> Design By <a href="https://google.com">Team 5</a>
        </div>
        <div class="footer-right">

        </div>
      </footer>
    </div>
    <!-- General JS Scripts -->
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    {{-- datatable --}}
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset("assets/modules/jquery-ui/jquery-ui.min.js") }}"></script>
    <script>
      $(document).ready( function () {
        $('#example').DataTable();
      });
    </script>


    <!-- JS Libraies -->
    <script src="{{ asset('assets/modules/chart.min.js') }}"></script>


    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    {{-- Modal --}}
    <script src="{{ asset('assets/modal/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    {{-- sweatallert script --}}
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    </script>

    {{-- end sweatallert script --}}
  </body>
  </html>
