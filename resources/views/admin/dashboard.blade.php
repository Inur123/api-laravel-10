@extends('layouts.app')

@section('title', 'Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <!-- Toastr Notifications -->
        @if (session('success'))
            <script>
                toastr.success("{{ session('success') }}");
            </script>
        @endif

        @if (session('error'))
            <script>
                toastr.error("{{ session('error') }}");
            </script>
        @endif

        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>



            <div class="row mt-4">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-user-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Siswa</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalPelajar }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Guru</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalGuru }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-female"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Girly Pedia</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalGirlyPedia }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-podcast"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Podcast</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalPodcast }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h3 class="" style="color: #34395e">Registration Statistics for the Last 30 Days</h3>
            <div class="card">
                <div class="card-body">
                    <canvas id="registrationChart" style="width: 100%; height: 400px;"></canvas>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch('http://127.0.0.1:8000/api/registration-statistics')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Prepare data for the chart
                    const labels = data.map(stat => stat.date);
                    const registrationCounts = data.map(stat => stat.count);

                    // Create the chart
                    const ctx = document.getElementById('registrationChart').getContext('2d');
                    const registrationChart = new Chart(ctx, {
                        type: 'line', // Type of chart is line
                        data: {
                            labels: labels, // Dates for x-axis
                            datasets: [{
                                label: 'Jumlah Pendaftaran',
                                data: registrationCounts, // Registration counts for y-axis
                                borderColor: '#FFABC7', // Color of the line
                                backgroundColor: '#FFEDED', // Fill color below the line
                                fill: true, // Fill under the line
                                tension: 0.1 // Optional, makes the line curved
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Jumlah Pendaftaran'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Tanggal'
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error fetching registration statistics:', error));
        });
    </script>
@endpush
