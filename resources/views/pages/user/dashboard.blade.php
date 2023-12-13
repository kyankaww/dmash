@extends('layout.user')
@section('content')
    <nav class="navbar navbar-expand-lg bg-light shadow fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Koperasi KGR</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/profile">Profile</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="hero"
        style="
    height: 100vh;
    height: 600px;
    width: 100%;
    background-image: linear-gradient( rgb(84 95 153 / 67%), rgb(134 146 209 / 82%) );
    background-size: cover;
    ">
        <div class="container col d-flex">
            <div class="hero-text col-6 my-auto" style="padding-top: 10%">
                <h1 style="color: white; font-size: 50px; font-weight: bold;">Koperasi KGR</h1>
                <p style="color: white; font-size: 20px;">Koperasi KGR adalah koperasi Sekolah KGR</p>
                <a href="#" class="btn btn-primary">Mulai Berbelanja</a>
            </div>
            <div class="hero-img col-6" style="padding-top: 10%">
                <img src="{{ asset('assets') }}/img/hero.jpg" alt="" style="width: 100%">
            </div>
        </div>

    </div>
    <div class="product container">
        <h2 class="text-center mt-2">Product</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($product as $item)
                <div class="col">
                    <div class="card h-100">
                        <img src="{{ asset('images/' . $item->img) }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->product_name }}</h5>
                            <p class="card-text">{{ !nl2br($item->desc) }}</p>
                            <form action="/order" method="post">
                                @csrf
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-transparent" disabled>Rp.
                                        {{ number_format($item->price) }}</button>
                                        @if ($item->stock <= 0)
                                        <input type="submit" value="Habis" class="btn btn-danger" disabled>
                                    @else
                                    <div class="d-flex">
                                        <span
                                            class="btn btn-info d-flex justify-content-center align-items-center text-white"
                                            id="minus-<?= $item->id ?>">
                                            <i class="fas fa-minus"></i>
                                        </span>
                                        <input type="number" readonly name="qty" min="1"
                                            max="<?= $item->stock ?>" class="form-control" value="1"
                                            id="qty-<?= $item->id ?>">
                                        <span
                                            class="btn btn-info d-flex justify-content-center align-items-center text-white"
                                            id="plus-<?= $item->id ?>">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="products_id" value="<?= $item->id ?>" hidden>
                                    
                                        <input type="submit" value="Buy Now" class="btn btn-primary">
                                    @endif
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <small class="text-body-secondary">Stock : {{ $item->stock <= 0  ? 'Habis' : $item->stock }}</small>
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
@endsection
