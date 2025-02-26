@extends('layouts.main')

@section('content')
<section class="section-padding" style="margin-top: 9vh ;">
  <div class="section-header text-center">
    <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Departemen Baru</h2>
    <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
  </div>
  <div class="container border rounded shadow" style="width:70%;">
    
    <form action="/superadmin/department" id="form" method="POST" enctype="multipart/form-data">
      <div class="row justify-content-between align-items-center p-3">
        @csrf
        <div class="col-lg-6 col-md-6 col-sm-12 my-2">
            <label for="name" class="text-dark h6">Nama Departemen</label>
            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name') }}" required>
            @if ($errors->has('name'))
              <p class="error text-danger">{{ $errors->first('name') }}</p>
            @endif
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 my-2">
            <label for="type" class="text-dark h6">Type</label>
            <select class="form-control @error('type') is-invalid @enderror" name="type" id="type" required>
                <option value="">Select Type</option>
                <option value="faculty" {{ old('type') == 'faculty' ? 'selected' : '' }}>Faculty</option>
                <option value="program" {{ old('type') == 'program' ? 'selected' : '' }}>Program</option>
            </select>
            @if ($errors->has('type'))
              <p class="error text-danger">{{ $errors->first('type') }}</p>
            @endif
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 my-2">
            <label for="parent_id" class="text-dark h6">Parent Faculty</label>
            <select class="form-control @error('parent_id') is-invalid @enderror" name="parent_id" id="parent_id" disabled>
                <option value="">Select Parent Faculty</option>
                @foreach($faculties as $faculty)
                    <option value="{{ $faculty->id }}" {{ old('parent_id') == $faculty->id ? 'selected' : '' }}>{{ $faculty->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('parent_id'))
              <p class="error text-danger">{{ $errors->first('parent_id') }}</p>
            @endif
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-between">
          <a href="/superadmin/department" class="btn btn-success wow fadeInRight" data-wow-delay="0.3s"><i class="bi bi-chevron-double-left"></i> Kembali</a>
          <button class="btn btn-success mx-1 wow fadeInRight" type="submit"><i class="bi bi-check-lg"></i> Submit</button>
        </div>
      </div>
    </form>

  </div>
</section>

@push('scripts')
<script>
  document.getElementById('type').addEventListener('change', function() {
      var parentSelect = document.getElementById('parent_id');
      if (this.value === 'program') {
          parentSelect.disabled = false;
      } else {
          parentSelect.disabled = true;
          parentSelect.value = '';
      }
  });
  </script>
@endpush

@endsection