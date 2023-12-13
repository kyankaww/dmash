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
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createCate">
                    Tambah Category
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="my_table">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-nowrap" style="width:50px">No</th>
                            <th class="text-nowrap">Category</th>
                            <th class="text-nowrap" style="width: 100px">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($category as $item)
                            <tr>
                                <td class="text-nowrap">{{ $loop->iteration }}</td>
                                <td class="text-nowrap">{{ $item->category }}</td>
                                <td class="text-nowrap">
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-warning" data-toggle="modal"
                                            data-target="#editCate">
                                            Edit
                                        </button>
                                        <form action="{{ route('category.destroy', $item->id) }}" method="post"
                                            id="delete_form{{ $item->id }}">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-danger"
                                                onclick="delete_item('delete_form{{ $item->id }}')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <div class="modal fade" id="editCate" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('category.update', $item->id) }}" method="post">
                                            @csrf
                                            @method('put')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Create Category</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row row-cols-1 row-cols-lg-2">

                                                            <div class="col">
                                                                <div class="mb-3">
                                                                    <label for="category" class="form-label">Category <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text"
                                                                        class="form-control @error('category') is-invalid @enderror"
                                                                        name="category" id="category"
                                                                        placeholder="Masukkan Category"
                                                                        value="{{ old('category') ? old('category') : $item->category }}">
                                                                    @error('category')
                                                                        <span
                                                                            class="text-danger d-block">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="d-flex justify-content-end">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button class="btn btn-primary">Simpan</button>
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
    <div class="modal fade" id="createCate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('category.store') }}" method="post">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class="row row-cols-1 row-cols-lg-2">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="category" class="form-label">Category <span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('category') is-invalid @enderror"
                                                name="category" id="category" placeholder="Masukkan Category"
                                                value="{{ old('category') }}">
                                            @error('category')
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
