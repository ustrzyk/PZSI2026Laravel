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
            Szybki wybór kategorii
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
                            <div class="card h-100 text-center">
                                <div class="card-body">
                                    <div style="font-size: 36px;">
                                        {{ $icons[$loop->index % count($icons)] }}
                                    </div>

                                    <h5 class="mt-2">
                                        {{ $category->Name }}
                                    </h5>

                                    <p class="text-muted small mb-0">
                                        {{ \Illuminate\Support\Str::limit($category->Description, 60) }}
                                    </p>
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
            Szukaj w produktach promowanych
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
                                    @if($categoryId == $category->Id) selected @endif>
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

    <h4 class="mb-3">Produkty promowane</h4>

    @if($promotedProducts->count() == 0)
        <div class="alert alert-info">
            Brak produktów promowanych dla wybranych kryteriów.
        </div>
    @else
        @php
            $slides = $promotedProducts->chunk(3);
        @endphp

        <div id="promotedCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($slides as $slide)
                    <div class="carousel-item @if($loop->first) active @endif">
                        <div class="row">
                            @foreach($slide as $product)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        @if($product->ImageUrl)
                                            <img src="{{ $product->ImageUrl }}"
                                                 class="card-img-top"
                                                 alt="{{ $product->Name }}">
                                        @endif

                                        <div class="card-body">
                                            <span class="badge bg-warning text-dark mb-2">
                                                Promowane
                                            </span>

                                            <h5 class="card-title">
                                                {{ $product->Name }}
                                            </h5>

                                            <p class="card-text">
                                                {{ \Illuminate\Support\Str::limit($product->Description, 110) }}
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
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            @if($slides->count() > 1)
                <button class="carousel-control-prev"
                        type="button"
                        data-bs-target="#promotedCarousel"
                        data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded" aria-hidden="true"></span>
                    <span class="visually-hidden">Poprzednie</span>
                </button>

                <button class="carousel-control-next"
                        type="button"
                        data-bs-target="#promotedCarousel"
                        data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded" aria-hidden="true"></span>
                    <span class="visually-hidden">Następne</span>
                </button>
            @endif
        </div>
    @endif
@endsection