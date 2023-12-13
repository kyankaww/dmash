@extends('layout.admin')
@section('navbar-sidebar')
    @include('component._navbar')
    @include('component._sidebar')
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                @foreach ($order as $item)
                    <div class="col-6">
                        <div class="card rounded shadow">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <img src="{{ asset('images/' . $item->product[0]->img) }}" alt=""
                                            class="img-fluid">
                                    </div>
                                    <div class="col-5">
                                        <?php $price = $item->qty * $item->product[0]->price; ?>
                                        <h5>{{ $item->product[0]->product_name }}</h5>
                                        <p class="mb-0">{{ $item->qty }}</p>
                                        <p>Rp. {{ number_format($price) }}</p>
                                    </div>
                                    <div class="col-3">
                                        <form action="/approve" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <input type="hidden" name="status" value="terima">
                                            <button type="submit" class="btn btn-success btn-sm">Terima</button>
                                        </form>
                                        <form action="/approve" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <input type="hidden" name="status" value="tolak">
                                            <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
