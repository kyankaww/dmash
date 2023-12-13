@extends('layout.admin')
@section('navbar-sidebar')
    @include('component._navbar')
    @include('component._sidebar')
@endsection
@section('content')
    <div class="section-body">
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @foreach ($product as $key => $item)
                        <div class="row">
                            <div class="col-2">
                                <img src="{{ asset('images/' . $item->img) }}" alt="" class="img-fluid">
                            </div>
                            <div class="col-10">
                                <form action="/order" method="POST">
                                    @csrf
                                    <h5>{{ $item->name }}</h5>
                                    <p>{{ $item->description }}</p>
                                    <p>Rp. {{ number_format($item->price) }}</p>
                                    <div class="d-flex align-item-baseline">
                                        <div>
                                            <input type="text" name="products_id" value="<?= $item->id ?>" hidden>
                                        </div>
                                        <div class="d-flex">
                                            <span class="btn btn-info d-flex justify-content-center align-items-center"
                                                id="minus-<?= $item->id ?>">
                                                <i class="fas fa-minus"></i>
                                            </span>
                                            <input type="number" readonly name="qty" min="1"
                                                max="<?= $item->stock ?>" class="form-control" value="1"
                                                id="qty-<?= $item->id ?>">
                                            <span class="btn btn-info d-flex justify-content-center align-items-center"
                                                id="plus-<?= $item->id ?>">
                                                <i class="fas fa-plus"></i>
                                            </span>
                                        </div>
                                        <input type="submit" value="Buy Now" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row">
                @foreach ($order as $item)
                    <div class="col-6">
                        <div class="card rounded shadow">
                            <div class="card-body">
                                <form action="/order" method="POST">
                                    <div class="row">
                                        <div class="col-4">
                                            <img src="{{ asset('images/' . $item->product[0]->img) }}" alt=""
                                                class="img-fluid">
                                        </div>
                                        <div class="col-5">
                                            @csrf
                                            <?php $price = $item->qty * $item->product[0]->price; ?>
                                            <h5>{{ $item->product[0]->product_name }}</h5>
                                            <p class="mb-0">{{ $item->qty }}</p>
                                            <p>Rp. {{ number_format($price) }}</p>
                                        </div>
                                        <div class="col-3">
                                            <?php if ($item->status == 'pending') {
                                                ?>
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#payment{{ $item->id }}">
                                                Pilih Pembayaran
                                            </button>
                                            
                                            <?php
                                            } elseif ($item->status == 'on progress') {
                                                ?>
                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target="#payment{{ $item->id }}">
                                                Bayar
                                            </button>
                                            
                                            <?php
                                            } elseif ($item->status == 'waiting') {
                                                ?>
                                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                                data-target="#payment{{ $item->id }}">
                                                Menunggu Konfirmasi
                                            </button>
                                            <?php
                                            } elseif ($item->status == 'success') {
                                                ?>
                                            <button type="button" class="btn btn-success" data-toggle="modal" disabled
                                                data-target="#payment{{ $item->id }}">
                                                Selesai
                                            </button>
                                            <?php
                                            } elseif ($item->status == 'cancel') {
                                                ?>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" disabled
                                                data-target="#payment{{ $item->id }}">
                                                Ditolak
                                            </button>
                                            <?php
                                            } ?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="payment{{ $item->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Pilih Pembayaran</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="/payment" method="post">
                                        @csrf
                                        <input type="text" hidden name="order_id" value="{{ $item->id }}">
                                        
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            const plus = $("[id^='plus-']");
            plus.on("click", function() {
                var idNumber = this.id.match(/\d+/)[0];
                const qty = $("#qty-" + idNumber).val();
                $("#qty-" + idNumber).val(parseInt(qty) + 1);


            });

            const minus = $("[id^='minus-']");
            minus.on("click", function() {
                var idNumber = this.id.match(/\d+/)[0];
                const qty = $("#qty-" + idNumber).val();
                if (qty <= 0) {
                    return false;
                }
                $("#qty-" + idNumber).val(parseInt(qty) - 1);
            });
        </script>
    </div>
@endsection
