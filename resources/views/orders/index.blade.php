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
        <h1>Zamówienia</h1>

        <a href="{{ route('shop.index') }}" class="btn btn-secondary">
            Wróć do sklepu
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            Filtry
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('orders.index') }}">
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label class="form-label">Szukaj</label>

                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Klient, email, adres, numer..."
                               value="{{ $search }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status</label>

                        <select name="status" class="form-control">
                            <option value="">Wszystkie</option>

                            <option value="New" @if($status == 'New') selected @endif>
                                Nowe
                            </option>

                            <option value="Paid" @if($status == 'Paid') selected @endif>
                                Opłacone
                            </option>

                            <option value="Sent" @if($status == 'Sent') selected @endif>
                                Wysłane
                            </option>

                            <option value="Finished" @if($status == 'Finished') selected @endif>
                                Zakończone
                            </option>

                            <option value="Cancelled" @if($status == 'Cancelled') selected @endif>
                                Anulowane
                            </option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <button class="btn btn-dark w-100 me-2" type="submit">
                            Szukaj
                        </button>

                        <a href="{{ route('orders.index') }}" class="btn btn-secondary w-100">
                            Wyczyść
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($orders->count() == 0)
        <div class="alert alert-info">
            Brak zamówień.
        </div>
    @else
        @foreach($orders as $order)
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Zamówienie #{{ $order->Id }}</strong>

                        <span class="badge {{ $statusClasses[$order->Status] ?? 'bg-secondary' }} ms-2">
                            {{ $statusNames[$order->Status] ?? $order->Status }}
                        </span>
                    </div>

                    <div class="d-flex">
                        <a href="{{ route('orders.edit', $order->Id) }}"
                           class="btn btn-warning btn-sm me-2">
                            Edytuj
                        </a>

                        @if($order->Status == 'Cancelled')
                            <form method="POST"
                                  action="{{ route('orders.restore', $order->Id) }}"
                                  class="me-2"
                                  onsubmit="return confirm('Przywrócić zamówienie?');">
                                @csrf

                                <button class="btn btn-outline-success btn-sm" type="submit">
                                    Przywróć
                                </button>
                            </form>
                        @else
                            <form method="POST"
                                  action="{{ route('orders.cancel', $order->Id) }}"
                                  class="me-2"
                                  onsubmit="return confirm('Anulować zamówienie?');">
                                @csrf

                                <button class="btn btn-outline-danger btn-sm" type="submit">
                                    Anuluj
                                </button>
                            </form>
                        @endif

                        <form method="POST"
                              action="{{ route('orders.delete', $order->Id) }}"
                              onsubmit="return confirm('Ukryć zamówienie?');">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm" type="submit">
                                Ukryj
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <p class="mb-1">
                                <strong>Klient:</strong>
                                {{ $order->CustomerName }}
                            </p>

                            <p class="mb-1">
                                <strong>Email:</strong>
                                {{ $order->CustomerEmail }}
                            </p>

                            <p class="mb-0">
                                <strong>Użytkownik:</strong>
                                {{ $order->user->Name ?? 'Brak' }}
                            </p>
                        </div>

                        <div class="col-md-4">
                            <p class="mb-1">
                                <strong>Adres:</strong>
                                {{ $order->Address }}
                            </p>

                            <p class="mb-0">
                                <strong>Data:</strong>
                                {{ $order->CreationDateTime }}
                            </p>
                        </div>

                        <div class="col-md-4">
                            <p class="mb-1">
                                <strong>Wartość:</strong>
                                {{ number_format($order->TotalPrice, 2) }} zł
                            </p>

                            <p class="mb-0">
                                <strong>Pozycji:</strong>
                                {{ $order->items->count() }}
                            </p>
                        </div>
                    </div>

                    @if($order->items->count() > 0)
                        <table class="table table-bordered table-striped align-middle mb-0">
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
                        </table>
                    @else
                        <div class="alert alert-light border mb-0">
                            Brak pozycji.
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
@endsection