@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="/css/main.css" />	
<link rel="stylesheet" href="/css/lindy-uikit.css"/>
<link rel="stylesheet" href="/css/tiny-slider.css" />
<link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div id="hero-area" class="hero-area-bg" >
  <div class="container">      
    <div class="row">
      <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
        <div class="contents move-effect ">
          <h4> 
        Halo,
        @if (Auth::user()->role == 'superadmin')
            Superadmin!
        @elseif (Auth::user()->role == 'admin')
            Admin
            {{ Auth::user()->programStudi->nama }}!
        @else
            Asesor
            {{ Auth::user()->programStudi->nama }}!
            
        @endif
    </h4>
          <h2 class="head-title wow fadeInRight" ata-wow-delay="0.3s">Selamat Datang di Website Pusat Data Akreditasi Prodi</h2>
          <p class=" wow fadeInRight" ata-wow-delay="0.3s">Pusat Data Bukti Fisik Pendukung Akreditasi Prodi Universitas Islam Negeri Sumatera Utara Medan</p>
          <div class="header-button wow fadeInRight" ata-wow-delay="0.5s">
            <form class="d-inline" action="/daftar-dokumen" method="get">
              <div class="input-group mb-3">
                <select class="form-select p-1 bg-success text-light shadow" name="kriteria" id="" style="width: 80px;">
                  <option value="" selected>Kriteria</option>
                  @for ($i = 1; $i <= 9; $i++)
                  <option value="{{ $i }}" {{ request()->input('kriteria') == $i ? 'selected' : '' }}>{{ 'Kriteria '.$i }}</option>
                  @endfor
                  <option value="10" {{ request()->input('kriteria') == '10' ? 'selected' : '' }}>Kondisi Eksternal</option>
                  <option value="11" {{ request()->input('kriteria') == '11' ? 'selected' : '' }}>Profil Institusi</option>
                  <option value="12" {{ request()->input('kriteria') == '12' ? 'selected' : '' }}>Analisis & Penetapan Program Pengembangan</option>
                </select>
                <select class="form-select p2 bg-success text-light shadow" name="tipe" id="" style="width: 60px;">
                  <option value="" selected>Tipe</option>
                  <option value="URL" {{ request()->input('tipe') == 'URL' ? 'selected' : '' }}>URL</option>
                  <option value="PDF" {{ request()->input('tipe') == 'PDF' ? 'selected' : '' }}>PDF</option>
                  <option value="Image" {{ request()->input('tipe') == 'Image' ? 'selected' : '' }}>Image</option>
                </select>
                @if (Auth::user()->role == 'superadmin')
                  <select class="form-select p-1 bg-success text-light shadow" name="prodi" id="" style="max-width: 70px">
                    <option value="" selected>Prodi</option>
                    @foreach ($prodis as $prodi)
                      <option value="{{ $prodi->id }}" {{ request()->input('prodi') == $prodi->id ? 'selected' : '' }}>{{ $prodi->nama }}</option>
                    @endforeach
                  </select>
                @endif
                <input type="text" class="form-control shadow" name="result" placeholder="Cari Dokumen.." value="{{ old('result', request()->input('result')) }}">
                <div class="input-group-append">
                  <button class="btn btn-search shadow" id="button-addon2"><i class="bi bi-search"></i></button>
                </div>
              </div>
            </form>
          </div>
          <div class="row wow fadeInRight" ata-wow-delay="0.7s">
            <div class="col-lg-3 col-6">
              <div class="stats-item text-center">
                <span id="kriteriaCounter" class="purecounter">0</span>
                <p>Kriteria</p>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="stats-item text-center">
                <span id="dokumenCounter" class="purecounter">0</span>
                <p>Dokumen</p>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="stats-item text-center">
                <span id="fakultasCounter" class="purecounter">0</span>
                <p>Fakultas/PPs</p>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="stats-item text-center">
                <span id="prodiCounter" class="purecounter">0</span>
                <p>Prodi</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
        <div class="intro-img wow fadeInRight" ata-wow-delay="0.8s">
          <div class="hero-figure-box hero-figure-box-09 move-effect" ></div>
          <div class="hero-figure-box hero-figure-box-07 move-effect" ></div>
          <div class="hero-figure-box hero-figure-box-08 " data-wow-delay=".5s" data-rotation="-22deg" style="transform: rotate(-22deg) scale(1); opacity: 1;"></div>
          <img class="img-fluid move-effect" src="/img/header-hero.svg" alt="">
        </div>            
      </div>
    </div>
  </div> 
</div>



<section id="services" class="section-padding">
  <div class="container">
    <div class="section-header text-center">
      <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Laporan Evaluasi Diri</h2>
      <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
    </div>
    <div class="row">

      <div class="col-md-6 col-lg-4 col-xs-12" onclick="window.location.href = '/daftar-dokumen?kriteria=10'">
        <div class="services-item wow fadeInRight border border" data-wow-delay="0.3s" >
          <div class="bg-img" style="background-image: url('/img/kriteria/kondisi.png');">
            <div class="icon bg-light">
              <i class="bi bi-globe2"></i>
            </div>
          </div>
          <div class="services-content p-3 pb-3">
            <h3><a href="/daftar-dokumen?kriteria=10">Kondisi </a></h3>
            <p>Eksternal</p>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-4 col-xs-12" onclick="window.location.href = '/daftar-dokumen?kriteria=11'">
        <a href="/daftar-dokumen?kriteria=11" >
          <div class="services-item bg-light wow fadeInRight border" data-wow-delay="0.6s" >
          <div class="bg-img" style="background-image: url('/img/kriteria/profil.jpg');">
            <div class="icon bg-light ">
              <i class="bi bi-building-fill-gear"></i>
            </div>
          </div>
          <div class="services-content p-3">
            <h3><a href="/daftar-dokumen?kriteria=11">Profil </a></h3>
            <p>Institusi</p>
          </div>
        </div>
        </a>
      </div>

      <div class="col-md-6 col-lg-4 col-xs-12" onclick="window.location.href = '/daftar-dokumen?kriteria=1'">
        <a href="/daftar-dokumen?kriteria=1" >
        <div class="services-item bg-light wow fadeInRight border" data-wow-delay="0.9s" >
          <div class="bg-img" style="background-image: url('/img/kriteria/kriteria-1.webp');">
            <div class="icon bg-light ">
              <i class="bi bi-flag"></i>
            </div>
          </div>
          <div class="services-content p-3">
            <h3><a href="/daftar-dokumen?kriteria=1">Kriteria 1</a></h3>
            <p>Visi, Misi, Tujuan dan Startegi</p>
          </div>
        </div>
        </a>
      </div>

      <div class="col-md-6 col-lg-4 col-xs-12"  onclick="window.location.href = '/daftar-dokumen?kriteria=2'">
        <a href="/daftar-dokumen?kriteria=2" >
        <div class="services-item bg-light wow fadeInRight border" data-wow-delay="1.2s" >
          <div class="bg-img" style="background-image: url('/img/kriteria/kriteria-2.jpg');">
            <div class="icon bg-light ">
              <i class="bi bi-people"></i>
            </div>
          </div>
          <div class="services-content p-3">
            <h3><a href="/daftar-dokumen?kriteria=2">Kriteria 2</a></h3>
            <p>Tata Pamong, Tata Kelola, dan Kerja Sama</p>
          </div>
        </div>
        </a>
      </div>
     
      <div class="col-md-6 col-lg-4 col-xs-12"  onclick="window.location.href = '/daftar-dokumen?kriteria=3'">
      <a href="/daftar-dokumen?kriteria=3" >
        <div class="services-item bg-light wow fadeInRight border" data-wow-delay="1.5s" >
          <div class="bg-img" style="background-image: url('/img/kriteria/kriteria-3.jpg');">
            <div class="icon bg-light ">
              <i class="bi bi-mortarboard"></i>
            </div>
          </div>
          <div class="services-content p-3">
            <h3><a href="/daftar-dokumen?kriteria=3">Kriteria 3</a></h3>
            <p>Mahasisawa</p>
          </div>
        </div>
        </a>
      </div>
     
      <div class="col-md-6 col-lg-4 col-xs-12" data-wow-delay="1.5s" onclick="window.location.href = '/daftar-dokumen?kriteria=4'">
        <a href="/daftar-dokumen?kriteria=4" >
        <div class="services-item bg-light wow fadeInRight border" data-wow-delay="1.8s">
          <div class="bg-img" style="background-image: url('/img/kriteria/kriteria-4.avif');">
            <div class="icon bg-light ">
              <i class="bi bi-person-standing"></i>
            </div>
          </div>
          <div class="services-content p-3">
            <h3><a href="/daftar-dokumen?kriteria=4">Kriteria 4</a></h3>
            <p>Sumber Daya Manusia</p>
          </div>
        </div>
        </a>
      </div>
     
      <div class="col-md-6 col-lg-4 col-xs-12" data-wow-delay="1.5s" onclick="window.location.href = '/daftar-dokumen?kriteria=5'">
        <a href="/daftar-dokumen?kriteria=5" >
        <div class="services-item bg-light wow fadeInRight border" data-wow-delay="1.2s">
          <div class="bg-img" style="background-image: url('/img/kriteria/kriteria-5.png');">
            <div class="icon bg-light ">
              <i class="bi bi-gear-wide-connected"></i>
            </div>
          </div>
          <div class="services-content p-3">
            <h3><a href="/daftar-dokumen?kriteria=5">Kriteria 5</a></h3>
            <p>Keuangan, Sarana dan Prasarana</p>
          </div>
        </div>
        </a>
      </div>
     
      <div class="col-md-6 col-lg-4 col-xs-12" data-wow-delay="1.5s" onclick="window.location.href = '/daftar-dokumen?kriteria=6'">
        <a href="/daftar-dokumen?kriteria=6" >
        <div class="services-item bg-light wow fadeInRight border" data-wow-delay="1.5s">
          <div class="bg-img" style="background-image: url('/img/kriteria/kriteria-6.jpg');">
            <div class="icon bg-light ">
              <i class="bi bi-book-half"></i>
            </div>
          </div>
          <div class="services-content p-3">
            <h3><a href="/daftar-dokumen?kriteria=6">Kriteria 6</a></h3>
            <p>Pendidikan</p>
          </div>
        </div>
        </a>
      </div>
     
      <div class="col-md-6 col-lg-4 col-xs-12" data-wow-delay="1.5s" onclick="window.location.href = '/daftar-dokumen?kriteria=7'">
        <a href="/daftar-dokumen?kriteria=7" >
        <div class="services-item bg-light wow fadeInRight border" data-wow-delay="1.8s">
          <div class="bg-img" style="background-image: url('/img/kriteria/kriteria-7.svg');">
            <div class="icon bg-light ">
              <i class="bi bi-journal"></i>
            </div>
          </div>
          <div class="services-content p-3">
            <h3><a href="/daftar-dokumen?kriteria=7">Kriteria 7</a></h3>
            <p>Penelitian</p>
          </div>
        </div>
        </a>
      </div>
     
      <div class="col-md-6 col-lg-4 col-xs-12" data-wow-delay="1.5s" onclick="window.location.href = '/daftar-dokumen?kriteria=8'">
        <a href="/daftar-dokumen?kriteria=8" >
        <div class="services-item bg-light wow fadeInRight border" data-wow-delay="1.2s">
          <div class="bg-img" style="background-image: url('/img/kriteria/kriteria-8.jpg');">
            <div class="icon bg-light ">
              <i class="bi bi-heart-pulse-fill"></i>
            </div>
          </div>
          <div class="services-content p-3">
            <h3><a href="/daftar-dokumen?kriteria=8">Kriteria 8</a></h3>
            <p>Pengabian Kepada Masyarakat</p>
          </div>
        </div>
        </a>
      </div>
     
      <div class="col-md-6 col-lg-4 col-xs-12" data-wow-delay="1.5s" onclick="window.location.href = '/daftar-dokumen?kriteria=9'">
        <a href="/daftar-dokumen?kriteria=9" >
        <div class="services-item bg-light border wow fadeInRight " data-wow-delay="1.5s">
          <div class="bg-img" style="background-image: url('/img/kriteria/kriteria-9.jpg');">
            <div class="icon bg-light ">
              <i class="bi bi-trophy"></i>
            </div>
          </div>
          <div class="services-content p-3">
            <h3><a href="/daftar-dokumen?kriteria=9">Kriteria 9</a></h3>
            <p>Luaran dan Capaian Tridharma</p>
          </div>
        </div>
        </a>
      </div>
     
      <div class="col-md-6 col-lg-4 col-xs-12" data-wow-delay="1.5s" onclick="window.location.href = '/daftar-dokumen?kriteria=12'">
        <a href="/daftar-dokumen?kriteria=12" >
        <div class="services-item bg-light wow fadeInRight border" data-wow-delay="1.8s">
          <div class="bg-img" style="background-image: url('/img/kriteria/kriteria-10.png');">
            <div class="icon bg-light ">
              <i class="bi bi-graph-up-arrow"></i>
            </div>
          </div>
          <div class="services-content p-3">
            <h3><a href="/daftar-dokumen?kriteria=12">Analisis & Penetapan</a></h3>
            <p>Program Pengembangan</p>
          </div>
        </div>
        </a>
      </div>
    </div>
  </div>
</section>

<div class="about-area section-padding bg-gray">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-xs-12 info">
        <div class="about-wrapper wow fadeInLeft" data-wow-delay="0.3s">
          <div>
            <div class="site-heading">
              <h2 class="h5" style="font-size: 2rem !important;">Data Program Studi Utama UIN Sumatera Utara Medan</h2>
            </div>

            <div class="content " style="overflow-x: auto; max-width: 100vw;">
                <div>
                    <table id="data-table" class="table table-hover border">
                        <thead class="wow fadeInRight " data-wow-delay=".5s">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Fakultas</th>
                                <th scope="col">Program Studi</th>
                                <th scope="col">Strata</th>
                                <th scope="col">No. SK Akreditasi</th>
                                <th scope="col">Tahun SK</th>
                                <th scope="col">Nilai</th>
                                <th scope="col">Peringkat</th>
                                <th scope="col">Tanggal Daluarsa</th>
                            </tr>
                        </thead>
                        <tbody class="wow fadeInRight " data-wow-delay=".8s"></tbody>
                    </table>
                </div>
            
                <nav aria-label="Page navigation example" style="position: relative !important">
                    <ul id="pagination" class="pagination">
                        <li class="page-item" id="prev-page">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item" id="next-page">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<section id="pricing" class="pricing-section pricing-style-4 bg-light">
  <div class="container">
    <div class="row align-items-center">
    <div class="col-xl-5 col-lg-6">
      <div class="section-title mb-60">
      <h3 class="mb-15 wow fadeInUp" data-wow-delay=".2s">Aplikasi Layanan</h3>
      <p class="wow fadeInUp" data-wow-delay=".4s">UIN Sumatera Utara Memiliki Banyak Layanan Aplikasi Dalam Mengelola dan Memanajemen Sistem Yang Ada Dikampus</p>
      </div>
    </div>
    <div class="col-xl-7 col-lg-6">
      <div class="pricing-active-wrapper wow fadeInUp" data-wow-delay=".4s">
      <div class="pricing-active">
        <div class="single-pricing-wrapper">
        <div class="single-pricing">
          <h4>Portal SIA</h4>
          <h3><i class="bi bi-gear"></i></h3>
          <p>Menangani Sistem Informasi Akademik Dosen dan Mahasiswa UIN Sumatera Utara</p>
          <a href="https://portalsia.uinsu.ac.id " target="_blank" class="button radius-30 mt-2">Kunjungi <i class="lni lni-angle-double-right"></i> </a>
        </div>
        </div>
        <div class="single-pricing-wrapper">
        <div class="single-pricing">
          <h4>SI-PMB</h4>
          <h3><i class="bi bi-person-bounding-box"></i></h3>
          <p>Menangani Sistem Informasi Penerimaan Mahasiswa Baru UIN Sumatera Utara</p>
          <a href="https://sipmb.uinsu.ac.id " target="_blank" class="button radius-30 mt-2">Kunjungi <i class="lni lni-angle-double-right"></i></a>
        </div>
        </div>
        <div class="single-pricing-wrapper">
        <div class="single-pricing">
          <h4>SI-MABA</h4>
          <h3><i class="bi bi-person-standing"></i></h3>
          <p>Menangani Sistem Informasi Daftar Ulang Mahasiswa Baru UIN Sumatera Utara</p>
          <a href="https://maba.uinsu.ac.id " target="_blank" class="button radius-30 mt-2">Kunjungi <i class="lni lni-angle-double-right"></i></a>
        </div>
        </div>
        <div class="single-pricing-wrapper">
        <div class="single-pricing">
          <h4>SI-SELMA</h4>
          <h3><i class="bi bi-person-circle"></i></h3>
          <p>Menangani Sistem Informasi Surat Elektronik Mahasiswa UIN Sumatera Utara</p>
          <a href="https:// .uinsu.ac.id " target="_blank" class="button radius-30 mt-2">Kunjungi <i class="lni lni-angle-double-right"></i></a>
        </div>
        </div>
        <div class="single-pricing-wrapper">
        <div class="single-pricing">
          <h4>SI-LIANA</h4>
          <h3><i class="bi bi-check2-all"></i></h3>
          <p>Menangani Tentang Sistem Informasi Kuliah Kerja Nyata di UIN Sumatera Utara</p>
          <a href="https://siselma.uinsu.ac.id " target="_blank" class="button radius-30 mt-2">Kunjungi <i class="lni lni-angle-double-right"></i></a>
        </div>
        </div>
        <div class="single-pricing-wrapper">
        <div class="single-pricing">
          <h4>E-LEARNING</h4>
          <h3><i class="bi bi-mortarboard-fill"></i></h3>
          <p>Menangani Tentang Sistem Informasi Pembelajaran Online di UIN Sumatera Utara</p>
          <a href="https://elearning.uinsu.ac.id " target="_blank" class="button radius-30 mt-2">Kunjungi <i class="lni lni-angle-double-right"></i></a>
        </div>
        </div> 	
        <div class="single-pricing-wrapper">
        <div class="single-pricing">
          <h4>SI-JURNAL</h4>
          <h3><i class="bi bi-journals"></i></h3>
          <p>Menangani Tentang Sistem Informasi Jurnal Universitas Islam Negeri Sumatera Utara</p>
          <a href="https://sijurnal.uinsu.ac.id " target="_blank" class="button radius-30 mt-2">Kunjungi <i class="lni lni-angle-double-right"></i></a>
        </div>
        </div> 
        <div class="single-pricing-wrapper">
        <div class="single-pricing">
          <h4>SI-LIBRARY</h4>
          <h3><i class="bi bi-book-half"></i></h3>
          <p>Menangani Website Perpustakaan Universitas Islam Negeri Sumatera Utara</p>
          <a href="https://silibrary.uinsu.ac.id " target="_blank" class="button radius-30 mt-2">Kunjungi <i class="lni lni-angle-double-right"></i></a>
        </div>
        </div> 
        <div class="single-pricing-wrapper">
        <div class="single-pricing">
          <h4>REPOSITORY</h4>
          <h3><i class="bi bi-bookmarks-fill"></i></h3>
          <p>Menangani Sistem Informasi Repositori Universitas Islam Negeri Sumatera Utara</p>
          <a href="https://repository.uinsu.ac.id " target="_blank" class="button radius-30 mt-2">Kunjungi <i class="lni lni-angle-double-right"></i></a>
        </div>
        </div> 
        <div class="single-pricing-wrapper">
        <div class="single-pricing">
          <h4>SI-PUSAKA</h4>
          <h3><i class="bi bi-chat-square-dots-fill"></i></h3>
          <p>Menangani Sistem Informasi Pengajuan Surat Bebas Pustaka UIN Sumatera Utara</p>
          <a href="https://sipusaka.uinsu.ac.id " target="_blank" class="button radius-30 mt-2">Kunjungi <i class="lni lni-angle-double-right"></i></a>
        </div>
        </div> 
        <div class="single-pricing-wrapper">
        <div class="single-pricing">
          <h4>SI-RASIDA</h4>
          <h3><i class="bi bi-mortarboard"></i></h3>
          <p>Menangani Sistem Informasi Pendaftaran Sidang dan Wisuda di UINSU</p>
          <a href="https://sirasida.uinsu.ac.id " target="_blank" class="button radius-30 mt-2">Kunjungi <i class="lni lni-angle-double-right"></i></a>
        </div>
        </div> 
        <div class="single-pricing-wrapper">
        <div class="single-pricing">
          <h4>SI-KIP</h4>
          <h3><i class="bi bi-person-vcard-fill"></i></h3>
          <p>Menangani Sistem Informasi Penjaringan Beasiswa KIP UIN Sumatera Utara</p>
          <a href="https://kip.uinsu.ac.id " target="_blank" class="button radius-30 mt-2">Kunjungi <i class="lni lni-angle-double-right"></i></a>
        </div>
        </div> 
        <div class="single-pricing-wrapper">
        <div class="single-pricing">
          <h4>UMM</h4>
          <h3><i class="bi bi-pencil-square"></i></h3>
          <p>Menangani Sistem Informasi Ujian Masuk Mandiri Online UIN Sumatera Utara</p>
          <a href="https://umm.uinsu.ac.id " target="_blank" class="button radius-30 mt-2">Kunjungi <i class="lni lni-angle-double-right"></i></a>
        </div>
        </div> 
        <div class="single-pricing-wrapper">
        <div class="single-pricing">
          <h4>SI-DAHLIA</h4>
          <h3><i class="bi bi-info-circle-fill"></i></h3>
          <p>Menangani Sistem Informasi Daftar Hadir Kuliah di UIN Sumatera Utara</p>
          <a href="https://.uinsu.ac.id " target="_blank" class="button radius-30 mt-2">Kunjungi <i class="lni lni-angle-double-right"></i></a>
        </div>
        </div> 
        <div class="single-pricing-wrapper">
        <div class="single-pricing">
          <h4>SI-RALINE</h4>
          <h3><i class="bi bi-person-check"></i></h3>
          <p>Menangani Sistem Informasi Presensi Online di Kampus UIN Sumatera Utara</p>
          <a href="https://siraline.uinsu.ac.id " target="_blank" class="button radius-30 mt-2">Kunjungi <i class="lni lni-angle-double-right"></i></a>
        </div>
        </div> 
        <div class="single-pricing-wrapper">
        <div class="single-pricing">
          <h4>LKP</h4>
          <h3><i class="bi bi-person-fill-gear"></i></h3>
          <p>Menangani Sistem Informasi Laporan Kinerja di Kampus UIN Sumatera Utara</p>
          <a href="https://lkp.uinsu.ac.id " target="_blank" class="button radius-30 mt-2">Kunjungi <i class="lni lni-angle-double-right"></i></a>
        </div>
        </div> 

      </div>
      </div>
    </div>
    </div>
  </div>
</section>

<section id="service" class="service-section img-bg pt-100 pb-100 ">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xxl-6 col-xl-9 col-lg-12 col-md-12">
        <div class="section-title text-center mb-50 wow fadeInUp" data-wow-delay=".5s">
          <h3>Virtual Tour </h3>
          <p>UIN Sumatera Utara Menyediakan Sarana Virtual Tour Bagi Para Pengunjung Yang Ingin Mengunjungi Setiap Kampus UINSU Secara Virtual</p>
        </div>
      </div>
    </div>

    <div class="row  justify-content-center">
      <div class="col-xl-4 col-md-6">
        <div class="single-service">
          <div class="icon color-1">
            <i class="lni lni-map-marker"></i>
          </div>
          <div class="content wow fadeInUp" data-wow-delay=".5s">
            <h3>Kampus I UINSU</h3>								
            <p>Berlokasikan di Jl. Sutomo Ujung Kota Medan, Sumatera Utara</p>
            <a href="https://sutomo.uinsu.ac.id/" class="button-sm radius-30 mt-2">Kunjungi <i class="lni lni-angle-double-right"></i></a>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-md-6">
        <div class="single-service">
          <div class="icon color-2">
            <i class="lni lni-map-marker"></i>
          </div>
          <div class="content wow fadeInUp" data-wow-delay=".5s">
            <h3>Kampus II UINSU</h3>
            <p>Berlokasikan di Jl. William Iskandar Ps. V, Kab Deli Serdang, Sumatera Utara</p>
            <a href="https://pancing.uinsu.ac.id/" class="button-sm radius-30 mt-2">Kunjungi <i class="lni lni-angle-double-right"></i></a>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-md-6">
        <div class="single-service">
          <div class="icon color-3">
            <i class="lni lni-map-marker"></i>
          </div>
          <div class="content wow fadeInUp" data-wow-delay=".5s">
            <h3>Kampus IV UINSU</h3>
            <p>Berlokasikan di Jl. Lap. Golf No.120, Kab Deli Serdang, Sumatera Utara </p>
            <a href="https://tuntungan.uinsu.ac.id/" class="button-sm radius-30 mt-2">Kunjungi <i class="lni lni-angle-double-right"></i></a>
          </div>
        </div>
      </div>
    </div>


  </div>
</section>

<!-- About Section start -->
<div class="about-area section-padding bg-gray">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-12 col-xs-12 info">
        <div class="about-wrapper wow fadeInLeft" data-wow-delay="0.3s">
          <div>
            <div class="site-heading">
              <p class="mb-3">Profil Tentang</p>
              <h2 class="section-title">Universitas Islam Negeri Sumatera Utara Medan</h2>
            </div>
            <div class="content">
              <p>
                UIN Sumatera Utara Medan, yang sering dikenal dengan singkatan UINSU, adalah sebuah lembaga pendidikan tinggi Islam yang berlokasi di Medan, Sumatera Utara. Keberadaan UINSU adalah suatu kebanggaan bagi kami semua, dan hal ini tercermin dalam berbagai aspek kehidupan kampus ini.UIN Sumatera Utara Medan memiliki 8 Fakultas dan 1 Program Pascasarjana. UINSU adalah kampus islam yang memiliki moto “Smart Islamic University”
              </p>
              <a href="https://uinsu.ac.id"  class="btn btn-success mt-3">Kunjungi <i class="bi bi-chevron-double-right"></i></a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-12 col-xs-12 wow fadeInRight " data-wow-delay="0.3s">
        <img class="img-fluid" src="/img/logo.png" alt="" >
      </div>
    </div>
  </div>
</div>
<!-- About Section End -->

<!-- Features Section Start -->
<section id="features" class="section-padding">
  <div class="container">
    <div class="section-header text-center">          
      <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Visi & Misi</h2>
      <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
    </div>
    <div class="row">
      <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
        <div class="content-left">
          <div class="box-item wow fadeInLeft" data-wow-delay="0.6s">
            <span class="icon  ">
              <i class="lni-laptop-phone"></i>
            </span>
            <div class="text">
              <h4>Integrasi Ilmu (Wahdatul 'Ulum)</h4>
              <p>Menciptakan ulul albab, cendekiawan yang ulama, dan kader bangsa yang menerapkan ilmunya untuk kemajuan Indonesia dan umat manusia.</p>
            </div>
          </div>
          <div class="box-item wow fadeInLeft" data-wow-delay="0.6s">
            <span class="icon  ">
              <i class="lni-laptop-phone"></i>
            </span>
            <div class="text">
              <h4>Pembangunan Peradaban</h4>
              <p>Menetapkan pusat keunggulan institusional dan fakultatif, sebagai kelanjutan dari Sumatera Utara sebagai 'titik nol' peradaban di Asia Tenggara.</p>
            </div>
          </div>
          <div class="box-item wow fadeInLeft" data-wow-delay="0.9s">
            <span class="icon  ">
              <i class="lni-cog"></i>
            </span>
            <div class="text">
              <h4>Moderasi Beragama</h4>
              <p>Menjadikan moderasi beragama sebagai sikap dasar bagi seluruh Sivitas Akademika, sehingga ilmu pengetahuan Islam membawa kebaikan bagi semua.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
        <div class="show-box wow fadeInUp d-flex justify-content-center" data-wow-delay="0.3s">
          <img src="/img/hero/rektor.png" width="450px" alt="">
        </div>
      </div>
      <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
        <div class="content-right">
          <div class="box-item wow fadeInRight" data-wow-delay="0.3s">
            <span class="icon  ">
              <i class="lni-leaf"></i>
            </span>
            <div class="text">
              <h4>Peningkatan Kesejahteraan</h4>
              <p>Meningkatkan kesejahteraan seluruh Dosen dan karyawan Universitas melalui peningkatan grade remunerasi, pemberdayaan Badan Layanan Umum</p>
            </div>
          </div>
          <div class="box-item wow fadeInRight" data-wow-delay="0.6s">
            <span class="icon  ">
              <i class="lni-layers"></i>
            </span>
            <div class="text">
              <h4>Peningkatan Sarana</h4>
              <p>Terus-menerus meningkatkan kelengkapan sarana dan prasarana pembelajaran, berorientasi digital, riset yang bermanfaat bagi pembangunan</p>
            </div>
          </div>
          <div class="box-item wow fadeInRight" data-wow-delay="0.9s">
            <span class="icon  ">
              <i class="lni-leaf"></i>
            </span>
            <div class="text">
              <h4>Pengembangan Ilmu</h4>
              <p> maksimalisasi peran Indonesia dalam pembangunan peradaban sebagai kelanjutan logis dari Sumatera Utara sebagai ‘titik nol’ peradaban</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



<script src="/js/glightbox.min.js"></script>
<script src="/js/tiny-slider.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {
    var jsonData;
    var currentPage = 1;
    var itemsPerPage = 10;

    $.getJSON('dataAkreditasi.json', function(data) {
        jsonData = data;
        displayData();
    });

    function displayData() {
        var startIndex = (currentPage - 1) * itemsPerPage;
        var endIndex = startIndex + itemsPerPage;
        var paginatedData = jsonData.S1.slice(startIndex, endIndex);

        var tbody = $('#data-table tbody');
        tbody.empty();
        $.each(paginatedData, function(index, item) {
            var row = $('<tr>');
            row.append($('<th scope="row">').text(item["No."]));
            row.append($('<td>').text(item.Fakultas));
            row.append($('<td>').text(item.Prodi));
            row.append($('<td>').text(item.Strata));
            row.append($('<td>').text(item["No. SK Akreditasi"]));
            row.append($('<td>').text(item["Tahun SK"]));
            row.append($('<td>').text(item.Nilai));
            row.append($('<td>').text(item.Peringkat));
            row.append($('<td>').text(item["Tanggal Daluarsa"]));
            tbody.append(row);
        });

        // Update pagination
        updatePagination();
    }

    function updatePagination() {
        var totalPages = Math.ceil(jsonData.S1.length / itemsPerPage);
        var pagination = $('#pagination');
        pagination.empty();

        // Previous Page Button
        pagination.append($('<li class="page-item" id="prev-page">')
            .append($('<a class="page-link" href="#" aria-label="Previous">')
                .append($('<span aria-hidden="true">&laquo;</span>'))
                .click(function() {
                    event.preventDefault();
                    if (currentPage > 1) {
                        currentPage--;
                        displayData();
                    }
                })));

        // Page Numbers
        for (var i = 1; i <= totalPages; i++) {
            pagination.append($('<li class="page-item">')
                .append($('<a class="page-link" href="#">').text(i))
                .click(function() {
                    event.preventDefault();
                    currentPage = parseInt($(this).text());
                    displayData();
                }));
        }

        // Next Page Button
        pagination.append($('<li class="page-item" id="next-page">')
            .append($('<a class="page-link" href="#" aria-label="Next">')
                .append($('<span aria-hidden="true">&raquo;</span>'))
                .click(function() {
                    event.preventDefault();
                    if (currentPage < totalPages) {
                        currentPage++;
                        displayData();
                    }
                })));
    }
});
</script>
<script>
  (function() {
      tns({
          container: '.pricing-active',
          autoplay: false,
          mouseDrag: true,
          gutter: 0,
          nav: false,
          controls: true,
          controlsText: [
            '<i class="lni lni-chevron-left prev"></i>',
            '<i class="lni lni-chevron-right prev"></i>',
          ],
          responsive: {
            0: {
              items: 1,
            },
            768: {
              items: 2,
            },
            992: {
              items: 1.2,
            },
            1200: {
              items: 2,
            }
          }
        });
})();

  document.addEventListener('DOMContentLoaded', function() {
    function animateValue(id, start, end, duration) {
      if (start === end) return;
      var range = end - start;
      var current = start;
      var increment = end > start ? 1 : -1;
      var stepTime = Math.abs(Math.floor(duration / range));
      var obj = document.getElementById(id);
      var timer = setInterval(function() {
        current += increment;
        obj.innerText = current;
        if (current === end) {
          clearInterval(timer);
        }
      }, stepTime);
    }
  
    animateValue('kriteriaCounter', 0, 9, 2000);
    animateValue('dokumenCounter', 0, {{ $dokumenCount }}, 2000);
    animateValue('fakultasCounter', 0, 9, 2000);
    animateValue('prodiCounter', 0, 63, 2000);
  });

  document.querySelector('form').addEventListener('submit', function(event) {
    const inputs = this.querySelectorAll('select, input[name="result"]');
    inputs.forEach(input => {
      if (!input.value.trim()) {
        input.disabled = true;
      }
    });
  });
  </script>
@if (session()->has('success'))
<script>
  // Call the createToast function after the document has finished loading
  document.addEventListener("DOMContentLoaded", function() {
      createToast("success", "{{ session('success') }}");
  });
</script>
@elseif (session()->has('error'))
<script>
  // Call the createToast function after the document has finished loading
  document.addEventListener("DOMContentLoaded", function() {
      createToast("error", "{{ session('error') }}");
  });
</script>
@endif



@endsection