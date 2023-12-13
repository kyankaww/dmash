@extends('layout.user')
@section('content')
    <div class="container d-flex align-items-start mt-5">
        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile"
                type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</button>
            <button class="nav-link" id="v-pills-order-tab" data-bs-toggle="pill" data-bs-target="#v-pills-order"
                type="button" role="tab" aria-controls="v-pills-order" aria-selected="false">Order</button>
            <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings"
                type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</button>
        </div>
        <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab"
                tabindex="0">
                <div class="card">
                    <div class="card-body">
                        <h5>{{ $user->nik }}</h5>
                        <p>{{ $user->email }}</p>
                        <p>{{ $user->no_hp }}</p>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="v-pills-order" role="tabpanel" aria-labelledby="v-pills-order-tab"
                tabindex="0">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            @foreach ($order as $item)
                                <div class="col-6">
                                    <div class="card rounded shadow my-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-4">
                                                    <img src="{{ asset('images/' . $item->product[0]->img) }}"
                                                        alt="" class="img-fluid">
                                                </div>
                                                <div class="col-4">
                                                    @csrf
                                                    <?php $price = $item->qty * $item->product[0]->price; ?>
                                                    <h5>{{ $item->product[0]->product_name }}</h5>
                                                    <p class="mb-0">{{ $item->qty }}</p>
                                                    <p>Rp. {{ number_format($price) }}</p>
                                                </div>
                                                <?php 
                                                    if ($item->status == 'pending') {
                                                    ?>
                                                <div class="col-4">
                                                    <button type="button" class="btn text-white btn-primary"
                                                        data-bs-toggle="modal" data-bs-target="#payment{{ $item->id }}">
                                                        Pilih Pembayaran
                                                    </button>
                                                    <form action="/order/{{ $item->id }}" method="post"
                                                        id="delete_form{{ $item->id }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="delete_item('delete_form{{ $item->id }}')">Hapus</button>
                                                    </form>
                                                </div>
                                                <?php
                                                } elseif ($item->status == 'pay') {
                                                    ?>
                                                <div class="offset-1 col-3 align-items-center">
                                                    <button type="button" class="btn btn-info text-white"
                                                        data-bs-toggle="modal" data-bs-target="#pay{{ $item->id }}">
                                                        Bayar
                                                    </button>
                                                    <form action="/order/{{ $item->id }}" method="post"
                                                        id="delete_form{{ $item->id }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="delete_item('delete_form{{ $item->id }}')">Hapus</button>
                                                    </form>
                                                </div>
                                                <?php
                                                } elseif ($item->status == 'waiting') {
                                                    ?>
                                                .<div class="col-4 align-items-center">
                                                    <button type="button" class="btn text-white btn-warning" disabled
                                                        data-toggle="modal" data-target="#payment{{ $item->id }}">
                                                        Menunggu Respon
                                                    </button>
                                                </div>
                                                <?php
                                                } elseif ($item->status == 'terima') {
                                                    ?>
                                                <div class="offset-1 col-3 align-items-center">
                                                    <button type="button" class="btn text-white btn-success" disabled
                                                        data-toggle="modal" disabled
                                                        data-target="#payment{{ $item->id }}">
                                                        Selesai
                                                    </button>
                                                </div>
                                                <?php
                                                } elseif ($item->status == 'tolak') {
                                                    ?>
                                                <div class="offset-1 col-3 align-items-center">
                                                    <button type="button" class="btn text-white btn-danger" disabled
                                                        data-toggle="modal" disabled
                                                        data-target="#payment{{ $item->id }}">
                                                        Ditolak
                                                    </button>
                                                </div>
                                                <?php
                                                } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="payment{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Pilih Pembayaran</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="/order-update" method="post">
                                                <div class="modal-body">
                                                    @csrf
                                                    <input type="text" hidden name="id"
                                                        value="{{ $item->id }}">
                                                    <label>Jenis Pembayaran</label>
                                                    <select name="payment_method" class="form-select">
                                                        <option hidden>Pilih Jenis Pembayaran</option>
                                                        @foreach ($method as $val)
                                                            <option value="{{ $val->id }}">{{ $val->method }} -
                                                                {{ $val->transfer_destination }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="pay{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Pembayaran</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="/payy" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <input type="text" hidden name="id"
                                                        value="{{ $item->id }}">
                                                    <label>Masukan Bukti Pembayaran</label>
                                                    <input type="file" name="evidance" class="form-control">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab"
                tabindex="0">...</div>
        </div>
    </div>
@endsection
