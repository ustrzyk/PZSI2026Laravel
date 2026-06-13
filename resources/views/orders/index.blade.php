@extends('main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Zamówienia</h1>

        <a href="{{ route('shop.index') }}" class="btn btn-secondary">
            Wróć do sklepu
        </a>
    </div>

    <form method="GET" action="{{ route('orders.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-10">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Szukaj po nazwie klienta"
                       value="{{ $search }}">
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-dark w-100">
                    Szukaj
                </button>
            </div>
        </div>
    </form>

    @if($orders->count() == 0)
        <div class="alert alert-info">
            Brak zamówień do wyświetlenia.
        </div>
    @else
        @foreach($orders as $order)
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Zamówienie #{{ $order->Id }}</strong>
                        <span class="badge bg-dark ms-2">{{ $order->Status }}</span>
                    </div>

                    <div>
                        <a href="{{ route('orders.edit', $order->Id) }}"
                           class="btn btn-warning btn-sm">
                            Edytuj status
                        </a>

                        <form method="POST"
                              action="{{ route('orders.delete', $order->Id) }}"
                              class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm">
                                Dezaktywuj
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1">
                                <strong>Klient:</strong>
                                {{ $order->CustomerName }}
                            </p>

                            <p class="mb-1">
                                <strong>Email / login kontaktowy:</strong>
                                {{ $order->CustomerEmail }}
                            </p>

                            <p class="mb-1">
                                <strong>Adres:</strong>
                                {{ $order->Address }}
                            </p>
                        </div>

                        <div class="col-md-6">
                            <p class="mb-1">
                                <strong>Użytkownik w systemie:</strong>
                                {{ $order->user->Name ?? 'Brak' }}
                            </p>

                            <p class="mb-1">
                                <strong>Data utworzenia:</strong>
                                {{ $order->CreationDateTime }}
                            </p>

                            <p class="mb-1">
                                <strong>Wartość zamówienia:</strong>
                                {{ number_format($order->TotalPrice, 2) }} zł
                            </p>
                        </div>
                    </div>

                    <h5>Pozycje zamówienia</h5>

                    @if($order->items->count() == 0)
                        <div class="alert alert-info">
                            Brak pozycji w tym zamówieniu.
                        </div>
                    @else
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Produkt</th>
                                <th>Ilość</th>
                                <th>Cena</th>
                                <th>Razem</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product->Name ?? 'Brak produktu' }}</td>
                                    <td>{{ $item->Quantity }}</td>
                                    <td>{{ number_format($item->Price, 2) }} zł</td>
                                    <td>{{ number_format($item->Price * $item->Quantity, 2) }} zł</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
@endsection