@extends('layouts.main')

@section('content')
<section class="section-padding" style="margin-top: 9vh ;">
  <div class="section-header text-center">
    <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Program Studi Baru</h2>
    <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
  </div>
  <div class="container border rounded shadow" style="width:70%;">
    
    <form action="/superadmin/prodi/{{ $prodi->id }}" id="form" method="POST" enctype="multipart/form-data">
      <div class="row justify-content-between align-items-center p-3">
        @csrf
        @method('PUT')
        <div class="col-lg-6 col-md-6 col-sm-12 my-2">
            <label for="nama" class=" text-dark h6">Nama Program Studi</label>
            <input  class="form-control @error('nama') is-invalid @enderror" type="text" name="nama" id="nama" value="{{ old('nama', $prodi->nama) }}" required>
            @if ($errors->has('nama'))
              <p class="error text-danger">{{ $errors->first('nama') }}</p>
            @endif
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-between">
          <a href="/superadmin/prodi"  class="btn btn-success wow fadeInRight" ata-wow-delay="0.3s"><i class="bi bi-chevron-double-left"></i> Kembali</a>
          <button class="btn btn-success mx-1 wow fadeInRight" type="submit"><i class="bi bi-check-lg"></i> Submit</button>
        </div>
      </div>
    </form>

  </div>
</section>
@endsection