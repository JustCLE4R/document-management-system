@extends('layouts.main')

@section('content')

<section class="section-padding" style="margin-top: 3rem;">
  <div class="section-header text-center">
    <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Departemen</h2>
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
      <div class="col-lg-4 col-md-6 col-sm-12 mb-2 mb-md-0">
        <a href="/superadmin"  class="btn btn-success wow fadeInRight" ata-wow-delay="0.3s"><i class="bi bi-chevron-double-left"></i> Kembali</a>
        <a href="/superadmin/department/create" class="btn btn-success wow fadeInRight" ata-wow-delay="0.3s"><i class="bi bi-plus-lg"></i> Tambah</a>
      </div>
      <div class="col-lg-5 col-md-8 col-sm-12">
        <form class="wow fadeInRight" data-wow-delay="0.3s" action="/superadmin/department" method="get">
          <div class="input-group">
            <input type="text" class="form-control shadow" name="result" placeholder="Cari Departemen..." aria-describedby="button-addon2" value="{{ old('result', request()->input('result')) }}">
            <div class="input-group-append">
              <button class="btn btn-search" id="button-addon2"><i class="bi bi-search"></i></button>
            </div>
          </div>
        </form>
      </div>
    </div>

    @push('scripts')
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
    @endpush
    
    <div class="col-12" style="overflow-x: auto">
      <table class="table table-hover">
        <tr>
          <th class="text-center">No</th>
          <th>Nama</th>
          <th class="text-center">Type</th>
          <th>Parent</th>
          <th class="text-center">Aksi</th>
        </tr>
        @foreach ($departments as $department)
          <tr>
            <td class="text-center">{{ $departments->firstItem() + $loop->index }}</td>
            <td>{{ $department->name }}</td>
            <td class="text-center">{{ $department->type }}</td>
            <td>{{ $department->parent ? $department->parent->name : '-' }}</td>
            <td class="text-center">
              <a class="text-primary" href="{{ route('department.edit', $department->id) }}"><i class="bi bi-pencil-square"></i></a>
              <button type="button" class="text-danger" style="background:none; border:none; padding:0;" data-toggle="modal" data-target="#deleteModal-{{ $department->id }}"><i class="bi bi-trash"></i></button>
              <div class="modal fade" id="deleteModal-{{ $department->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel-{{ $department->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered  " role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title text-dark" id="deleteModalLabel-{{ $department->id }}">Konfirmasi Hapus Program Studi</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body d-flex justify-content-start text-dark">
                      Apakah anda yakin ingin menghapus Program Studi "{{ $department->name }}"?
                    </div>
                    <div class="modal-footer">
                      <form class="d-inline" action="/superadmin/department/{{ $department->id }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Hapus</button>
                      </form>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        @endforeach
      </table>
    </div>
    <div id="pagenation">
      {{ $departments->onEachSide(1)->links() }}
    </div>
  </div>
  <!-- Modal -->


</section>
@endsection