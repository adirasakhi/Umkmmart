@extends('layouts.dashboard')

@section('title', '|| Dashboard')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning d-flex align-items-center justify-content-center">
                            <i class="far fa-file"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Produk</h4>
                            </div>
                            <div class="card-body">
                                {{ $productCount }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success d-flex align-items-center justify-content-center">
                            <i class="fas fa-mouse-pointer"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Klik</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalClicks }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Chart Section -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card" style="height: 400px;">
                        <div class="card-header">
                            <h4>Klik Per Produk</h4>
                        </div>
                        <div class="card-body" style="height: 90%;">
                            <canvas id="clicksPerProductChart" style="height: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Data for clicks per product
            const clicksPerProductLabels = {!! json_encode($clicksPerProduct->pluck('name')) !!};
            const clicksPerProductData = {!! json_encode($clicksPerProduct->pluck('clicks_count')->map(function($count) { return intval($count); })) !!};

            new Chart(document.getElementById('clicksPerProductChart'), {
                type: 'line',
                data: {
                    labels: clicksPerProductLabels,
                    datasets: [{
                        label: 'Clicks Count',
                        data: clicksPerProductData,
                        backgroundColor: '#6777ef',
                        borderColor: '#6777ef',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#ffffff',
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                callback: function (value) { if (Number.isInteger(value)) { return value; } },
                                stepSize: 1
                            }
                        }],
                        xAxes: [{
                            ticks: {
                                autoSkip: false,
                                maxRotation: 0,
                                minRotation: 0
                            }
                        }]
                    }
                }
            });
        });
    </script>
@endsection
