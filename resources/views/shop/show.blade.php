@extends('main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>{{ $product->Name }}</h1>
            <p class="text-muted">
                Szczegóły produktu dostępnego w sklepie.
            </p>
        </div>

        <div>
            @if($product->category)
                <a href="{{ route('shop.category', $product->CategoryId) }}" class="btn btn-secondary">
                    Wróć do kategorii
                </a>
            @endif

            <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary">
                Wróć do sklepu
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    @if($product->ImageUrl)
                        <img src="{{ $product->ImageUrl }}"
                             alt="{{ $product->Name }}"
                             class="img-fluid rounded">
                    @else
                        <div class="border rounded p-5 text-muted">
                            Brak obrazka produktu
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-7 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    Informacje o produkcie
                </div>

                <div class="card-body">
                    @if((int)$product->IsPromoted == 1)
                        <span class="badge bg-warning text-dark mb-3">
                            Produkt promowany
                        </span>
                    @endif

                    <h4 class="mb-3">
                        {{ $product->Name }}
                    </h4>

                    <p>
                        <strong>Kategoria:</strong>
                        {{ $product->category->Name ?? 'Brak kategorii' }}
                    </p>

                    <p>
                        <strong>Cena:</strong>
                        {{ number_format($product->Price, 2) }} zł
                    </p>

                    <p>
                        <strong>Stan magazynowy:</strong>

                        @if($product->Stock > 0)
                            {{ $product->Stock }} szt.
                        @else
                            <span class="badge bg-danger">
                                Brak w magazynie
                            </span>
                        @endif
                    </p>

                    <hr>

                    <h5>Opis produktu</h5>

                    <p>
                        {{ $product->Description }}
                    </p>

                    <hr>

                    <h5>Pasujące akcesoria</h5>

                    @if($product->accessories->count() > 0)
                        <ul>
                            @foreach($product->accessories as $accessory)
                                <li>
                                    {{ $accessory->Name }}
                                    - {{ number_format($accessory->Price, 2) }} zł
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">
                            Brak przypisanych akcesoriów.
                        </p>
                    @endif
                </div>

                <div class="card-footer">
                    @if($product->Stock > 0)
                        <form method="POST" action="{{ route('cart.add', $product->Id) }}">
                            @csrf

                            <button class="btn btn-success w-100" type="submit">
                                Dodaj do koszyka
                            </button>
                        </form>
                    @else
                        <button class="btn btn-secondary w-100" type="button" disabled>
                            Brak w magazynie
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection