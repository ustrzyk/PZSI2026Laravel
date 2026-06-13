@extends('main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Moje zamówienia</h1>
            <p class="text-muted">
                Tutaj widzisz historię swoich zamówień złożonych w sklepie.
            </p>
        </div>

        <a href="{{ route('shop.index') }}" class="btn btn-secondary">
            Wróć do sklepu
        </a>
    </div>

    <form method="GET" action="{{ route('my-orders.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-10">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Szukaj po numerze, statusie, danych klienta lub adresie"
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
            Nie masz jeszcze żadnych zamówień.
        </div>
    @else
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Numer</th>
                <th>Data</th>
                <th>Status</th>
                <th>Wartość</th>
                <th>Akcje</th>
            </tr>
            </thead>

            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>#{{ $order->Id }}</td>

                    <td>
                        {{ \Carbon\Carbon::parse($order->CreationDateTime)->format('d.m.Y H:i') }}
                    </td>

                    <td>
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
                    </td>

                    <td>
                        {{ number_format($order->TotalPrice, 2) }} zł
                    </td>

                    <td>
                        <a href="{{ route('my-orders.show', $order->Id) }}"
                           class="btn btn-info btn-sm">
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