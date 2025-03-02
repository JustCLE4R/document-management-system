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

        @push('scripts')
            <script>
                setTimeout(function() {
                    $('.alert').fadeTo(500, 0).slideUp(500, function(){
                        $(this).remove(); 
                    });
                }, 5000);
            </script>
        @endpush
        <div class="row justify-content-center">
            <!-- Services item start -->
            <div class="col-md-6 col-lg-4 col-xs-12"  onclick="window.location.href='/superadmin/dokumen'">
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
            <div class="col-md-6 col-lg-4 col-xs-12" onclick="window.location.href='/superadmin/department'">
                    <div class="services-item bg-light border wow fadeInRight py-5" data-wow-delay="0.6s">
                        <div class="icon">
                            <i class="bi bi-building-gear"></i>
                        </div>
                        <div class="services-content">
                            <span class="h4 text-success">Department</span>
                        </div>
                    </div>
            </div>
            <!-- Services item end -->

            <!-- Services item start -->
            <div class="col-md-6 col-lg-4 col-xs-12" onclick="window.location.href='/superadmin/user'">
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

            <!-- Services item start -->
            <div class="col-md-6 col-lg-4 col-xs-12" onclick="window.location.href='/superadmin/kriteria'">
                <div class="services-item bg-light border wow fadeInRight py-5" data-wow-delay="1.2s">
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
            <div class="col-md-6 col-lg-4 col-xs-12" onclick="window.location.href='/superadmin/statistik'">
                <div class="services-item bg-light border wow fadeInRight py-5" data-wow-delay="1.5s">
                    <div class="icon">
                        <i class="bi bi-card-checklist"></i>
                    </div>
                    <div class="services-content">
                        <span class="h4 text-success">Statistik</span>
                    </div>
                </div>
            </div>
            <!-- Services item end -->
        </div>
    </div>
</section>
@endsection