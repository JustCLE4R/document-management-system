@extends('layouts.main')

@section('content')
  <!-- Services Section Start -->
<section id="dokumen" class="section-padding" style="margin-top: 12vh ;">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">{{ strtoupper($h2) }}</h2>
      <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
      <span class="text-secondary wow fadeInDown" data-wow-delay="0.3s">{{ $dokumens->total() }} Dokumen</span>
    </div>
    <form class="row justify-content-center wow fadeInRight mx-2" data-wow-delay="0.3s" action="/daftar-dokumen" method="get">
      <div class="input-group mb-3">
        <select class="form-select p-1 bg-success text-light shadow" name="kriteria" id="" style="width: 90px;">
          <option value="" selected>Kriteria</option>
          @foreach ($kriterias as $kriteria)
            <option value="{{ $kriteria->id }}" {{ request()->input('kriteria') == $kriteria->id ? 'selected' : '' }}>{{ $kriteria->name }}</option>
          @endforeach
        </select>
        <select class="form-select p2  bg-success text-light shadow" name="tipe" id="" style="width: 60px;">
          <option value="" selected>Tipe</option>
          <option value="URL" {{ request()->input('tipe') == 'URL' ? 'selected' : '' }}>URL</option>
          <option value="PDF" {{ request()->input('tipe') == 'PDF' ? 'selected' : '' }}>PDF</option>
          <option value="Image" {{ request()->input('tipe') == 'Image' ? 'selected' : '' }}>Image</option>
        </select>
        @if (Auth::user()->role == 'superadmin')
          <select name="department" class="form-select p-1 bg-success text-light shadow" id="" style="max-width: 125px">
            <option value="" selected>Department</option>
            @foreach ($departments as $department)
              <option value="{{ $department->id }}" {{ request()->input('department') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
            @endforeach
          </select>
        @endif
        <input type="text" class="form-control shadow" name="result" placeholder="Cari Dokumen.."  aria-describedby="button-addon2" value="{{ old('result', request()->input('result')) }}">
        <div class="input-group-append">
          <button class="btn btn-search shadow" id="button-addon2"><i class="bi bi-search"></i></button>
        </div>
      </div>
    </form>
    <div class="row mb-5">
      <!-- Services item -->
      @foreach ($dokumens as $dokumen)
      <div class="col-md-6 col-lg-6 col-xs-12 my-3">
        <a href="{{ $dokumen->tipe == 'URL' ? $dokumen->path : url('storage/'.$dokumen->path) }}" class="box-link"
          target="_blank">
          <div class="box-item border wow fadeInRight m-0" data-wow-delay="0.3s">
            <span class="icon">
              @switch($dokumen->tipe)
              @case('URL')
              <i class="bi bi-link-45deg text-primary"></i>
              <span class="d-block text-white bg-primary mt-1" style="font-size: 10px; border-radius: 20px">URL</span>
              @break
              @case('PDF')
              <i class="bi bi-file-pdf-fill text-danger"></i>
              <span class="d-block text-white bg-danger mt-1" style="font-size: 10px; border-radius: 20px">PDF</span>
              @break
              @case('Image')
              <i class="bi bi-image-fill text-success"></i>
              <span class="d-block text-white bg-success mt-1" style="font-size: 10px; border-radius: 20px">IMG</span>
              @break
              @endswitch
            </span>
            <div class="text p-3">
              @if (Auth::user()->role == 'superadmin')
                <span class="text-secondary float-right" style="font-size: .8rem">{{ $dokumen->user->department->name }}</span>
              @endif
              <h4>{{ $dokumen->name }}</h4> 
              <p class="text-secondary pb-3">
                {{ $dokumen->kriteria->name }}
              </p>
              <p class="mb-4">{{ $dokumen->catatan }}</p>
              <span class="d-flex justify-content-end"><p>{{ \Carbon\Carbon::parse($dokumen->updated_at)->translatedFormat('d F Y') }}</p></span>
            </div>
          </div>
        </a>
      </div>
      @endforeach
      <!-- End Services item -->
    </div>
    <div id="pagenation">
      {{ $dokumens->onEachSide(1)->links() }}
    </div>
    <div class="row mt-5">
      <div class="col-12">
        <a href="/"  class="btn btn-success wow fadeInRight" ata-wow-delay="0.3s"><i class="bi bi-chevron-double-left"></i> Kembali</a>
      </div>
    </div>
  </div>
</section>

<script>
  document.querySelector('form').addEventListener('submit', function(event) {
    const inputs = this.querySelectorAll('select, input[name="result"]');
    inputs.forEach(input => {
      if (!input.value.trim()) {
        input.disabled = true;
      }
    });
  });
</script>

@endsection
