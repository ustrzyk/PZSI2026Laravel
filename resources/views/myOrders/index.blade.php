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
        <h1>Moje zamówienia</h1>

        <a href="{{ route('shop.index') }}" class="btn btn-secondary">
            Wróć do sklepu
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            Filtry
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('my-orders.index') }}">
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label class="form-label">Szukaj</label>

                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Numer, adres, status..."
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
                        <button type="submit" class="btn btn-dark w-100 me-2">
                            Szukaj
                        </button>

                        <a href="{{ route('my-orders.index') }}" class="btn btn-secondary w-100">
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
        <table class="table table-bordered table-striped align-middle">
            <thead>
            <tr>
                <th>Numer</th>
                <th>Data</th>
                <th>Status</th>
                <th>Wartość</th>
                <th>Pozycji</th>
                <th>Akcje</th>
            </tr>
            </thead>

            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>
                        #{{ $order->Id }}
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($order->CreationDateTime)->format('d.m.Y H:i') }}
                    </td>

                    <td>
                        <span class="badge {{ $statusClasses[$order->Status] ?? 'bg-secondary' }}">
                            {{ $statusNames[$order->Status] ?? $order->Status }}
                        </span>
                    </td>

                    <td>
                        {{ number_format($order->TotalPrice, 2) }} zł
                    </td>

                    <td>
                        {{ $order->items->count() }}
                    </td>

                    <td>
                        <a href="{{ route('my-orders.show', $order->Id) }}" class="btn btn-info btn-sm">
                            Szczegóły
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    @endif
@endsection