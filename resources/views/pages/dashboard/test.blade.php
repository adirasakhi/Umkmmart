<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Sorting</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .sorting-form {
            display: none; /* Form sorting disembunyikan secara default */
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        @foreach($categories as $category)
            <div class="d-flex justify-content-between fruite-name">
                <a href="#" class="category-link" data-category="{{ $category->category }}">
                    <i class="fas fa-apple-alt me-2"></i>{{ $category->category }}
                </a>
                <span>({{ $category->products_count }})</span>
            </div>
        @endforeach

        <!-- Form sorting yang disembunyikan -->
        <div class="col-xl-3">
            <div class=" sorting-form">
                <form class="d-flex justify-content-between align-items-center">
                    <input type="text" placeholder="Min" name="min" class="form-control input-sx me-2">
                    <input type="text" placeholder="Max" name="max" class="form-control input-sx me-2">
                    <button type="submit" class="btn btn-primary me-3">Sort</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Menyertakan jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Event listener untuk klik pada tautan kategori
            $('.category-link').on('click', function(event) {
                event.preventDefault(); // Mencegah aksi default dari tautan
                $('.sorting-form').show(); // Menampilkan form sorting
            });
        });
    </script>
</body>
</html>
