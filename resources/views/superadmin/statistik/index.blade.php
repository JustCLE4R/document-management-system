@extends('layouts.main')

@section('content')
    @push('styles')
        <style>
            .running-text-container {
                height: 65px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            #runningText {
                transition: opacity 0.5s ease-in-out;
            }
        </style>
    @endpush
    <div class="container" style="padding-top: 9vh;">
        <div class="section-header text-center">
            <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Statistik Sistem</h2>
            <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
        </div>

        <div class="text-dark fw-bold text-center mb-1">Dokumen yang Baru Ditambahkan</div>
        <div class="running-text-container overflow-hidden bg-light p-3 rounded mb-4">
            <br>
            <div id="runningText" class="text-primary fw-bold text-center"></div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                <a href="/superadmin" class="btn btn-success wow fadeInRight" data-wow-delay="0.3s"><i
                        class="bi bi-chevron-double-left"></i> Kembali</a>
            </div>
        </div>
        <div class="row justify-content-center mb-5 g-3 g-md-4">
            <div class="col-md-3 my-1">
                <div class="card text-dark p-3 h-100 shadow">
                    <div class="card-body text-center">
                        <i class="bi bi-file-earmark-text display-1 "></i>
                        <h5 class="mt-2">Total Dokumen</h5>
                        <p class="card-text display-4 total-documents">{{ $totalDocuments }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 my-1">
                <div class="card text-dark  p-3 h-100 shadow">
                    <div class="card-body text-center">
                        <i class="bi bi-folder display-1 "></i>
                        <h5 class="mt-2">Total Kategori</h5>
                        <p class="card-text display-4 total-kategori">{{ $totalKategori }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 my-1">
                <div class="card text-dark  p-3 h-100 shadow">
                    <div class="card-body text-center">
                        <i class="bi bi-building display-1 "></i>
                        <h5 class="mt-2">Total Departemen</h5>
                        <p class="card-text display-4 total-department">{{ $totalDepartment }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 my-1">
                <div class="card bg-light text-dark border-success shadow-sm mb-3 p-3 h-100 shadow">
                    <div class="card-body">
                        <i class="bi bi-clock-history display-3 d-block text-center mb-2"></i>
                        <h5 class="card-title text-center">Dokumen Baru</h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>⏰ Hari Ini</span>
                            <span class="badge bg-success text-white p-2 px-3">{{ $newDocumentsToday }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span>📅 Minggu Ini</span>
                            <span class="badge bg-primary text-white p-2 px-3">{{ $newDocumentsWeek }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span>📆 Bulan Ini</span>
                            <span class="badge bg-warning text-dark p-2 px-3">{{ $newDocumentsMonth }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <h4 class="mb-3 text-dark" style="font-weight: bold; font-size: 1.5rem">🔥 Dokumen yang Sering Diakses</h4>
        <ul class="list-group mb-5">
            @foreach ($mostViewedDocuments as $doc)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $doc->name }}
                    <span class="badge bg-primary rounded-pill">🔥 {{ $doc->views }} view(s)</span>
                </li>
            @endforeach
        </ul>

        <h4 class="mb-3 text-dark" style="font-weight: bold; font-size: 1.5rem">🏢 Dokumen Terbanyak per Departemen</h4>
        <ul class="list-group mb-5">
            @foreach ($documentByDepartment as $department)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $department->department_name }}
                    <span class="badge bg-secondary">📂 {{ $department->total }} doc(s)</span>
                </li>
            @endforeach
        </ul>

        <h4 class="mb-3 text-dark" style="font-weight: bold; font-size: 1.5rem">📚 Dokumen Terbanyak per Kategori</h4>
        <ul class="list-group mb-5">
            @foreach ($documentsByKategori as $kategori)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ ucfirst($kategori->kategori->name) }}: {{ $kategori->kategori->department->name }}
                    <span class="badge bg-secondary">📂 {{ $kategori->total }} doc(s)</span>
                </li>
            @endforeach
        </ul>

        <h4 class="mb-3 text-dark" style="font-weight: bold; font-size: 1.5rem">🔄 Dokumen dengan Revisi Terbanyak</h4>
        <ul class="list-group mb-5">
            @foreach ($mostRevisedDocuments as $doc)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $doc->name }}
                    <span class="badge bg-danger rounded-pill">🔄 {{ $doc->revisions }} revisi</span>
                </li>
            @endforeach
        </ul>

        <h4 class="mb-3 text-dark" style="font-weight: bold; font-size: 1.5rem">📊 Diagram Statistik</h4>
        <div class="row mb-5">
            <div class="col-md-6 mb-4 mx-auto">
                <h5 class="text-center">📅 Dokumen per Tahun</h5>
                <canvas id="documentsPerYearChart"></canvas>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md-12 mb-4">
                <h5 class="text-center">📅 Dokumen per Bulan</h5>
                <canvas id="documentsPerMonthChart"></canvas>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md-12 mb-4">
                <h5 class="text-center">📅 Dokumen per Hari</h5>
                <canvas id="documentsPerDayChart"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                function counterUp(element, start, end, duration) {
                    let range = end - start;
                    let current = start;
                    let increment = end > start ? 1 : -1;
                    let stepTime = Math.abs(Math.floor(duration / range));
                    let timer = setInterval(function() {
                        current += increment;
                        element.innerText = current;
                        if (current == end) {
                            clearInterval(timer);
                        }
                    }, stepTime);
                }

                let totalDocuments = document.querySelector(".total-documents");
                let totalKategori = document.querySelector(".total-kategori");
                let totalDepartment = document.querySelector(".total-department");

                if (totalDocuments) {
                    counterUp(totalDocuments, 0, parseInt(totalDocuments.innerText), 1500);
                }
                if (totalKategori) {
                    counterUp(totalKategori, 0, parseInt(totalKategori.innerText), 1500);
                }
                if (totalDepartment) {
                    counterUp(totalDepartment, 0, parseInt(totalDepartment.innerText), 1500);
                }
            });



            document.addEventListener("DOMContentLoaded", function() {
                const documents = @json(
                    $mostRecentDocuments->map(fn($doc) => '<strong>' .
                                $doc->name .
                                '</strong><br>' .
                                '📅 ' .
                                \Carbon\Carbon::parse($doc->created_at)->format('d M Y H:i') .
                                ' WIB | ' .
                                '📂 ' .
                                $doc->kategori->name .
                                ' | ' .
                                '👤 ' .
                                $doc->user->department->name)->toArray()); // Convert to array for JSON encoding

                const runningText = document.getElementById("runningText");
                let index = 0;

                function showNextDocument() {
                    if (documents.length === 0) return;

                    runningText.style.opacity = "0"; // Fade out effect
                    setTimeout(() => {
                        runningText.innerHTML = documents[index]; // Change text using innerHTML
                        runningText.style.opacity = "1"; // Fade in effect
                        index = (index + 1) % documents.length; // Loop back to first
                    }, 500);
                }

                setInterval(showNextDocument, 3000); // Change every 3 seconds
                showNextDocument(); // Show first immediately
            });

            function createChart(ctx, type, labels, data, backgroundColor, borderColor, zoomable = false) {
                return new Chart(ctx, {
                    type: type,
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Dokumen',
                            data: data,
                            backgroundColor: backgroundColor,
                            borderColor: borderColor,
                            borderWidth: 1,
                            fill: type === 'line'
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                ticks: {
                                    autoSkip: true,
                                    maxTicksLimit: 10
                                }
                            },
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: zoomable ? {
                            zoom: {
                                pan: {
                                    enabled: true,
                                    mode: 'x'
                                },
                                zoom: {
                                    wheel: {
                                        enabled: true
                                    },
                                    pinch: {
                                        enabled: true
                                    },
                                    mode: 'x'
                                }
                            }
                        } : {}
                    }
                });
            }

            createChart(document.getElementById('documentsPerYearChart').getContext('2d'), 'doughnut',
                @json($documentsPerYear->pluck('year')), @json($documentsPerYear->pluck('total')),
                ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'],
                ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)']);

            createChart(document.getElementById('documentsPerMonthChart').getContext('2d'), 'bar',
                @json($documentsPerMonth->map(fn($doc) => \Carbon\Carbon::createFromFormat('m', $doc->month)->locale('id')->monthName . ' ' . $doc->year)), @json($documentsPerMonth->pluck('total')),
                ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)'
                ],
                ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'
                ]);

            createChart(document.getElementById('documentsPerDayChart').getContext('2d'), 'line',
                @json($documentsPerDay->pluck('day')), @json($documentsPerDay->pluck('total')),
                'rgba(75, 192, 192, 0.2)', 'rgba(75, 192, 192, 1)', true);
        </script>
    @endpush
@endsection
