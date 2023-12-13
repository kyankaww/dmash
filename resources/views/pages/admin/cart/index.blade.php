@extends('layout.admin')
@section('navbar-sidebar')
    @include('component._navbar')
    @include('component._sidebar')
@endsection
@section('content')
    <div class="section-body">
        @foreach ($product as $key => $item)
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2">
                            <img src="{{ asset('images/' . $item->img) }}" alt="" class="img-fluid">
                        </div>
                        <div class="col-10">
                            <form action="/cart" method="POST">
                                @csrf
                                <h5>{{ $item->name }}</h5>
                                <p>{{ $item->description }}</p>
                                <p>Rp. {{ number_format($item->price) }}</p>
                                <div class="d-flex align-item-baseline">
                                    <div>
                                        <input type="text" name="brg_id" value="<?= $item->id ?>" hidden>
                                    </div>
                                    <div class="d-flex">
                                        <span class="btn btn-info d-flex justify-content-center align-items-center" id="minus-<?= $item->id ?>">
                                            <i class="fas fa-minus"></i>
                                        </span>
                                        <input type="number" readonly name="qty" min="1" max="<?= $item->stock?>" class="form-control"
                                            value="1" id="qty-<?= $item->id ?>">
                                        <span class="btn btn-info d-flex justify-content-center align-items-center" id="plus-<?= $item->id ?>">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                    </div>
                                    {{-- <a href="?" class="btn btn-primary">Add to Cart</a> --}}
                                    <input type="submit" value="Add to Cart" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        @endforeach
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
@endsection
