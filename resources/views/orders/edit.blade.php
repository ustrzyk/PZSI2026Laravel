@extends('main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Edytuj zamówienie #{{ $order->Id }}</h1>

        <a href="{{ route('orders.index') }}" class="btn btn-secondary">
            Wróć
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            Dane zamówienia
        </div>

        <div class="card-body">
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

            <p class="mb-1">
                <strong>Wartość:</strong>
                {{ number_format($order->TotalPrice, 2) }} zł
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Zmiana statusu
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('orders.update', $order->Id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Status zamówienia</label>

                    <select name="Status" class="form-control">
                        <option value="New" @if(old('Status', $order->Status) == 'New') selected @endif>
                            Nowe
                        </option>

                        <option value="Paid" @if(old('Status', $order->Status) == 'Paid') selected @endif>
                            Opłacone
                        </option>

                        <option value="Sent" @if(old('Status', $order->Status) == 'Sent') selected @endif>
                            Wysłane
                        </option>

                        <option value="Finished" @if(old('Status', $order->Status) == 'Finished') selected @endif>
                            Zakończone
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">
                    Zapisz status
                </button>
            </form>
        </div>
    </div>
@endsection