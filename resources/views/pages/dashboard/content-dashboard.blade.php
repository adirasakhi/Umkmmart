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
                        [
                            'bg' => 'danger',
                            'icon' => 'far fa-newspaper',
                            'title' => 'Total Kategori',
                            'value' => $categoryCount,
                        ],
                        [
                            'bg' => 'warning',
                            'icon' => 'far fa-file',
                            'title' => 'Total Produk',
                            'value' => $productCount,
                        ],
                        ['bg' => 'success', 'icon' => 'fas fa-circle', 'title' => 'Online Users', 'value' => 47], // Static value, can be updated dynamically if needed
                    ];
                @endphp

                @foreach ($stats as $stat)
                    @if ($stat['title'] == 'Total Produk' || $stat['title'] == 'Online Users' || Auth::user()->role_id == 1)
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div
                                    class="card-icon bg-{{ $stat['bg'] }} d-flex align-items-center justify-content-center">
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
                    @endif
                @endforeach
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistics</h4>
                            <div class="card-header-action">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary active" data-type="weekProducts">Week</button>
                                    <button type="button" class="btn btn-secondary" data-type="monthProducts">Month</button>
                                    <button type="button" class="btn btn-secondary" data-type="yearProducts">Year</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Membungkus canvas dengan div yang memiliki lebar tertentu -->
                            <div style="width: 100%; margin: 0 auto;">
                                <canvas id="myChart" height="182"></canvas>
                            </div>
                            <div class="statistic-details mt-sm-4">
                                @foreach ($detailProducts as $detail)
                                    <div class="statistic-details-item">
                                        <span class="text-muted">
                                            <span class="text-{{ $detail['change'] == 'up' ? 'primary' : 'danger' }}">
                                                <i class="fas fa-caret-{{ $detail['change'] }}"></i>
                                            </span>
                                            {{ $detail['plus'] != '-' ? '+' . $detail['plus'] : $detail['plus'] }}
                                        </span>
                                        <div class="detail-value">{{ number_format($detail['value']) }}</div>
                                        <div class="detail-name">{{ $detail['label'] }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @if (Auth::user()->role_id == 1)
                <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>User Statistics</h4>
                            <div class="card-header-action">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary active" data-type="weekUser">Week</button>
                                    <button type="button" class="btn btn-secondary" data-type="monthUser">Month</button>
                                    <button type="button" class="btn btn-secondary" data-type="yearUser">Year</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Membungkus canvas dengan div yang memiliki lebar tertentu -->
                            <div style="width: 100%; margin: 0 auto;">
                                <canvas id="myChartUser" height="182"></canvas>
                            </div>
                            <div class="statistic-details mt-sm-4">
                                @foreach ($detailUsers as $detail)
                                    <div class="statistic-details-item">
                                        <span class="text-muted">
                                            <span class="text-{{ $detail['change'] == 'up' ? 'primary' : 'danger' }}">
                                                <i class="fas fa-caret-{{ $detail['change'] }}"></i>
                                            </span>
                                            {{ $detail['plus'] != '-' ? '+' . $detail['plus'] : $detail['plus'] }}
                                        </span>
                                        <div class="detail-value">{{ number_format($detail['value']) }}</div>
                                        <div class="detail-name">{{ $detail['label'] }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </section>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById("myChart").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Product Registrations',
                        data: [],
                        backgroundColor: '#6777ef',
                        borderColor: '#6777ef',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#ffffff',
                        pointRadius: 4
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1
                            }
                        }]
                    }
                }
            });

            function fetchWeekData() {
                $.ajax({
                    url: '{{ route('dashboard.weekly') }}',
                    method: 'GET',
                    success: function(response) {
                        myChart.data.labels = response.labels;
                        myChart.data.datasets[0].data = response.data;
                        myChart.update();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }

            function fetchMonthData() {
                $.ajax({
                    url: '{{ route('dashboard.monthly') }}',
                    method: 'GET',
                    success: function(response) {
                        myChart.data.labels = response.labels;
                        myChart.data.datasets[0].data = response.data;
                        myChart.update();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }

            function fetchYearData() {
                $.ajax({
                    url: '{{ route('dashboard.yearly') }}',
                    method: 'GET',
                    success: function(response) {
                        myChart.data.labels = response.labels;
                        myChart.data.datasets[0].data = response.data;
                        myChart.update();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }

            // Fetch initial weekly data
            fetchWeekData();

            // Handle type switch buttons
            $('.btn-group .btn').on('click', function() {
                $(this).addClass('btn-primary active').removeClass('btn-secondary').siblings().removeClass(
                    'btn-primary active').addClass('btn-secondary');
                var type = $(this).data('type');
                if (type === 'weekProducts') {
                    fetchWeekData();
                } else if (type === 'monthProducts') {
                    fetchMonthData();
                } else if (type === 'yearProducts') {
                    fetchYearData();
                }
            });

        });
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById("myChartUser").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'User Registrations',
                        data: [],
                        backgroundColor: '#6777ef',
                        borderColor: '#6777ef',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#ffffff',
                        pointRadius: 4
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1
                            }
                        }]
                    }
                }
            });

            function fetchWeekUserData() {
                $.ajax({
                    url: '{{ route('dashboard.user.weekly') }}',
                    method: 'GET',
                    success: function(response) {
                        myChart.data.labels = response.labels;
                        myChart.data.datasets[0].data = response.data;
                        myChart.update();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }

            function fetchMonthUserData() {
                $.ajax({
                    url: '{{ route('dashboard.user.monthly') }}',
                    method: 'GET',
                    success: function(response) {
                        myChart.data.labels = response.labels;
                        myChart.data.datasets[0].data = response.data;
                        myChart.update();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }

            function fetchYearUserData() {
                $.ajax({
                    url: '{{ route('dashboard.user.yearly') }}',
                    method: 'GET',
                    success: function(response) {
                        myChart.data.labels = response.labels;
                        myChart.data.datasets[0].data = response.data;
                        myChart.update();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }

            // Fetch initial weekly data
            fetchWeekUserData();

            // Handle type switch buttons
            $('.btn-group .btn').on('click', function() {
                $(this).addClass('btn-primary active').removeClass('btn-secondary').siblings().removeClass(
                    'btn-primary active').addClass('btn-secondary');
                var type = $(this).data('type');
                if (type === 'weekUser') {
                    fetchWeekUserData();
                } else if (type === 'monthUser') {
                    fetchMonthUserData();
                } else if (type === 'yearUser') {
                    fetchYearUserData();
                }
            });

        });
    </script>
@endsection
