@extends('layout.admin')
@section('navbar-sidebar')
    @include('component._navbar')
    @include('component._sidebar')
@endsection
@section('content')
    @if (session('success'))
        <div class="alert alert-success pb-0" role="alert">
            <h4 class="alert-heading">Berhasil !</h4>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-lg-end mb-3">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createUser">
                    Tambah User
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="my_table">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-nowrap" style="width:50px">No</th>
                            <th class="text-nowrap">username</th>
                            <th class="text-nowrap">nik</th>
                            <th class="text-nowrap">fullname</th>
                            <th class="text-nowrap">email</th>
                            <th class="text-nowrap">no hp</th>
                            <th class="text-nowrap">role</th>
                            <th class="text-nowrap" style="width: 100px">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $item)
                            <tr>
                                <td class="text-nowrap">{{ $loop->iteration }}</td>
                                <td class="text-nowrap">{{ $item->username }}</td>
                                <td class="text-nowrap">{{ $item->nik }}</td>
                                <td class="text-nowrap">{{ $item->fullname }}</td>
                                <td class="text-nowrap">{{ $item->email }}</td>
                                <td class="text-nowrap">{{ $item->no_hp }}</td>
                                <td class="text-nowrap">{{ $item->role }}</td>
                                <td class="text-nowrap">
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-warning" data-toggle="modal"
                                            data-target="#editUser">
                                            Edit
                                        </button>
                                        <form action="{{ route('user.destroy', $item->id) }}" method="post"
                                            id="delete_form{{ $item->id }}">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-danger"
                                                onclick="delete_item('delete_form{{ $item->id }}')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <div class="modal fade" id="editUser" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('user.update', $item->id) }}" method="post">
                                            @csrf
                                            @method('put')
                                            <div class="card">
                                                <div class="card-body">
                                    
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="mb-3">
                                                                    <label for="nik" class="form-label">nik <span class="text-danger">*</span></label>
                                                                    <input type="number" class="form-control @error('nik') is-invalid @enderror" name="nik"
                                                                        id="nik" placeholder="Masukkan nik"
                                                                        value="{{ old('nik') ? old('nik') : $item->nik }}">
                                                                    @error('nik')
                                                                        <span class="text-danger d-block">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                    
                                                            <div class="col">
                                                                <div class="mb-3">
                                                                    <label for="fullname" class="form-label">fullname <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control @error('fullname') is-invalid @enderror"
                                                                        name="fullname" id="fullname" placeholder="Masukkan fullname"
                                                                        value="{{ old('fullname') ? old('fullname') : $item->fullname }}">
                                                                    @error('fullname')
                                                                        <span class="text-danger d-block">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                    
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="mb-3">
                                                                    <label for="email" class="form-label">email <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                                                        name="email" id="email" placeholder="Masukkan email"
                                                                        value="{{ old('email') ? old('email') : $item->email }}">
                                                                    @error('email')
                                                                        <span class="text-danger d-block">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                    
                                                            <div class="col">
                                                                <div class="mb-3">
                                                                    <label for="no_hp" class="form-label">no hp <span class="text-danger">*</span></label>
                                                                    <input type="number" class="form-control @error('no_hp') is-invalid @enderror"
                                                                        name="no_hp" id="no_hp" placeholder="Masukkan no hp"
                                                                        value="{{ old('no_hp') ? old('no_hp') : $item->no_hp }}">
                                                                    @error('no_hp')
                                                                        <span class="text-danger d-block">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                    
                                                    <div class="d-flex justify-content-end">
                                                        <button class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal Create -->
    <div class="modal fade" id="createUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('user.store') }}" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="nik" class="form-label">nik <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('nik') is-invalid @enderror"
                                                name="nik" id="nik" placeholder="Masukkan nik"
                                                value="{{ old('nik') }}">
                                            @error('nik')
                                                <span class="text-danger d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="fullname" class="form-label">fullname <span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('fullname') is-invalid @enderror"
                                                name="fullname" id="fullname" placeholder="Masukkan fullname"
                                                value="{{ old('fullname') }}">
                                            @error('fullname')
                                                <span class="text-danger d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">email <span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                id="email" placeholder="Masukkan email" value="{{ old('email') }}">
                                            @error('email')
                                                <span class="text-danger d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="no_hp" class="form-label">no hp <span
                                                    class="text-danger">*</span></label>
                                            <input type="number"
                                                class="form-control @error('no_hp') is-invalid @enderror" name="no_hp"
                                                id="no_hp" placeholder="Masukkan no hp" value="{{ old('no_hp') }}">
                                            @error('no_hp')
                                                <span class="text-danger d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function delete_item(form) {
            let cf = confirm('Yakin Menghapus Data ?')
            if (cf) {
                document.getElementById(form).submit();
            }
        }
    </script>
@endsection
