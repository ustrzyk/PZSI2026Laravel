@extends('main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Zamówienie #{{ $order->Id }}</h1>
            <p class="text-muted">
                Szczegóły Twojego zamówienia.
            </p>
        </div>

        <a href="{{ route('my-orders.index') }}" class="btn btn-secondary">
            Wróć do moich zamówień
        </a>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header">
                    Dane zamówienia
                </div>

                <div class="card-body">
                    <p>
                        <strong>Numer zamówienia:</strong>
                        #{{ $order->Id }}
                    </p>

                    <p>
                        <strong>Data:</strong>
                        {{ \Carbon\Carbon::parse($order->CreationDateTime)->format('d.m.Y H:i') }}
                    </p>

                    <p>
                        <strong>Status:</strong>

                        @if($order->Status == 'New')
                            <span class="badge bg-primary">Nowe</span>
                        @elseif($order->Status == 'Paid')
                            <span class="badge bg-success">Opłacone</span>
                        @elseif($order->Status == 'Sent')
                            <span class="badge bg-warning text-dark">Wysłane</span>
                        @elseif($order->Status == 'Finished')
                            <span class="badge bg-dark">Zakończone</span>
                        @else
                            <span class="badge bg-secondary">{{ $order->Status }}</span>
                        @endif
                    </p>

                    <p>
                        <strong>Wartość:</strong>
                        {{ number_format($order->TotalPrice, 2) }} zł
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header">
                    Dane klienta
                </div>

                <div class="card-body">
                    <p>
                        <strong>Imię i nazwisko:</strong>
                        {{ $order->CustomerName }}
                    </p>

                    <p>
                        <strong>Email:</strong>
                        {{ $order->CustomerEmail }}
                    </p>

                    <p>
                        <strong>Adres:</strong>
                        {{ $order->Address }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <h4 class="mb-3">Produkty w zamówieniu</h4>

    @if($order->items->count() == 0)
        <div class="alert alert-info">
            Brak aktywnych pozycji w tym zamówieniu.
        </div>
    @else
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Produkt</th>
                <th>Ilość</th>
                <th>Cena</th>
                <th>Suma</th>
            </tr>
            </thead>

            <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>
                        {{ $item->product->Name ?? 'Brak produktu' }}
                    </td>

                    <td>
                        {{ $item->Quantity }}
                    </td>

                    <td>
                        {{ number_format($item->Price, 2) }} zł
                    </td>

                    <td>
                        {{ number_format($item->Price * $item->Quantity, 2) }} zł
                    </td>
                </tr>
            @endforeach
            </tbody>

            <tfoot>
            <tr>
                <th colspan="3" class="text-end">
                    Razem:
                </th>

                <th>
                    {{ number_format($order->TotalPrice, 2) }} zł
                </th>
            </tr>
            </tfoot>
        </table>
    @endif
@endsection