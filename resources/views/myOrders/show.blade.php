@extends('main')

@section('content')
    @php
        $statusNames = [
            'New' => 'Nowe',
            'Paid' => 'Opłacone',
            'Sent' => 'Wysłane',
            'Finished' => 'Zakończone',
            'Cancelled' => 'Anulowane',
        ];

        $statusClasses = [
            'New' => 'bg-secondary',
            'Paid' => 'bg-primary',
            'Sent' => 'bg-warning text-dark',
            'Finished' => 'bg-success',
            'Cancelled' => 'bg-danger',
        ];
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Zamówienie #{{ $order->Id }}</h1>

        <a href="{{ route('my-orders.index') }}" class="btn btn-secondary">
            Wróć
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            Dane zamówienia
        </div>

        <div class="card-body">
            <p>
                <strong>Numer:</strong>
                #{{ $order->Id }}
            </p>

            <p>
                <strong>Data:</strong>
                {{ \Carbon\Carbon::parse($order->CreationDateTime)->format('d.m.Y H:i') }}
            </p>

            <p>
                <strong>Status:</strong>
                <span class="badge {{ $statusClasses[$order->Status] ?? 'bg-secondary' }}">
                    {{ $statusNames[$order->Status] ?? $order->Status }}
                </span>
            </p>

            <p>
                <strong>Wartość:</strong>
                {{ number_format($order->TotalPrice, 2) }} zł
            </p>

            <hr>

            <p>
                <strong>Imię i nazwisko:</strong>
                {{ $order->CustomerName }}
            </p>

            <p>
                <strong>Email:</strong>
                {{ $order->CustomerEmail }}
            </p>

            <p class="mb-0">
                <strong>Adres:</strong>
                {{ $order->Address }}
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Produkty
        </div>

        <div class="card-body">
            @if($order->items->count() == 0)
                <div class="alert alert-info mb-0">
                    Brak pozycji.
                </div>
            @else
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                    <tr>
                        <th>Produkt</th>
                        <th>Kategoria</th>
                        <th>Ilość</th>
                        <th>Cena</th>
                        <th>Razem</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>
                                {{ $item->product->Name ?? 'Brak produktu' }}
                            </td>

                            <td>
                                {{ $item->product->category->Name ?? 'Brak kategorii' }}
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
                </table>

                <div class="text-end">
                    <h4>
                        Razem: {{ number_format($order->TotalPrice, 2) }} zł
                    </h4>
                </div>
            @endif
        </div>
    </div>
@endsection