@extends('main')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1>Sklep z drukarkami 3D</h1>
        <p class="text-muted">
            Sklep internetowy z drukarkami 3D, filamentami i akcesoriami.
        </p>
    </div>

    <a href="{{ route('cart.index') }}" class="btn btn-primary">
        Przejdź do koszyka
    </a>
</div>

<div class="card mb-4">
    <div class="card-header">
        Wyszukiwanie i filtrowanie produktów
    </div>

    <div class="card-body">
        <form method="GET" action="{{ route('shop.index') }}">
            <div class="row">
                <div class="col-md-5 mb-3">
                    <label class="form-label">Nazwa produktu</label>
                    <input type="text"
                        name="search"
                        class="form-control"
                        placeholder="Szukaj produktu..."
                        value="{{ $search }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Kategoria</label>
                    <select name="category_id" class="form-control">
                        <option value="">Wszystkie kategorie</option>

                        @foreach($categories as $category)
                        <option value="{{ $category->Id }}"
                            @if($categoryId==$category->Id) selected @endif>
                            {{ $category->Name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mb-3 d-flex align-items-end">
                    <button class="btn btn-dark w-100 me-2" type="submit">
                        Szukaj
                    </button>

                    <a href="{{ route('shop.index') }}" class="btn btn-secondary w-100">
                        Wyczyść
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Produkty</h4>

    <span class="text-muted">
        Wyświetlono {{ $products->count() }} z {{ $products->total() }} produktów
    </span>
</div>

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
                    {{ \Illuminate\Support\Str::limit($product->Description, 120) }}
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
            Brak produktów dla wybranych kryteriów.
        </div>
    </div>
    @endforelse
</div>

<div class="mt-4">
    {{ $products->links('pagination::bootstrap-5') }}
</div>
@endsection