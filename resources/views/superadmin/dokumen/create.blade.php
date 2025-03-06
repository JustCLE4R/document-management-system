@extends('layouts.main')

@section('content')
<section class="section-padding" style="margin-top: 9vh ;">
  <div class="section-header text-center">
    <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Dokumen Baru</h2>
    <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
  </div>
  <div class="container border rounded shadow" style="width:70%;">
    
    <form action="/superadmin/dokumen" id="form" method="POST" enctype="multipart/form-data">
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
            <label for="kategori"  class="text-dark h6" >Kategori</label> <br>
            <select class="form-control @error('kategori') is-invalid @enderror" name="kategori" id="kategori" required>
              <option hidden disabled selected>Pilih Kategori</option>
              @foreach ($kategoris as $kategori)
                <option value="{{ $kategori->id }}" {{ request()->input('kategori') == $kategori->id ? 'selected' : '' }}>{{ $kategori->name }}</option>
              @endforeach
            </select>
            @if ($errors->has('kategori'))
              <p class="error text-danger">{{ $errors->first('kategori') }}</p>
            @endif
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 my-2">
            <label for="sub_kategori" class="text-dark h6">Sub Kategori</label>
            <input class="form-control @error('sub_kategori') is-invalid @enderror" type="text" name="sub_kategori" id="sub_kategori" value="{{ old('sub_kategori') }}">
            @if ($errors->has('sub_kategori'))
              <p class="error text-danger">{{ $errors->first('sub_kategori') }}</p>
            @endif
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 my-2">
          <label for="Departments" class="text-dark h6" >Departemen</label>
          <select class="form-control @error('Departments') is-invalid @enderror" name="Departments" id="Departments" required>
            <option hidden disabled selected>Pilih Departemen</option>
            @foreach ($users as $user)
              <option value="{{ $user->id }}" {{ old('Departments') == $user->id ? 'selected' : '' }}>{{ $user->department->name }}</option>
            @endforeach
          </select>
          @if ($errors->has('Departments'))
            <p class="error text-danger">{{ $errors->first('Departments') }}</p>
          @endif
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 my-2">
          <label for="status" class="text-dark h6">Berbagi file?</label>
          <select class="form-control" name="status" id="status">
            <option value="private" {{ old('status') == 'private' ? 'selected' : '' }}>Tidak</option>
            <option value="share" {{ old('status') == 'share' ? 'selected' : '' }}>Iya</option>
          </select>
          @if ($errors->has('status'))
            <p class="error text-danger">{{ $errors->first('status') }}</p>
          @endif
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12"></div>
        <div class="col-lg-4 col-md-6 col-sm-12 my-2">
            <label class=" text-dark h6" for="tipe">Tipe Dokumen</label><br>
            <select class="form-control" name="tipe" id="tipe">
              <option value="file" {{ old('tipe') != 'URL' ? 'selected' : '' }}>File</option>
              <option value="url" {{ old('tipe') == 'URL' ? 'selected' : '' }}>URL</option>
            </select>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 my-2">
          <div class="mb-3">
            <label class=" text-dark h6" for="file">File</label>
            <input class="form @error('file') is-invalid @enderror" type="file" name="file" id="file" required>
          </div>                     
          @if ($errors->has('file'))
            <p class="error text-danger">{{ $errors->first('file') }}</p>
          @endif
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 my-2">
          <label class=" text-dark h6" for="url">URL</label>
          <input class="form-control @error('url') is-invalid @enderror" type="text" name="url" id="url" value="{{ old('url') }}" disabled>
          @if ($errors->has('url'))
            <p class="error text-danger">{{ $errors->first('url') }}</p>
          @endif
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
          <label for="preview" class="text-dark h6">Preview</label>
          <div id="preview" class="border rounded p-2"></div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 my-2">
          <label for="catatan" class=" text-dark h6 @error('catatan') is-invalid @enderror">Catatan</label>
          <textarea class="form-control" name="catatan" id="catatan" placeholder="Tambahkan Catatan Disini.." id="floatingTextarea">{{ old('catatan') }}</textarea>
          @if ($errors->has('catatan'))
            <p class="error text-danger">{{ $errors->first('catatan') }}</p>
          @endif
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-between">
          <a href="/superadmin/dokumen"  class="btn btn-success wow fadeInRight" ata-wow-delay="0.3s"><i class="bi bi-chevron-double-left"></i> Kembali</a>
          <button class="btn btn-success mx-1 wow fadeInRight" type="submit"><i class="bi bi-check-lg"></i> Submit</button>
        </div>
      </div>
    </form>

  </div>
  <script>
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

      document.getElementById('preview').innerHTML = '';
      document.getElementById('file').value = '';
      document.getElementById('url').value = '';
    });

    document.getElementById('status').addEventListener('change', function() {
      const value = this.value;
      const Departments = document.getElementById('Departments');
      if (value == 'share') {
        for (let i = 0; i < Departments.options.length; i++) {
          if (i !== 1) {
            Departments.options[i].disabled = true;
          }
        }
        Departments.selectedIndex = 1;
        Departments.required = false;
      } else {
        for (let i = 0; i < Departments.options.length; i++) {
          Departments.options[i].disabled = false;
        }
        Departments.required = true;
      }
    });

    document.getElementById('file').addEventListener('change', function() {
      const file = this.files[0];
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('preview').innerHTML = `<embed src="${e.target.result}"  style="width: 100%; height: auto; min-height:300px;">`;
      };
      reader.readAsDataURL(file);
    });
  </script>
</section>
@endsection