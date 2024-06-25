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
                    $stats = [
                        ['bg' => 'primary', 'icon' => 'far fa-user', 'title' => 'Total User', 'value' => $usersCount],
                        ['bg' => 'danger', 'icon' => 'far fa-newspaper', 'title' => 'Total Kategori', 'value' => $categoryCount],
                        ['bg' => 'warning', 'icon' => 'far fa-file', 'title' => 'Total Produk', 'value' => $productCount],
                        ['bg' => 'success', 'icon' => 'fas fa-users', 'title' => 'Total Visitors', 'value' => $totalVisitors],
                    ];
                @endphp

                @foreach ($stats as $stat)
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

            <!-- Add Charts Section -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card" style="height: 400px;">
                        <div class="card-header">
                            <h4>Products Per Category</h4>
                        </div>
                        <div class="card-body" style="height: 90%;">
                            <canvas id="productsPerCategoryChart" style="height: 100%;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card" style="height: 400px;">
                        <div class="card-header">
                            <h4>Total Visitors</h4>
                        </div>
                        <div class="card-body" style="height: 90%;">
                            <canvas id="totalVisitorsChart" style="height: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Data for products per category
            const productsPerCategoryLabels = {!! json_encode($productsPerCategory->pluck('category')) !!};
            const productsPerCategoryData = {!! json_encode($productsPerCategory->pluck('products_count')->map(function($count) { return intval($count); })) !!};

            new Chart(document.getElementById('productsPerCategoryChart'), {
                type: 'bar',
                data: {
                    labels: productsPerCategoryLabels,
                    datasets: [{
                        label: 'Products Count',
                        data: productsPerCategoryData,
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

            // Data for total visitors
            const totalVisitorsData = {!! json_encode($totalVisitorsData) !!};

            new Chart(document.getElementById('totalVisitorsChart'), {
                type: 'line',
                data: {
                    labels: totalVisitorsData.labels,
                    datasets: [{
                        label: 'Total Visitors Per Day',
                        data: totalVisitorsData.daily.map(function(value) { return parseInt(value); }),
                        backgroundColor: '#6777ef',
                        borderColor: '#6777ef',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#ffffff',
                        pointRadius: 4
                    }, {
                        label: 'Total Visitors Per Month',
                        data: totalVisitorsData.monthly.map(function(value) { return parseInt(value); }),
                        backgroundColor: '#fc544b',
                        borderColor: '#fc544b',
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
                        }]
                    }
                }
            });
        });
    </script>
@endsection
