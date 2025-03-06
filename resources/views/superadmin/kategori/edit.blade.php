@extends('layouts.main')

@section('content')
<section class="section-padding" style="margin-top: 9vh ;">
    <div class="section-header text-center">
        <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Edit Kategori</h2>
        <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
    </div>
    <div class="container border rounded shadow" style="width:70%;">
        <form action="/superadmin/kategori/{{ $kategori->id }}" id="form" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row justify-content-between align-items-center p-3">
                <div class="col-lg-4 col-md-6 col-sm-12 my-2">
                    <label for="name" class="text-dark h6">Nama Kategori</label>
                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name"
                        value="{{ old('name', $kategori->name) }}" required>
                    @if ($errors->has('name'))
                    <p class="error text-danger">{{ $errors->first('name') }}</p>
                    @endif
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 my-2">
                    <label for="description" class="text-dark h6">Deskripsi</label>
                    <input class="form-control @error('description') is-invalid @enderror" type="text"
                        name="description" id="description" value="{{ old('description', $kategori->description) }}">
                    @if ($errors->has('description'))
                    <p class="error text-danger">{{ $errors->first('description') }}</p>
                    @endif
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 my-2"></div>
                {{-- <div class="col-lg-4 col-md-6 col-sm-12 my-2">
                    <label for="department_id" class="text-dark h6">Fakultas atau Program Studi</label> <br>
                    <select class="form-control @error('department_id') is-invalid @enderror" name="department_id"
                        id="department_id">
                        <option value="" selected>Pilih Fakultas atau Program Studi</option>
                        @foreach ($departments as $department)
                        <option value="{{ $department->id }}" {{ old('department_id', $kategori->department_id) == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('department_id'))
                    <p class="error text-danger">{{ $errors->first('department_id') }}</p>
                    @endif
                </div> --}}
                <div class="col-lg-4 col-md-6 col-sm-12 my-2">
                    <label for="icon" class="text-dark h6">Ikon</label>
                    <div class="input-group">
                        <select class="form-control @error('icon') is-invalid @enderror" name="icon" id="icon">
                            <option value="" selected>Pilih Ikon</option>
                            @foreach (json_decode(file_get_contents(public_path('json/bootstrap-icons.json')), true)['icons'] as $icon)
                            <option value="{{ $icon }}" {{ old('icon', $kategori->icon) == $icon ? 'selected' : '' }}>{{ $icon }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i id="icon-preview" class="bi bi-{{ old('icon', $kategori->icon) }}"></i>
                            </span>
                        </div>
                    </div>
                    @if ($errors->has('icon'))
                    <p class="error text-danger">{{ $errors->first('icon') }}</p>
                    @endif
                    @push('scripts')
                    <script>
                        document.getElementById('icon').addEventListener('change', function() {
                            var icon = this.value;
                            var iconPreview = document.getElementById('icon-preview');
                            iconPreview.className = 'bi bi-' + icon;
                        });
                    </script>
                    @endpush
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 my-2">
                    <img id="image-preview" src="{{ $kategori->image ? asset('storage/' . $kategori->image) : '#' }}" alt="Image Preview"
                        style="display: {{ $kategori->image ? 'block' : 'none' }}; max-width: 100%; height: auto; margin-top: 10px;">
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 my-2">
                    <label for="image" class="text-dark h6">Gambar</label>
                    <div class="input-group">
                        <input class="form-control @error('image') is-invalid @enderror" type="file" name="image"
                            id="image" accept="image/*">
                        <div class="input-group-append">
                            <span class="input-group-text" data-toggle="tooltip" data-placement="right"
                                title="Gambar terbaik dengan rasio 2:1">
                                <i class="bi bi-info-circle"></i>
                            </span>
                        </div>
                    </div>
                    @push('scripts')
                    <script>
                        document.getElementById('image').addEventListener('change', function(event) {
                            var reader = new FileReader();
                            reader.onload = function(){
                                var output = document.getElementById('image-preview');
                                output.src = reader.result;
                                output.style.display = 'block';
                            };
                            reader.readAsDataURL(event.target.files[0]);
                        });
                        $(function () {
                            $('[data-toggle="tooltip"]').tooltip()
                        });
                    </script>
                    @endpush
                    @if ($errors->has('image'))
                    <p class="error text-danger">{{ $errors->first('image') }}</p>
                    @endif
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-between">
                    <a href="/superadmin/kategori" class="btn btn-success wow fadeInRight" data-wow-delay="0.3s"><i
                            class="bi bi-chevron-double-left"></i> Kembali</a>
                    <button class="btn btn-success mx-1 wow fadeInRight" type="submit"><i class="bi bi-check-lg"></i>
                        Update</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
