@extends('layouts.main')

@section('content')

    <section class="section-padding" style="margin-top: 9vh;">

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
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>

        {{-- print all errors --}}
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

        <div class="section-header text-center">
            <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">System Settings</h2>
            <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
        </div>
        <div class="container border rounded shadow p-3" style="width:70%;">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                    <a href="/superadmin" class="btn btn-success wow fadeInRight" data-wow-delay="0.3s"><i
                            class="bi bi-chevron-double-left"></i> Kembali</a>
                </div>
                <form action="{{ route('superadmin.setting.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row justify-content-between align-items-center p-3">
                        <div class="col-lg-6 col-md-6 col-sm-12 my-2">
                            <label class="form-label text-dark h6">App Name</label>
                            <input type="text" name="app_name"
                                class="form-control @error('app_name') is-invalid @enderror"
                                value="{{ old('app_name', $settings->app_name) }}">
                            @error('app_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 my-2">
                            <label class="form-label text-dark h6">App Alias</label>
                            <input type="text" name="app_alias"
                                class="form-control @error('app_alias') is-invalid @enderror"
                                value="{{ old('app_alias', $settings->app_alias) }}">
                            @error('app_alias')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 my-2">
                            <label class="form-label text-dark h6">App Description</label>
                            <textarea name="app_description" class="form-control @error('app_description') is-invalid @enderror" rows="4">{{ old('app_description', $settings->app_description) }}</textarea>
                            @error('app_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 my-2">
                            <label class="form-label text-dark h6">Primary Color</label>
                            <input type="color" name="color_primary"
                                class="form-control @error('color_primary') is-invalid @enderror"
                                value="{{ old('color_primary', $settings->color_primary) }}" style="height: 3rem;">
                            @error('color_primary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 my-2">
                            <label class="form-label text-dark h6">Secondary Color</label>
                            <input type="color" name="color_secondary"
                                class="form-control @error('color_secondary') is-invalid @enderror"
                                value="{{ old('color_secondary', $settings->color_secondary) }}" style="height: 3rem;">
                            @error('color_secondary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 my-2">
                            <label class="form-label text-dark h6">Tertiary Color</label>
                            <input type="color" name="color_tertiary"
                                class="form-control @error('color_tertiary') is-invalid @enderror"
                                value="{{ old('color_tertiary', $settings->color_tertiary) }}" style="height: 3rem;">
                            @error('color_tertiary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-between">
                            <button class="btn btn-success mx-1 wow fadeInRight" type="submit"><i
                                    class="bi bi-check-lg"></i> Save Settings</button>
                        </div>
                    </div>
                </form>
            </div>
    </section>
@endsection
