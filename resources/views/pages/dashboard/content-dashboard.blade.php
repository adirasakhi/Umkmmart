@extends('layouts.dashboard')

@section('title', '|| Dashboard')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            @php
            // Data statistik untuk ditampilkan pada kartu statistik
            $stats = [
                ['bg' => 'primary', 'icon' => 'far fa-user', 'title' => 'Total User', 'value' => $usersCount],
                ['bg' => 'danger', 'icon' => 'far fa-newspaper', 'title' => 'Total Kategori', 'value' => $categoryCount],
                ['bg' => 'warning', 'icon' => 'far fa-file', 'title' => 'Total Produk', 'value' => $productCount],
                ['bg' => 'success', 'icon' => 'fas fa-circle', 'title' => 'Online Users', 'value' => 47],
            ];
            @endphp

            @foreach($stats as $stat)
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-{{ $stat['bg'] }} d-flex align-items-center justify-content-center">
                        <i class="{{ $stat['icon'] }}"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ $stat['title'] }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $stat['value'] }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Statistics</h4>
                        <div class="card-header-action">
                            <div class="btn-group">
                                <a href="#" class="btn btn-primary">Week</a>
                                <a href="#" class="btn">Month</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Membungkus canvas dengan div yang memiliki lebar tertentu -->
                        <div style="width: 400px; margin: 0 auto;">
                            <canvas id="myChart" height="182"></canvas>
                        </div>
                        <div class="statistic-details mt-sm-4">
                            @foreach($details as $detail)
                            <div class="statistic-details-item">
                                <span class="text-muted">
                                    <span class="text-{{ $detail['change'] == 'up' ? 'primary' : 'danger' }}">
                                        <i class="fas fa-caret-{{ $detail['change'] }}"></i>
                                    </span>

                                    {{ number_format($detail['value']) }} @if($detail['change'] == 'up')
                                        +
                                    @else
                                        -
                                    @endif

                                </span>
                                <div class="detail-value">{{ number_format($detail['value']) }}</div>
                                <div class="detail-name">{{ $detail['label'] }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Inisialisasi chart menggunakan Chart.js
    var ctx = document.getElementById("myChart").getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            // Label untuk sumbu x
            labels: @json($labels),
            datasets: [{
                label: 'Product Registrations',
                data: @json($data), // Data untuk chart
                borderWidth: 2,
                backgroundColor: '#6777ef',
                borderColor: '#6777ef',
                borderWidth: 2.5,
                pointBackgroundColor: '#ffffff',
                pointRadius: 4
            }]
        },
        options: {
            legend: {
                display: false // Menyembunyikan legenda chart
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        drawBorder: false,
                        color: '#f2f2f2',
                    },
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1 // Langkah pada sumbu y
                    }
                }],
                xAxes: [{
                    ticks: {
                        display: true // Menampilkan label sumbu x
                    },
                    gridLines: {
                        display: false // Menyembunyikan garis grid pada sumbu x
                    }
                }]
            }
        }
    });
});
</script>
@endsection
