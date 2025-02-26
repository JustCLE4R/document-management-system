@extends('layouts.main')

@section('content')
<section class="section-padding" style="margin-top: 9vh ;">
  <div class="section-header text-center">
    <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Akun Baru</h2>
    <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
  </div>
  <div class="container border rounded shadow" style="width:70%;">
    <form action="/superadmin/user" id="form" method="POST" enctype="multipart/form-data">
      <div class="row justify-content-between align-items-center p-3">
        @csrf
        <div class="col-lg-4 col-md-6 col-sm-12 my-2">
            <label for="name" class="text-dark h6">Nama</label>
            <input  class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name') }}" required>
            @if ($errors->has('name'))
              <p class="error text-danger">{{ $errors->first('name') }}</p>
            @endif
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 my-2">
          <label for="username" class="text-dark h6">Username</label>
          <input  class="form-control @error('username') is-invalid @enderror" type="text" name="username" id="username" value="{{ old('username') }}" required>
          @if ($errors->has('username'))
            <p class="error text-danger">{{ $errors->first('username') }}</p>
          @endif
      </div>
        <div class="col-lg-4 col-md-6 col-sm-12 my-2">
            <label for="department" class="text-dark h6">Departemen</label> <br>
            <select class="form-control @error('department') is-invalid @enderror" name="department" id="department" required>
              <option value="" selected>Pilih Departemen</option>
              @foreach ($departments as $department)
              <option value="{{ $department->id }}" {{ request()->input('department') == $department->id ? 'selected' : '' }}>
                {{ $department->type == 'faculty' ? '===' . $department->name . '===' : $department->name }}
              </option>
              @endforeach
            </select>
            @if ($errors->has('department'))
              <p class="error text-danger">{{ $errors->first('department') }}</p>
            @endif
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 my-2">
          <label for="role" class="text-dark h6">Role Akun</label> <br>
          <select class="form-control @error('role') is-invalid @enderror" name="role" id="role" required>
            <option value="" selected>Pilih Role Akun</option>
            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
          </select>
          @if ($errors->has('role'))
            <p class="error text-danger">{{ $errors->first('role') }}</p>
          @endif
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 my-2">
          <label for="password" class="text-dark h6">Password</label> <br>
          <div class="input-group">
            <input  class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" value="{{ old('password') }}" required>
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="button" id="password-toggle"><i class="bi bi-eye" id="password-icon"></i></button>
            </div>
          </div>
          @if ($errors->has('password'))
            <p class="error text-danger">{{ $errors->first('password') }}</p>
          @endif
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 my-2">
          <label for="password_confirmation" class="text-dark h6">Ulangi Password</label> <br>
          <div class="input-group">
            <input  class="form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" id="password_confirmation" value="{{ old('password_confirmation') }}" required>
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="button" id="password-confirmation-toggle"><i class="bi bi-eye" id="password-confirmation-icon"></i></button>
            </div>
          </div>
          @if ($errors->has('password_confirmation'))
            <p class="error text-danger">{{ $errors->first('password_confirmation') }}</p>
          @endif
        </div>
      <script>
        
      </script>
        <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-between">
          <a href="/superadmin/user"  class="btn btn-success wow fadeInRight" ata-wow-delay="0.3s"><i class="bi bi-chevron-double-left"></i> Kembali</a>
          <button class="btn btn-success mx-1 wow fadeInRight" type="submit"><i class="bi bi-check-lg"></i> Submit</button>
        </div>
      </div>
    </form>

  </div>
  <script>
    const passwordInput = document.getElementById('password')
    const passwordToggle = document.getElementById('password-toggle')
    const passwordIcon = document.getElementById('password-icon')

    const passwordConfirmationInput = document.getElementById('password_confirmation')
    const passwordConfirmationToggle = document.getElementById('password-confirmation-toggle')
    const passwordConfirmationIcon = document.getElementById('password-confirmation-icon')

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
  </script>
</section>
@endsection