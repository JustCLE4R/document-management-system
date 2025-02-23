@extends('layouts.main')

@section('content')
<section id="services" class="section-padding">
  <div class="container mt-5">
    <div class="section-header text-center ">
      <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Super Admin</h2>
      <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
    </div>

    <div class="row justify-content-center mt-3 wow fadeInDown">
      <div class="col-6">
          @if (session('status'))
          <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
              <i class="bi bi-check-circle me-2"></i>
              {{ session('status') }}
          </div>
          @endif
          @if (session('error'))
          <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
              <i class="bi bi-exclamation-circle me-2"></i>
              {{ session('error') }}
          </div>
          @endif
      </div>
  </div>
  
  <script>
      setTimeout(function() {
          $('.alert').fadeTo(500, 0).slideUp(500, function(){
              $(this).remove(); 
          });
      }, 5000);
  </script>

    <div class="row justify-content-center" >
      <!-- Services item -->
      <div class="col-md-6 col-lg-4 col-xs-12">
        <a class="h4 text-success" href="/superadmin/dokumen">
        <div class="services-item bg-light border wow fadeInRight py-5" data-wow-delay="0.3s">
          <div class="icon">
            <i class="lni-cog"></i>
          </div>
          <div class="services-content ">
            <span ><a class="h4 text-success" href="/superadmin/dokumen">Dokumen</a></span>
          </div>
        </div>
        </a>
      </div>
      <!-- Services item -->
      <div class="col-md-6 col-lg-4 col-xs-12">
        <a href="/superadmin/prodi">
        <div class="services-item bg-light border wow fadeInRight py-5" data-wow-delay="0.6s">
          <div class="icon">
            <i class="bi bi-building-gear"></i>
          </div>
          <div class="services-content">
            <span ><a class="h4 text-success" href="/superadmin/prodi">Program Studi</a></span>
          </div>
        </div>
        </a>
      </div>
      <!-- Services item -->
      <div class="col-md-6 col-lg-4 col-xs-12">
        <a href="/superadmin/user">
        <div class="services-item bg-light border wow fadeInRight py-5" data-wow-delay="0.9s">
          <div class="icon">
            <i class="bi bi-person-gear"></i>
          </div>
          <div class="services-content">
            <span ><a class="h4 text-success" href="/superadmin/user">Akun</a></span>
          </div>
        </div>
        </a>
      </div>
      <!-- Services item -->
      {{-- <div class="col-md-6 col-lg-4 col-xs-12">
        <a target="_blank" href="https://docs.google.com/spreadsheets/d/1SCwfRnSgaFCljjba6L42icLdfQZl-ZCBsbXy8hiFHr4/edit#gid=0">
        <div class="services-item bg-light border wow fadeInRight py-5" data-wow-delay="1.2s">
          <div class="icon">
            <i class="bi bi-bar-chart-steps"></i>
          </div>
          <div class="services-content">
            <span ><a class="h4 text-success" target="_blank" href="https://docs.google.com/spreadsheets/d/1SCwfRnSgaFCljjba6L42icLdfQZl-ZCBsbXy8hiFHr4/edit#gid=0">Program Studi</a></span>
          </div>
        </div>
        </a>
      </div> --}}
    </div>
  </div>
</section>
@endsection