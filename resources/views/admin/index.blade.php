@extends('layouts.main')

@section('content')
<section id="services" class="section-padding">
  <div class="container mt-5">
    <div class="section-header text-center ">
      <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Admin</h2>
      <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
    </div>
    <div class="row justify-content-center" >
      <!-- Services item start -->
      <div class="col-md-6 col-lg-4 col-xs-12" onclick="window.location.href='/admin/dokumen'">
        <div class="services-item bg-light border wow fadeInRight py-5" data-wow-delay="0.3s">
          <div class="icon">
            <i class="lni-cog"></i>
          </div>
          <div class="services-content ">
            <span class="h4 text-success">Dokumen</span>
          </div>
        </div>
      </div>
      <!-- Services item end -->
      
      <!-- Services item start -->
      <div class="col-md-6 col-lg-4 col-xs-12" onclick="window.location.href='/admin/kriteria'">
        <div class="services-item bg-light border wow fadeInRight py-5" data-wow-delay="0.6s">
          <div class="icon">
            <i class="bi bi-card-checklist"></i>
          </div>
          <div class="services-content">
            <span class="h4 text-success">Kriteria</span>
          </div>
        </div>
      </div>
      <!-- Services item end -->

      <!-- Services item start -->
      <div class="col-md-6 col-lg-4 col-xs-12" onclick="window.location.href='/admin/user/{{ Auth::user()->id }}'">
        <div class="services-item bg-light border wow fadeInRight py-5" data-wow-delay="0.9s">
          <div class="icon">
            <i class="bi bi-person-gear"></i>
          </div>
          <div class="services-content">
            <span class="h4 text-success">Akun</span>
          </div>
        </div>
      </div>
      <!-- Services item end -->
    </div>
  </div>
</section>
@endsection