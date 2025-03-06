
@extends('layouts.main')

@section('content')

<section class="section-padding" style="margin-top: 12vh;">
  <div class="section-header text-center">
    <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Lihat Dokumen</h2>
    <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
  </div>
  <div class="row justify-content-center p-3" >

    <div class="col-md-8 col-lg-6 my-2 ">
      <div class="box-link">
        <div class="box-item border wow fadeInRight" data-wow-delay="0.3s">
          <div class="text">
            <h4 class="pe-4" style="font-size:1.2rem; ">{{ $dokumen->name }}</h4>
            <p class="text-secondary pb-3">
              {{ $dokumen->kategori->description }}
            </p>
            <p style="font-size:1.3rem; "> {{ $dokumen->sub_kategori }}</p>
            <p>{{ $dokumen->catatan }}</p>
            <p> <a id="a" href="{{ $dokumen->tipe == 'URL' ? $dokumen->path : '/storage/'.$dokumen->path }}" class="text-success">{{ $dokumen->tipe == 'URL' ? $dokumen->path : basename($dokumen->path) }}</a></p>
            <span class="d-flex justify-content-between">
              <p >{{ \Carbon\Carbon::parse($dokumen->updated_at)->translatedFormat('d F Y') }}</p>
              <p>{{ $dokumen->kategori }} | <span > {{ $dokumen->tipe }}</span></p>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


@endsection