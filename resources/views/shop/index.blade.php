@extends('main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Sklep z drukarkami 3D</h1>
            <p class="text-muted">
                Prosty sklep internetowy z drukarkami 3D, filamentami i akcesoriami.
            </p>
        </div>

        <a href="{{ route('cart.index') }}" class="btn btn-primary">
            Przejdź do koszyka
        </a>
    </div>

    <form method="GET" action="{{ route('shop.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-10">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Szukaj produktu..."
                       value="{{ request('search') }}">
            </div>

            <div class="col-md-2">
                <button class="btn btn-dark w-100" type="submit">
                    Szukaj
                </button>
            </div>
        </div>
    </form>

    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($product->ImageUrl)
                        <img src="{{ $product->ImageUrl }}" class="card-img-top" alt="{{ $product->Name }}">
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $product->Name }}</h5>

                        <p class="card-text">
                            {{ $product->Description }}
                        </p>

                        <p class="mb-1">
                            <strong>Kategoria:</strong>
                            {{ $product->category->Name ?? 'Brak' }}
                        </p>

                        <p class="mb-1">
                            <strong>Cena:</strong>
                            {{ number_format($product->Price, 2) }} zł
                        </p>

                        <p class="mb-3">
                            <strong>Stan:</strong>
                            {{ $product->Stock }} szt.
                        </p>

                        @if($product->accessories->count() > 0)
                            <p class="mb-1">
                                <strong>Akcesoria:</strong>
                            </p>

                            <ul>
                                @foreach($product->accessories as $accessory)
                                    <li>{{ $accessory->Name }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div class="card-footer">
                        <form method="POST" action="{{ route('cart.add', $product->Id) }}">
                            @csrf
                            <button class="btn btn-success w-100" type="submit">
                                Dodaj do koszyka
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Brak produktów do wyświetlenia.
                </div>
            </div>
        @endforelse
    </div>
@endsection