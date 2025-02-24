@extends('layouts.main')

@section('content')
<section class="section-padding" style="margin-top: 1.8rem;">
  <div class="section-header text-center">
    <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Informasi Akun</h2>
    <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
  </div>

  <div class="row justify-content-center mt-3 wow fadeInDown">
    <div class="col-6">
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {!! session('success') !!}
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>
            {!! session('error') !!}
        </div>
        @endif
    </div>
  </div>

  <div class="container border rounded shadow" style="width:70%;">
    <div class="row justify-content-between align-items-center p-3">
      <div class="col-lg-4 col-md-6 col-sm-12 my-2">
          <label for="name" class="text-dark h6">Name</label>
          <input  class="form-control" type="text" name="name" id="name" value="{{ $user->name }}" disabled>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12 my-2">
        <label for="username" class="text-dark h6">Username</label>
        <input  class="form-control" type="text" name="username" id="username" value="{{ $user->username }}" disabled>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12 my-2">
          <label for="department" class="text-dark h6">Program Studi</label> <br>
          <input class="form-control" type="text" name="department" id="department" value="{{ $user->department->name }}" disabled>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12 my-2">
        <label for="role" class="text-dark h6">Role Akun</label> <br>
        <input class="form-control" type="text" name="role" id="role" value="{{ $user->role }}" disabled>
      </div>
      <div class="col-lg-12 col-md-12 col-sm-12 my-3 d-flex justify-content-between">
        <a href="/admin"  class="btn btn-success wow fadeInRight" ata-wow-delay="0.3s"><i class="bi bi-chevron-double-left"></i> Kembali</a>
        <a href="/admin/user/{{ $user->id }}/edit" class="btn btn-success mx-1 wow fadeInRight"><i class="bi bi-pencil"></i> Edit</a>
      </div>
    </div>
  </div>
</section>

<script>
setTimeout(function() {
  $('.alert').fadeTo(500, 0).slideUp(500, function(){
      $(this).remove(); 
  });
}, 5000);
</script>
@endsection
