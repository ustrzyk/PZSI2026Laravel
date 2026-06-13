@extends('main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Kategoria: {{ $currentCategory->Name }}</h1>
            <p class="text-muted">
                {{ $currentCategory->Description }}
            </p>
        </div>

        <a href="{{ route('shop.index') }}" class="btn btn-secondary">
            Wróć do strony głównej
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            Kategorie
        </div>

        <div class="card-body">
            <div class="row">
                @php
                    $icons = ['🖨️', '🧵', '🔧', '⚙️', '📦', '🛠️'];
                @endphp

                @foreach($categories as $category)
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('shop.category', $category->Id) }}"
                           class="text-decoration-none text-dark">
                            <div class="card h-100 text-center @if($category->Id == $currentCategory->Id) border-primary @endif">
                                <div class="card-body">
                                    <div style="font-size: 32px;">
                                        {{ $icons[$loop->index % count($icons)] }}
                                    </div>

                                    <strong>
                                        {{ $category->Name }}
                                    </strong>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            Wyszukiwanie w kategorii
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('shop.category', $currentCategory->Id) }}">
                <div class="row">
                    <div class="col-md-9 mb-3">
                        <label class="form-label">Nazwa produktu</label>
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Szukaj produktu w tej kategorii..."
                               value="{{ $search }}">
                    </div>

                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <button class="btn btn-dark w-100 me-2" type="submit">
                            Szukaj
                        </button>

                        <a href="{{ route('shop.category', $currentCategory->Id) }}" class="btn btn-secondary w-100">
                            Wyczyść
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Produkty w kategorii</h4>

        <span class="text-muted">
            Wyświetlono {{ $products->count() }} z {{ $products->total() }} produktów
        </span>
    </div>

    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($product->ImageUrl)
                        <img src="{{ $product->ImageUrl }}"
                             class="card-img-top"
                             alt="{{ $product->Name }}">
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">
                            {{ $product->Name }}
                        </h5>

                        <p class="card-text">
                            {{ \Illuminate\Support\Str::limit($product->Description, 120) }}
                        </p>

                        <p class="mb-1">
                            <strong>Cena:</strong>
                            {{ number_format($product->Price, 2) }} zł
                        </p>

                        <p class="mb-3">
                            <strong>Stan:</strong>

                            @if($product->Stock > 0)
                                {{ $product->Stock }} szt.
                            @else
                                <span class="badge bg-danger">
                                    Brak w magazynie
                                </span>
                            @endif
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
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Brak produktów w tej kategorii dla wybranych kryteriów.
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
@endsection