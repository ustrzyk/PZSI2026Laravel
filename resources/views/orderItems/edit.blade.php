@extends('main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Edytuj pozycję zamówienia</h1>

        <a href="{{ route('order-items.index') }}" class="btn btn-secondary">
            Wróć
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('order-items.update', $item->Id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Zamówienie</label>

                    <select name="OrderId" class="form-control">
                        <option value="">-- wybierz zamówienie --</option>

                        @foreach($orders as $order)
                            <option value="{{ $order->Id }}"
                                @if(old('OrderId', $item->OrderId) == $order->Id) selected @endif>
                                #{{ $order->Id }} - {{ $order->CustomerName }} - {{ number_format($order->TotalPrice, 2) }} zł
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Produkt</label>

                    <select name="ProductId" class="form-control">
                        <option value="">-- wybierz produkt --</option>

                        @foreach($products as $product)
                            <option value="{{ $product->Id }}"
                                @if(old('ProductId', $item->ProductId) == $product->Id) selected @endif>
                                {{ $product->Name }} - {{ number_format($product->Price, 2) }} zł
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ilość</label>

                    <input type="number"
                           name="Quantity"
                           class="form-control"
                           value="{{ old('Quantity', $item->Quantity) }}">
                </div>

                <button type="submit" class="btn btn-success">
                    Zapisz zmiany
                </button>
            </form>
        </div>
    </div>
@endsection