@extends('layouts.main')

@section('content')

<section class="section-padding" style="margin-top: 9vh;">
  <div class="section-header text-center">
    <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Kategori</h2>
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

  <div class="container border rounded shadow p-4" style="width:90%;">
    <div class="row justify-content-between pb-4">
      <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
        <a href="/admin"  class="btn btn-success wow fadeInRight" data-wow-delay="0.3s"><i class="bi bi-chevron-double-left"></i> Kembali</a>
        <a href="/admin/kategori/create" class="btn btn-success wow fadeInRight" data-wow-delay="0.3s"><i class="bi bi-plus-lg"></i> Tambah</a>
      </div>
      <div class="col-lg-4 col-md-8 col-sm-12">
        <form class="wow fadeInRight" data-wow-delay="0.3s" action="/admin/kategori" method="get">
          <div class="input-group">
            <input class="form-control shadow" type="search" placeholder="Cari Kategori" aria-label="Search" name="search" value="{{ request('search') }}">
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" id="button-addon2"><i class="bi bi-search"></i></button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="col-12" style="overflow-x: auto">
      <table class="table table-hover">
        <tr>
          <th class="text-center">No</th>
          <th>Nama</th>
          <th>Deskripsi</th>
          <th class="text-center">Ikon</th>
          <th class="text-center">Gambar</th>
          <th class="text-center">Aksi</th>
        </tr>
        @foreach ($kategoris as $key => $kategori)
          <tr>
            <td class="text-center">{{ $key + 1 }}</td>
            <td>{{ $kategori->name }}</td>
            <td>{{ $kategori->description }}</td>
            <td class="text-center">
              <i class="bi bi-{{ $kategori->icon }}"></i>
              {{ $kategori->icon }}
            </td>
            <td class="text-center">
                <a class="text-success" href="{{ asset('storage/' . $kategori->image) }}" target="_blank">{{ pathinfo($kategori->image, PATHINFO_EXTENSION) }}</a>
            </td>
            <td class="text-center">
                @if ($kategori->user_id == auth()->user()->id || $kategori->department_id == auth()->user()->department_id)
                <a class="text-primary" href="/admin/kategori/{{ $kategori->id }}/edit"><i class="bi bi-pencil-square"></i></a>
                <button type="button" class="text-danger" style="background:none; border:none; padding:0;" data-toggle="modal" data-target="#deleteModal-{{ $kategori->id }}"><i class="bi bi-trash"></i></button>
                <div class="modal fade" id="deleteModal-{{ $kategori->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel-{{ $kategori->id }}" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title text-dark" id="deleteModalLabel-{{ $kategori->id }}">Konfirmasi Hapus Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body d-flex justify-content-start text-dark">
                    Apakah anda yakin ingin menghapus Kategori&nbsp;<b>{{ $kategori->name }}</b>&nbsp;ini?
                    </div>
                    <div class="modal-footer">
                    <form class="d-inline" action="/admin/kategori/{{ $kategori->id }}" method="post">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Hapus</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                  </div>
                  </div>
                </div>
                @else
                <i class="bi bi-pencil-square" style="font-size: 14px;"></i><i class="bi bi-trash" style="font-size: 14px;"></i>
                @endif
            </td>
          </tr>
        @endforeach
      </table>
    </div>

    <div id="pagenation">
      {{ $kategoris->onEachSide(1)->links() }}
    </div>
  </div>
  <!-- Modal -->
</section>

<script>
  document.querySelector('form').addEventListener('submit', function(event) {
    const inputs = this.querySelectorAll('select, input[name="result"]');
    inputs.forEach(input => {
      if (!input.value.trim()) {
        input.disabled = true;
      }
    });
  });
</script>
@endsection