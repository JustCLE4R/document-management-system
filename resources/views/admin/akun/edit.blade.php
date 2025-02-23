@extends('layouts.main')

@section('content')
<section class="section-padding" style="margin-top: 1.8rem;">
  <div class="section-header text-center">
    <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Edit Akun</h2>
    <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
  </div>
  <div class="container border rounded shadow" style="width:70%;">
    <form action="/admin/user/{{ $user->id }}" id="form" method="POST" enctype="multipart/form-data">
      <div class="row justify-content-between align-items-center p-3">
        @csrf
        @method('PUT')
        <div class="col-lg-4 col-md-6 col-sm-12 my-2">
            <label for="name" class="text-dark h6">Nama</label>
            <input  class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
            @if ($errors->has('name'))
              <p class="error text-danger">{{ $errors->first('name') }}</p>
            @endif
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 my-2">
          <label for="username" class="text-dark h6">Username</label>
          <input  class="form-control @error('username') is-invalid @enderror" type="text" name="username" id="username" value="{{ old('username', $user->username) }}" required>
          @if ($errors->has('username'))
            <p class="error text-danger">{{ $errors->first('username') }}</p>
          @endif
      </div>
        <div class="col-lg-4 col-md-6 col-sm-12 my-2">
            <label for="prodi" class="text-dark h6">Program Studi</label> <br>
            <input class="form-control" type="text" name="prodi" id="prodi" value="{{ $user->programStudi->nama }}" disabled>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 my-2">
          <label for="role" class="text-dark h6">Role Akun</label> <br>
          <input class="form-control" type="text" name="role" id="role" value="{{ $user->role }}" disabled>
        </div>
        <div class="col-lg-8 col-md-6 col-sm-12 my-2"></div>
        <div class="col-lg-4 col-md-6 col-sm-12 my-2">
          <label for="old_password" class="text-dark h6">Password Saat Ini</label> <br>
          <div class="input-group">
            <input  class="form-control @error('old_password') is-invalid @enderror" type="password" name="old_password" id="old_password" required>
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="button" id="old-password-toggle"><i class="bi bi-eye" id="old-password-icon"></i></button>
            </div>
          </div>
          @if ($errors->has('old_password'))
            <p class="error text-danger">{{ $errors->first('old_password') }}</p>
          @endif
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 my-2 d-none" id="password-field">
          <label for="password" class="text-dark h6">Password Baru</label> <br>
          <div class="input-group">
            <input  class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password">
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="button" id="password-toggle"><i class="bi bi-eye" id="password-icon"></i></button>
            </div>
          </div>
          @if ($errors->has('password'))
            <p class="error text-danger">{{ $errors->first('password') }}</p>
          @endif
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 my-2 d-none" id="password-confirmation-field">
          <label for="password_confirmation" class="text-dark h6">Konfirmasi Password Baru</label> <br>
          <div class="input-group">
            <input  class="form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" id="password_confirmation">
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="button" id="password-confirmation-toggle"><i class="bi bi-eye" id="password-confirmation-icon"></i></button>
            </div>
          </div>
          @if ($errors->has('password_confirmation'))
            <p class="error text-danger">{{ $errors->first('password_confirmation') }}</p>
          @endif
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 d-flex my-2">
          <button class="btn btn-link p-0 m-0" type="button" id="password-toggle-button" onclick="togglePasswordField()">Ingin Mengganti Password? Klik Disini!</button>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 m-0">
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 my-3 d-flex justify-content-between">
          <a href="/admin/user/{{ $user->id }}"  class="btn btn-success wow fadeInRight" ata-wow-delay="0.3s"><i class="bi bi-chevron-double-left"></i> Kembali</a>
          <button class="btn btn-success mx-1 wow fadeInRight" type="submit"><i class="bi bi-check-lg"></i> Submit</button>
        </div>
      </div>
    </form>
  </div>
</section>
<script>
  const oldPasswordInput = document.getElementById('old_password')
  const oldPasswordToggle = document.getElementById('old-password-toggle')
  const oldPasswordIcon = document.getElementById('old-password-icon')

  const passwordInput = document.getElementById('password')
  const passwordToggle = document.getElementById('password-toggle')
  const passwordIcon = document.getElementById('password-icon')

  const passwordConfirmationInput = document.getElementById('password_confirmation')
  const passwordConfirmationToggle = document.getElementById('password-confirmation-toggle')
  const passwordConfirmationIcon = document.getElementById('password-confirmation-icon')

  oldPasswordToggle.addEventListener('click', function () {
    if (oldPasswordInput.type === 'password') {
      oldPasswordInput.type = 'text'
      oldPasswordIcon.classList.replace('bi-eye', 'bi-eye-slash')
    } else {
      oldPasswordInput.type = 'password'
      oldPasswordIcon.classList.replace('bi-eye-slash', 'bi-eye')
    }
  })

  passwordToggle.addEventListener('click', function () {
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text'
      passwordIcon.classList.replace('bi-eye', 'bi-eye-slash')
    } else {
      passwordInput.type = 'password'
      passwordIcon.classList.replace('bi-eye-slash', 'bi-eye')
    }
  })

  passwordConfirmationToggle.addEventListener('click', function () {
    if (passwordConfirmationInput.type === 'password') {
      passwordConfirmationInput.type = 'text'
      passwordConfirmationIcon.classList.replace('bi-eye', 'bi-eye-slash')
    } else {
      passwordConfirmationInput.type = 'password'
      passwordConfirmationIcon.classList.replace('bi-eye-slash', 'bi-eye')
    }
  })

  document.getElementById('tipe').addEventListener('change', function() {
    const value = this.value;
    const fileInput = document.getElementById('file');
    const urlInput = document.getElementById('url');
    
    if (value == 'file') {
      fileInput.required = true;
      urlInput.required = false;
      fileInput.disabled = false;
      urlInput.disabled = true;
    } else {
      fileInput.required = false;
      urlInput.required = true;
      fileInput.disabled = true;
      urlInput.disabled = false;
    }
  });

  function togglePasswordField() {
    document.getElementById('password-field').classList.toggle('d-none');
    document.getElementById('password-confirmation-field').classList.toggle('d-none');
  }
</script>
@endsection