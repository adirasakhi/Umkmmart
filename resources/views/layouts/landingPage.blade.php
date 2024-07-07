<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>UMKMart</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('LandingPage/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('LandingPage/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('LandingPage/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('LandingPage/css/style.css') }}" rel="stylesheet">

    <style>
        .btn-custom {
            background-color: #404040;
            color: white;
            border: 1px solid #6c757d;
            border-radius: 50px;
            padding: 0.5rem 1rem;
            margin-bottom: 1rem;
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }

        .btn-custom:hover {
            background-color: black;
            color: white;
        }

        .btn-custom .fa-phone {
            color: white;
            margin-right: 0.5rem;
        }

        .fixed-top {
            width: 100%;
            background-color: white;
            z-index: 1030;
            /* Ensure it stays above other content */
        }


        @media (min-width: 853px) {
            #filterModalToggle {
                display: none;
            }
        }

        @media (max-width: 853px) {
            #filterContainer {
                display: none;
            }

            .user-icon {
                text-decoration: none !important;
                color: black !important;
            }

            .user-icon i {
                display: none;
            }

            .user-link {
                font-weight: bold;
                color: black;
            }
        }

        .modal-dialog-scrollable .modal-body {
            max-height: 54vh;
            overflow-y: auto;
        }

        .additional-category {
            margin-top: 0;
        }


        .custom-checkbox {
            border-radius: 3px;
            width: 18px;
            height: 18px;
            appearance: none;
            -webkit-appearance: none;
            background-color: #fff;
            border: 1px solid #ced4da;
            outline: none;
            cursor: pointer;
            position: relative;
            display: inline-block;
            vertical-align: middle;
        }

        .custom-checkbox:checked::before {
            content: "\2714";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 14px;
            color: black;
        }

        .custom-checkbox:hover {
            border-color: black;
        }

        .scrollable-row {
            display: flex;
            overflow-x: auto;
            padding: 10px;
            white-space: nowrap;
        }

        .main-image-container img {
            height: 300px;
            width: 100%;
            object-fit: cover;
            border-radius: 8px;
        }

        .scrollable-row {
            display: flex;
            overflow-x: auto;
            padding: 10px;
            white-space: nowrap;
            gap: 10px;
        }

        .scrollable-row .col {
            flex: 0 0 auto;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .scrollable-row .col img {
            height: 100px;
            width: 100px;
            object-fit: cover;
            border-radius: 8px;
        }

        .variant-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 10px 0;
        }

        .variant-item {
            flex: 0 0 auto;
            white-space: nowrap;
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
            background-color: #f8f8f8;
        }

        .variant-item:hover {
            background-color: #e2e2e2;
            cursor: pointer;
        }

        .main-image-container img {
            width: 100%;
            height: 360px;
        }

        .nav-tabs .nav-link {
            text-align: center;
            position: relative;
            display: inline-block;
            padding-bottom: 10px;
        }

        .nav-tabs .nav-link::after {
            content: '';
            display: block;
            width: 100%;
            height: 2px;
            background-color: black;
            position: absolute;
            bottom: 0;
            left: 0;
        }

        .scrollable-column {
            max-height: 500px;
            /* Adjust this value as needed */
            overflow-y: auto;
        }

        h6,
        h2#orderVariantPrice {
            margin-bottom: 0;
            /* Menghapus margin bawah dari elemen h6 */
            margin-top: 0;
            /* Menghapus margin atas dari elemen h2 */
        }

        .container-fluid .overlay {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.4);
            /* Ubah opacity sesuai kebutuhan */
            z-index: 1;
            /* Pastikan overlay muncul di atas background image */
            background-repeat: no-repeat;
        }

        .hero-header {
            background-size: cover;
            background-position: center;
        }

        .strike-through {
            text-decoration: line-through;
            /* opacity: 0.6; */
            font-weight: bold;
            font-size: 1.5rem;
            color: #dc3545;
        }

        .variant-item {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            /* Menjadikan teks turun ke bawah saat terlalu panjang */
            height: auto;
            /* Menyesuaikan tinggi elemen sesuai dengan konten */
        }

        .variant-name {
            overflow-x: auto;
            /* Membuat nama varian discroll jika terlalu panjang */
            overflow-y: hidden;
            /* Menghindari pemunculan scrollbar vertikal jika tidak diperlukan */
            white-space: nowrap;
            /* Mencegah pematahan baris */
            max-width: 100%;
            /* Menyesuaikan lebar maksimum dengan kontainer */
            margin-right: 10px;
            /* Jarak kanan dari gambar */
        }

        #orderVariantImage {
            flex-shrink: 0;
            /* Menjamin gambar variant tetap di samping teks */
        }
    </style>
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner"
        class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    <!-- Modal Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center">
                    <div class="input-group w-75 mx-auto d-flex">
                        <input type="search" class="form-control p-3" placeholder="keywords"
                            aria-describedby="search-icon-1">
                        <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->
    <!-- Navbar start -->
    @include('partials.Landing.navbar')
    <!-- Navbar End -->
    <!-- Content Start -->
    <div class="container">
        @yield('content')
    </div>
    <!-- Content End -->

    <!-- Footer Start -->
    @include('partials.Landing.footer')
    <!-- Footer End -->




    <!-- Back to Top -->
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i
            class="fa fa-arrow-up" style="color: white"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{ asset('LandingPage/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('LandingPage/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('LandingPage/lib/lightbox/js/lightbox.min.js') }}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <!-- Template Javascript -->
    <script src="{{ asset('LandingPage/js/main.js') }}"></script>

    <script>
        $(document).ready(function() {

            $(".owl-carousel").owlCarousel({
                items: 3,
                loop: true,
                margin: 10,
                nav: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true
            });
        });
    </script>
</body>

</html>

