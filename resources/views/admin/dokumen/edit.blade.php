@extends('layouts.main')

@section('content')
<section class="section-padding" style="margin-top: 9vh ;">
  <div class="section-header text-center">
    <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Edit Dokumen</h2>
    <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
  </div>
  @if ($errors->any())
    <div class="alert alert-danger">
      <strong>Whoops!</strong> There were some problems with your input.<br><br>
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <div class="container border rounded shadow" style="width:70%;">
    <form action="/admin/dokumen/{{ $dokumen->id }}" method="POST" id="form" enctype="multipart/form-data">
      @method('PUT')
      <div class="row justify-content-between align-items-center p-3">
        @csrf
        <div class="col-lg-4 col-md-6 col-sm-12 my-2">
            <label for="name" class="text-dark h6">Nama</label>
            <input  class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name', $dokumen->name) }}" required>
            @if ($errors->has('name'))
              <p class="error text-danger">{{ $errors->first('name') }}</p>
            @endif
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 my-2">
            <label for="kriteria_id"  class="text-dark h6" >Kriteria</label> <br>
            <select class="form-control @error('kriteria_id') is-invalid @enderror" name="kriteria_id" id="kriteria_id" required>
              <option value="" hidden>Pilih Kriteria</option>
          @foreach ($kriterias as $kriteria)
          <option value="{{ $kriteria->id }}" {{ old('kriteria_id', $dokumen->kriteria_id) == $kriteria->id ? 'selected' : '' }}>{{ $kriteria->name }}</option>
              @endforeach
            </select>
            @if ($errors->has('kriteria_id'))
              <p class="error text-danger">{{ $errors->first('kriteria_id') }}</p>
            @endif
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 my-2">
            <label for="sub_kriteria" class="text-dark h6">Sub Kriteria</label>
            <input class="form-control @error('sub_kriteria') is-invalid @enderror" type="text" name="sub_kriteria" id="sub_kriteria" value="{{ old('sub_kriteria', $dokumen->sub_kriteria) }}">
            @if ($errors->has('sub_kriteria'))
              <p class="error text-danger">{{ $errors->first('sub_kriteria') }}</p>
            @endif
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 my-2"></div>
        <div class="col-lg-4 col-md-6 col-sm-12 my-2">
            <label class="text-dark h6" for="tipe">Tipe Dokumen</label><br>
            <select class="form-control" name="tipe" id="tipe">
              <option value="file" {{ old('tipe', $dokumen->tipe) != 'URL' && $dokumen->status != 'borrow' ? 'selected' : '' }}>File</option>
              <option value="url" {{ old('tipe', $dokumen->tipe) == 'URL' && $dokumen->status != 'borrow' ? 'selected' : '' }}>URL</option>
              <option value="shareable" {{ old('tipe', $dokumen->tipe) == 'shareable' || $dokumen->status == 'borrow' ? 'selected' : '' }}>Shareable</option>
            </select>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 my-2"></div>
        <div class="col-lg-4 col-md-6 col-sm-12 my-2">
          <div class="mb-3">
            <label  class="text-dark h6" for="file">File</label>
            <input class="form @error('file') is-invalid @enderror" type="file" name="file" id="file" disabled>
          </div>                     
          @if ($errors->has('file'))
            <p class="error text-danger">{{ $errors->first('file') }}</p>
          @endif
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 my-2">
          <label class="text-dark h6" for="url">URL</label>
            <input class="form-control @error('url') is-invalid @enderror" type="text" name="url" id="url" value="{{ $dokumen->tipe == 'URL' ? old('url', $dokumen->path) : '' }}" disabled>
          @if ($errors->has('url'))
            <p class="error text-danger">{{ $errors->first('url') }}</p>
          @endif
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 my-2">
          <label class="text-dark h6" for="shareable">Berbagi File</label>
          <select class="form-control" name="shareable" id="shareable" disabled>
            <option value="" hidden></option>
            @foreach ($shareables as $shareable)
              <option value="{{ $shareable->id }}" path="{{ $shareable->path }}" {{ old('shareable', $dokumen->borrow_from) == $shareable->id ? 'selected' : '' }}>{{ $shareable->name }}</option>
            @endforeach
          </select>
          @if ($errors->has('shareable'))
            <p class="error text-danger">{{ $errors->first('shareable') }}</p>
          @endif
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
          <label for="preview" class="text-dark h6">Preview</label>
          <div id="preview" class="border rounded p-2">
            @if ($dokumen->tipe != 'URL')
              <embed src="{{ url('storage/'.$dokumen->path) }}" style="width: 100%; height: auto">
            @else
              <a href="{{ $dokumen->tipe == 'URL' ? $dokumen->path : url('storage/'.$dokumen->path) }}">{{ $dokumen->tipe == 'URL' ? $dokumen->path : basename($dokumen->path) }}</a>
            @endif
          </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 my-2">
          <label for="catatan" class="text-dark h6 @error('catatan') is-invalid @enderror">Catatan</label>
          <textarea class="form-control" name="catatan" id="catatan" placeholder="Tambahkan Catatan Disini.." id="floatingTextarea">{{ old('catatan') }}</textarea>
          @if ($errors->has('catatan'))
            <p class="error text-danger">{{ $errors->first('catatan') }}</p>
          @endif
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-between mb-4">
          <a href="/admin/dokumen"  class="btn btn-success wow fadeInRight" ata-wow-delay="0.3s"><i class="bi bi-chevron-double-left"></i> Kembali</a>
          <button class="btn btn-success mx-1 wow fadeInRight" type="submit"><i class="bi bi-check-lg"></i> Submit</button>
        </div>
      </div>
    </form>

  </div>
  <script>
    const setValue = (value) => {
      const fileInput = document.getElementById('file');
      const urlInput = document.getElementById('url');
      const shareableInput = document.getElementById('shareable');
      const fileExists = "{{ $dokumen->path }}";
      
      fileInput.required = value === 'file' && !fileExists;
      urlInput.required = value === 'url';
      shareableInput.required = value === 'shareable';
      fileInput.disabled = value !== 'file';
      urlInput.disabled = value !== 'url';
      shareableInput.disabled = value !== 'shareable';
    };

    document.addEventListener('DOMContentLoaded', () => {
      const selectTipe = document.getElementById('tipe');
      setValue(selectTipe.value);
    });

    document.getElementById('tipe').addEventListener('change', function() {
      const value = this.value;
      document.getElementById('preview').innerHTML = '';
      document.getElementById('file').value = '';
      document.getElementById('url').value = '';
      document.getElementById('shareable').selectedIndex = 0;
      setValue(value);
    });

    document.getElementById('file').addEventListener('change', function() {
      const file = this.files[0];
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('preview').innerHTML = `<embed src="${e.target.result}"  style="width: 100%; height: auto">`;
      };
      reader.readAsDataURL(file);
    });

    document.getElementById('shareable').addEventListener('change', function() {
      const selectedOption = this.options[this.selectedIndex];
      const path = selectedOption.getAttribute('path');

      if (path) {
      document.getElementById('preview').innerHTML = `<embed src="{{ url('storage/${path}') }}" style="width: 100%; height: auto">`;
      } else {
      document.getElementById('preview').innerHTML = '';
      }
    });
  </script>
</section>
@endsection