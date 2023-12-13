@extends('layout.admin')
@section('plugin-css')
    <link rel="stylesheet" href="{{ asset('assets') }}/node_modules/summernote/dist/summernote-bs4.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/node_modules/codemirror/lib/codemirror.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/node_modules/codemirror/theme/duotone-dark.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/node_modules/selectric/public/selectric.css">
@endsection
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
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambahProduct">
                    Tambah Product
                </button>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahStock">
                    Tambah Stock
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="my_table">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-nowrap" style="width:50px">No</th>
                            <th class="text-nowrap">Product Name</th>
                            <th class="text-nowrap">Img</th>
                            <th class="text-nowrap">Category</th>
                            <th class="text-nowrap">Price</th>
                            <th class="text-nowrap">Stock</th>
                            <th class="text-nowrap">Discount</th>
                            <th class="text-nowrap">Status</th>
                            <th class="text-nowrap" style="width: 100px">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product as $item)
                            <tr>
                                <td class="text-nowrap">{{ $loop->iteration }}</td>
                                <td class="text-nowrap">{{ $item->product_name }}</td>
                                <td class="text-nowrap">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#img<?= $item->id ?>">
                                        img
                                    </button>
                                </td>
                                <td class="text-nowrap">{{ $item->category->category }}</td>
                                <td class="text-nowrap">{{ $item->price }}</td>
                                <td class="text-nowrap">{{ $item->stock }}</td>
                                <td class="text-nowrap">{{ $item->discount }}</td>
                                <td class="text-nowrap">{{ $item->status == 1 ? 'Aktif' : 'Tidak Aktif' }}</td>
                                <td class="text-nowrap">
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-warning" data-toggle="modal"
                                            data-target="#editProduct">
                                            Edit
                                        </button>
                                        <form action="{{ route('product.destroy', $item->id) }}" method="post"
                                            id="delete_form{{ $item->id }}">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-danger"
                                                onclick="delete_item('delete_form{{ $item->id }}')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <div class="modal fade" id="img<?= $item->id ?>" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Image Product</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <img class="img-fluid" src="{{ asset('images') }}/<?= $item->img ?>"
                                                alt="">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="editProduct" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Stock</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('product.update', $item->id) }}" method="post">
                                            @csrf
                                            @method('put')
                                            <div class="card">
                                                <div class="card-body">

                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="mb-3">
                                                                <label for="product_name" class="form-label">Product Name
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="text"
                                                                    class="form-control @error('product_name') is-invalid @enderror"
                                                                    name="product_name" id="product_name"
                                                                    placeholder="Masukkan Product Name"
                                                                    value="{{ old('product_name') ? old('product_name') : $item->product_name }}">
                                                                @error('product_name')
                                                                    <span
                                                                        class="text-danger d-block">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="col">
                                                            <div class="mb-3">
                                                                <label for="img" class="form-label">Img <span
                                                                        class="text-danger">*</span></label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="form-control"
                                                                        name="img">
                                                                    <input type="file" class="form-control"
                                                                        name="img_old" hidden
                                                                        value="<?= $item->img ?>">
                                                                    <small><a href="{{ asset('images') }}/<?= $item->img ?>">Foto Produk
                                                                            Sebelumnya</a></small>
                                                                    @error('img')
                                                                        <span
                                                                            class="text-danger d-block">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="mb-3">
                                                                <label for="stock" class="form-label">Stock <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="number"
                                                                    class="form-control @error('stock') is-invalid @enderror"
                                                                    name="stock" id="stock"
                                                                    placeholder="Masukkan Stock"
                                                                    value="{{ old('stock') ? old('stock') : $item->stock }}">
                                                                @error('stock')
                                                                    <span
                                                                        class="text-danger d-block">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="col">
                                                            <div class="mb-3">
                                                                <label for="discount" class="form-label">Discount <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="number"
                                                                    class="form-control @error('discount') is-invalid @enderror"
                                                                    name="discount" id="discount"
                                                                    placeholder="Masukkan Discount"
                                                                    value="{{ old('discount') ? old('discount') : $item->discount }}">
                                                                @error('discount')
                                                                    <span
                                                                        class="text-danger d-block">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="mb-3">
                                                                <label for="category" class="form-label">Category <span
                                                                        class="text-danger">*</span></label>
                                                                <select
                                                                    class="custom-select @error('category') is-invalid @enderror"
                                                                    name="category" id="category">
                                                                    <option value="" hidden>
                                                                        <?= $item->category->category ?></option>
                                                                    @foreach ($category as $cate)
                                                                        <option value="{{ $cate->id }}">
                                                                            {{ $cate->category }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('category')
                                                                    <span
                                                                        class="text-danger d-block">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="mb-3">
                                                                <label for="price" class="form-label">Price <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="number"
                                                                    class="form-control @error('price') is-invalid @enderror"
                                                                    name="price" id="price"
                                                                    placeholder="Masukkan Price"
                                                                    value="{{ old('price') ? old('price') : $item->price }}">
                                                                @error('price')
                                                                    <span
                                                                        class="text-danger d-block">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="mb-3">
                                                                <label for="desc" class="form-label">Desc <span
                                                                        class="text-danger">*</span></label>
                                                                <textarea class="summernote" name="desc">{!! $item->desc !!}</textarea>
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
    <div class="modal fade" id="tambahStock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Stock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/tambah-stock" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-4">
                            <div class="col">
                                <label>Product</label>
                                <select name="brg_id" class="custom-select">
                                    <option hidden>Pilih Barang</option>
                                    @foreach ($product as $item)
                                        <option value="{{ $item->id }}">{{ $item->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label>Jumlah Stock</label>
                                <input type="number" name="stock" placeholder="Masukkan Jumlah Stock"
                                    class="form-control">
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
    <div class="modal fade" id="tambahProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Stock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="product_name" class="form-label">Product Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('product_name') is-invalid @enderror"
                                            name="product_name" id="product_name" placeholder="Masukkan Product Name"
                                            value="{{ old('product_name') }}">
                                        @error('product_name')
                                            <span class="text-danger d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="img" class="form-label">Img <span
                                                class="text-danger">*</span></label>
                                        <div class="custom-file">
                                            <input type="file" class="form-control" name="img">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('price') is-invalid @enderror"
                                            name="price" id="price" placeholder="Masukkan Price"
                                            value="{{ old('price') }}">
                                        @error('price')
                                            <span class="text-danger d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="stock" class="form-label">Stock <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                            name="stock" id="stock" placeholder="Masukkan Stock"
                                            value="{{ old('stock') }}">
                                        @error('stock')
                                            <span class="text-danger d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="discount" class="form-label">Discount <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('discount') is-invalid @enderror"
                                            name="discount" id="discount" placeholder="Masukkan Discount"
                                            value="{{ old('discount') }}">
                                        @error('discount')
                                            <span class="text-danger d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status <span
                                                class="text-danger">*</span></label>
                                        <select class="custom-select @error('status') is-invalid @enderror" name="status"
                                            id="status">
                                            <option value="" hidden>Pilih Status</option>
                                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Aktif
                                            </option>
                                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Tidak
                                                Aktif</option>
                                        </select>
                                        @error('status')
                                            <span class="text-danger d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Category <span
                                                class="text-danger">*</span></label>
                                        <select class="custom-select @error('category') is-invalid @enderror"
                                            name="category" id="category">
                                            <option value="" hidden>Pilih Category</option>
                                            @foreach ($category as $cate)
                                                <option value="{{ $cate->id }}"
                                                    {{ old('category') == $cate->id ? 'selected' : '' }}>
                                                    {{ $cate->category }}
                                                </option>
                                            @endforeach
                                            </option>
                                        </select>
                                        @error('category')
                                            <span class="text-danger d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="desc" class="form-label">Desc <span
                                                class="text-danger">*</span></label>
                                        {{-- <textarea class="form-control @error('desc') is-invalid @enderror" name="desc" id="desc" rows="8"
                                            placeholder="Masukkan Desc">{{ old('desc') }}</textarea> --}}
                                        <textarea class="summernote" name="desc"></textarea>
                                        @error('desc')
                                            <span class="text-danger d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
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
@section('library-js')
    <script src="{{ asset('assets') }}/node_modules/summernote/dist/summernote-bs4.js"></script>
    <script src="{{ asset('assets') }}/node_modules/codemirror/lib/codemirror.js"></script>
    <script src="{{ asset('assets') }}/node_modules/codemirror/mode/javascript/javascript.js"></script>
    <script src="{{ asset('assets') }}/node_modules/selectric/public/jquery.selectric.min.js"></script>
@endsection
