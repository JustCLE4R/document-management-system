@extends('layouts.main')

@section('content')

<section class="section-padding" style="margin-top: 9vh;">
  <div class="section-header text-center">
    <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Akun</h2>
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
        <a href="/superadmin"  class="btn btn-success wow fadeInRight" ata-wow-delay="0.3s"><i class="bi bi-chevron-double-left"></i> Kembali</a>
        <a href="/superadmin/user/create" class="btn btn-success wow fadeInRight" ata-wow-delay="0.3s"><i class="bi bi-plus-lg"></i> Tambah</a>
      </div>
      <div class="col-lg-4 col-md-8 col-sm-12">
        <form class="wow fadeInRight" data-wow-delay="0.3s" action="/superadmin/user" method="get">
          <div class="input-group">
            <select class="custom-select p-1 bg-success text-light shadow" name="department" id="" style="max-width: 200px;;">
              <option value="" selected>Departemen</option>
                @foreach ($departments as $department)
                <option value="{{ $department->id }}" {{ request()->input('department') == $department->id ? 'selected' : '' }}>
                  {{ $department->type == 'faculty' ? '===' . $department->name . '===' : $department->name }}
                </option>
                @endforeach
            </select>
            <select class="custom-select p-1 bg-success text-light shadow" name="role" id="">
              <option value="" selected>Role</option>
              <option value="admin" {{ request()->input('role') == 'admin' ? 'selected' : '' }}>Admin</option>
              <option value="user" {{ request()->input('role') == 'user' ? 'selected' : '' }}>User</option>
            </select>
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
          <th>Name</th>
          <th>Username</th>
          <th>Departemen</th>
          <th class="text-center">Role</th>
          <th class="text-center">Aksi</th>
        </tr>
        @foreach ($users as $user)
          <tr>
            <td class="text-center">{{ $users->firstItem() + $loop->index }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->department->name }}</td>
            <td class="text-center">{{ $user->role }}</td>
            <td class="text-center">
              <a class="text-primary" href="/superadmin/user/{{ $user->id }}/edit"><i class="bi bi-pencil-square"></i></a>
              <button type="button" class="text-danger" style="background:none; border:none; padding:0;" data-toggle="modal" data-target="#deleteModal-{{ $user->id }}"><i class="bi bi-trash"></i></button>
              <div class="modal fade" id="deleteModal-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel-{{ $user->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered  " role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title text-dark" id="deleteModalLabel-{{ $user->id }}">Konfirmasi Hapus Akun</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body d-flex justify-content-start text-dark">
                      Apakah anda yakin ingin menghapus Akun&nbsp;<b>{{ $user->name }}</b>&nbsp;ini?
                    </div>
                    <div class="modal-footer">
                      <form class="d-inline" action="/superadmin/user/{{ $user->id }}" method="post">
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
      {{ $users->onEachSide(1)->links() }}
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