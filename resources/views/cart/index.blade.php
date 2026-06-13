@extends('main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Koszyk</h1>

        <a href="{{ route('shop.index') }}" class="btn btn-secondary">
            Wróć do sklepu
        </a>
    </div>

    @if($products->count() == 0)
        <div class="alert alert-info">
            Koszyk jest pusty.
        </div>
    @else
        @if($hasStockError)
            <div class="alert alert-warning">
                W koszyku znajduje się produkt, którego ilość jest większa niż aktualny stan magazynowy.
                Usuń produkt z koszyka albo zmniejsz ilość przez ponowne dodanie po odświeżeniu stanu.
            </div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Produkt</th>
                <th>Cena</th>
                <th>Ilość w koszyku</th>
                <th>Stan magazynowy</th>
                <th>Razem</th>
                <th>Akcja</th>
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
                        {{ $product->Name }}

                        @if($quantity > $product->Stock)
                            <div class="text-danger small">
                                W koszyku jest więcej sztuk niż w magazynie.
                            </div>
                        @endif
                    </td>

                    <td>
                        {{ number_format($product->Price, 2) }} zł
                    </td>

                    <td>
                        {{ $quantity }}
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

                        <div class="text-danger mt-2">
                            Popraw koszyk, ponieważ ilość produktu przekracza stan magazynowy.
                        </div>
                    @else
                        <button type="submit" class="btn btn-success">
                            Złóż zamówienie
                        </button>
                    @endif
                </form>
            </div>
        </div>
    @endif
@endsection