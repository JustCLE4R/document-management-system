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
  

  <div class="row mb-5 g-3 g-md-4">
    <div class="col-md-3">
      <div class="card text-dark border-primary mb-3 h-100">
        <div class="card-body">
          <h5 class="card-title">📁 Total Dokumen</h5>
          <hr>
          <p class="card-text display-4">{{ $totalDocuments }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-dark border-info mb-3 h-100">
        <div class="card-body">
          <h5 class="card-title">🏷️ Total Kriteria</h5>
          <hr>
          <p class="card-text display-4">{{ $totalKriteria }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-dark border-warning mb-3 h-100">
        <div class="card-body">
          <h5 class="card-title">🏢 Total Departemen</h5>
          <hr>
          <p class="card-text display-4">{{ $totalDepartment }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card bg-light text-dark border-success shadow-sm mb-3 h-100">
        <div class="card-body">
          <h5 class="card-title text-success">🆕 Dokumen Baru</h5>
          <hr>
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
    @foreach($mostViewedDocuments as $doc)
      <li class="list-group-item d-flex justify-content-between align-items-center">
        {{ $doc->name }}
        <span class="badge bg-primary rounded-pill">🔥 {{ $doc->views }} view(s)</span>
      </li>
    @endforeach
  </ul>

  <h4 class="mb-3 text-dark" style="font-weight: bold; font-size: 1.5rem">🏢 Dokumen Terbanyak per Departemen</h4>
  <ul class="list-group mb-5">
    @foreach($documentByDepartment as $department)
      <li class="list-group-item d-flex justify-content-between align-items-center">
        {{ $department->department_name }}
        <span class="badge bg-secondary">📂 {{ $department->total }} doc(s)</span>
      </li>
    @endforeach
  </ul>

  <h4 class="mb-3 text-dark" style="font-weight: bold; font-size: 1.5rem">📚 Dokumen Terbanyak per Kriteria</h4>
  <ul class="list-group mb-5">
    @foreach($documentsByKriteria as $kriteria)
      <li class="list-group-item d-flex justify-content-between align-items-center">
        {{ ucfirst($kriteria->kriteria->name) }}: {{ $kriteria->kriteria->department->name }}
        <span class="badge bg-secondary">📂 {{ $kriteria->total }} doc(s)</span>
      </li>
    @endforeach
  </ul>

  <h4 class="mb-3 text-dark" style="font-weight: bold; font-size: 1.5rem">🔄 Dokumen dengan Revisi Terbanyak</h4>
  <ul class="list-group mb-5">
    @foreach($mostRevisedDocuments as $doc)
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
document.addEventListener("DOMContentLoaded", function () {
  const documents = @json($mostRecentDocuments->map(fn($doc) => 
    "<strong>" . $doc->name . "</strong><br>" .
    "📅 " . \Carbon\Carbon::parse($doc->created_at)->format('d M Y H:i') . " WIB | " .
    "📂 " . $doc->kriteria->name . " | " .
    "👤 " . $doc->user->department->name
)->toArray()); // Convert to array for JSON encoding

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
            ticks: { autoSkip: true, maxTicksLimit: 10 } 
          },
          y: { 
            beginAtZero: true 
          }
        },
        plugins: zoomable ? {
          zoom: {
            pan: { enabled: true, mode: 'x' },
            zoom: { wheel: { enabled: true }, pinch: { enabled: true }, mode: 'x' }
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
    ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)'], 
    ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)']);

  createChart(document.getElementById('documentsPerDayChart').getContext('2d'), 'line', 
    @json($documentsPerDay->pluck('day')), @json($documentsPerDay->pluck('total')),
    'rgba(75, 192, 192, 0.2)', 'rgba(75, 192, 192, 1)', true);
</script>
@endpush


@endsection
