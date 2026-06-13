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
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Produkt</th>
                <th>Cena</th>
                <th>Ilość</th>
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
                    <td>{{ $product->Name }}</td>
                    <td>{{ number_format($product->Price, 2) }} zł</td>
                    <td>{{ $quantity }}</td>
                    <td>{{ number_format($sum, 2) }} zł</td>
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

                    <button type="submit" class="btn btn-success">
                        Złóż zamówienie
                    </button>
                </form>
            </div>
        </div>
    @endif
@endsection