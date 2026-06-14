@extends('main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Koszyk</h1>

        <a href="{{ route('shop.index') }}" class="btn btn-secondary">
            Wróć do sklepu
        </a>
    </div>

    @if(count($cart) == 0)
        <div class="alert alert-info">
            Koszyk jest pusty.
        </div>
    @else
        @if($hasStockError)
            <div class="alert alert-warning">
                Koszyk zawiera produkt niedostępny albo ilość większą niż stan magazynowy.
            </div>
        @endif

        @if($unavailableProducts->count() > 0 || $missingProductIds->count() > 0)
            <div class="card mb-4">
                <div class="card-header">
                    Niedostępne produkty
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-striped align-middle mb-0">
                        <thead>
                        <tr>
                            <th>Produkt</th>
                            <th>Ilość</th>
                            <th>Powód</th>
                            <th>Akcja</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($unavailableProducts as $product)
                            <tr>
                                <td>
                                    {{ $product->Name }}
                                </td>

                                <td>
                                    {{ $cart[$product->Id] ?? 0 }}
                                </td>

                                <td>
                                    Niedostępny
                                </td>

                                <td>
                                    <form method="POST" action="{{ route('cart.remove', $product->Id) }}">
                                        @csrf

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Usuń
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        @foreach($missingProductIds as $missingProductId)
                            <tr>
                                <td>
                                    Produkt #{{ $missingProductId }}
                                </td>

                                <td>
                                    {{ $cart[$missingProductId] ?? 0 }}
                                </td>

                                <td>
                                    Brak produktu
                                </td>

                                <td>
                                    <form method="POST" action="{{ route('cart.remove', $missingProductId) }}">
                                        @csrf

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Usuń
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if($products->count() > 0)
            <table class="table table-bordered table-striped align-middle">
                <thead>
                <tr>
                    <th>Produkt</th>
                    <th>Cena</th>
                    <th>Ilość</th>
                    <th>Stan magazynowy</th>
                    <th>Razem</th>
                    <th>Akcje</th>
                </tr>
                </thead>

                <tbody>
                @foreach($products as $product)
                    @php
                        $quantity = $cart[$product->Id] ?? 0;
                        $sum = $product->Price * $quantity;
                    @endphp

                    <tr>
                        <td>
                            <strong>{{ $product->Name }}</strong>

                            @if($quantity > $product->Stock)
                                <div class="text-danger small">
                                    W koszyku jest więcej sztuk niż w magazynie.
                                </div>
                            @endif

                            <div class="mt-2">
                                <a href="{{ route('shop.show', $product->Id) }}"
                                   class="btn btn-info btn-sm">
                                    Szczegóły
                                </a>
                            </div>
                        </td>

                        <td>
                            {{ number_format($product->Price, 2) }} zł
                        </td>

                        <td>
                            <div class="d-flex align-items-center">
                                <form method="POST" action="{{ route('cart.decrease', $product->Id) }}">
                                    @csrf

                                    <button type="submit" class="btn btn-outline-secondary btn-sm">
                                        -
                                    </button>
                                </form>

                                <span class="mx-3">
                                    {{ $quantity }}
                                </span>

                                @if($quantity < $product->Stock)
                                    <form method="POST" action="{{ route('cart.increase', $product->Id) }}">
                                        @csrf

                                        <button type="submit" class="btn btn-outline-secondary btn-sm">
                                            +
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="btn btn-outline-secondary btn-sm" disabled>
                                        +
                                    </button>
                                @endif
                            </div>

                            @if($quantity >= $product->Stock)
                                <div class="text-muted small mt-1">
                                    Osiągnięto maksymalny stan.
                                </div>
                            @endif
                        </td>

                        <td>
                            @if($product->Stock > 0)
                                {{ $product->Stock }} szt.
                            @else
                                <span class="badge bg-danger">
                                    Brak w magazynie
                                </span>
                            @endif
                        </td>

                        <td>
                            {{ number_format($sum, 2) }} zł
                        </td>

                        <td>
                            <form method="POST" action="{{ route('cart.remove', $product->Id) }}">
                                @csrf

                                <button type="submit" class="btn btn-danger btn-sm">
                                    Usuń
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="text-end mb-4">
                <h4>Razem: {{ number_format($total, 2) }} zł</h4>
            </div>

            <div class="card">
                <div class="card-header">
                    Dane do zamówienia
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('cart.order') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Imię i nazwisko</label>
                            <input type="text"
                                   name="CustomerName"
                                   class="form-control"
                                   value="{{ old('CustomerName', session('user_name')) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email / login kontaktowy</label>
                            <input type="text"
                                   name="CustomerEmail"
                                   class="form-control"
                                   value="{{ old('CustomerEmail') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Adres dostawy</label>
                            <textarea name="Address"
                                      class="form-control"
                                      rows="3">{{ old('Address') }}</textarea>
                        </div>

                        @if($hasStockError)
                            <button type="button" class="btn btn-secondary" disabled>
                                Nie można złożyć zamówienia
                            </button>
                        @else
                            <button type="submit" class="btn btn-success">
                                Złóż zamówienie
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        @else
            <div class="alert alert-info">
                Brak dostępnych produktów w koszyku.
            </div>
        @endif
    @endif
@endsection