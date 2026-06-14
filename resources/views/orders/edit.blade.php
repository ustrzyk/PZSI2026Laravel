@extends('main')

@section('content')
    @php
        $statusNames = [
            'New' => 'Nowe',
            'Paid' => 'Opłacone',
            'Sent' => 'Wysłane',
            'Finished' => 'Zakończone',
        ];
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Edytuj zamówienie #{{ $order->Id }}</h1>
        </div>

        <a href="{{ route('orders.index') }}" class="btn btn-secondary">
            Wróć do zamówień
        </a>
    </div>

    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    Dane zamówienia
                </div>

                <div class="card-body">
                    <p>
                        <strong>Klient:</strong>
                        {{ $order->CustomerName }}
                    </p>

                    <p>
                        <strong>Email / login kontaktowy:</strong>
                        {{ $order->CustomerEmail }}
                    </p>

                    <p>
                        <strong>Adres:</strong>
                        {{ $order->Address }}
                    </p>

                    <p>
                        <strong>Wartość:</strong>
                        {{ number_format($order->TotalPrice, 2) }} zł
                    </p>

                    <p>
                        <strong>Aktualny status:</strong>
                        {{ $statusNames[$order->Status] ?? $order->Status }}
                    </p>

                    <p>
                        <strong>Data utworzenia:</strong>
                        {{ $order->CreationDateTime }}
                    </p>

                    <p class="mb-0">
                        <strong>Ostatnia edycja:</strong>
                        {{ $order->EditDateTime }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-7 mb-4">
            <div class="card h-100">
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
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            Pozycje zamówienia
        </div>

        <div class="card-body">
            @if($order->items->count() == 0)
                <div class="alert alert-info mb-0">
                    Brak aktywnych pozycji.
                </div>
            @else
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                    <tr>
                        <th>Produkt</th>
                        <th>Kategoria</th>
                        <th>Cena</th>
                        <th>Ilość</th>
                        <th>Stan</th>
                        <th>Razem</th>
                        <th>Akcje</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>
                                <strong>
                                    {{ $item->product->Name ?? 'Brak produktu' }}
                                </strong>

                                @if($item->product)
                                    <div class="mt-2">
                                        <a href="{{ route('shop.show', $item->product->Id) }}"
                                           class="btn btn-info btn-sm">
                                            Szczegóły
                                        </a>
                                    </div>
                                @endif
                            </td>

                            <td>
                                {{ $item->product->category->Name ?? 'Brak kategorii' }}
                            </td>

                            <td>
                                {{ number_format($item->Price, 2) }} zł
                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <form method="POST"
                                          action="{{ route('orders.items.decrease', [$order->Id, $item->Id]) }}">
                                        @csrf

                                        <button type="submit" class="btn btn-outline-secondary btn-sm">
                                            -
                                        </button>
                                    </form>

                                    <span class="mx-3">
                                        {{ $item->Quantity }}
                                    </span>

                                    @if($item->product && $item->product->Stock > 0)
                                        <form method="POST"
                                              action="{{ route('orders.items.increase', [$order->Id, $item->Id]) }}">
                                            @csrf

                                            <button type="submit" class="btn btn-outline-secondary btn-sm">
                                                +
                                            </button>
                                        </form>
                                    @else
                                        <button type="button" class="btn btn-outline-secondary btn-sm" disabled>
                                            +
                                        </button>
                                    @endif
                                </div>
                            </td>

                            <td>
                                @if($item->product)
                                    {{ $item->product->Stock }} szt.
                                @else
                                    Brak produktu
                                @endif
                            </td>

                            <td>
                                {{ number_format($item->Price * $item->Quantity, 2) }} zł
                            </td>

                            <td>
                                <form method="POST"
                                      action="{{ route('orders.items.delete', [$order->Id, $item->Id]) }}"
                                      onsubmit="return confirm('Czy na pewno usunąć tę pozycję z zamówienia?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Usuń
                                    </button>
                                </form>
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

    <div class="card">
        <div class="card-header">
            Dodaj produkt
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('orders.items.add', $order->Id) }}">
                @csrf

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Produkt</label>

                        <select name="ProductId" class="form-control">
                            <option value="">Wybierz produkt</option>

                            @foreach($products as $product)
                                <option value="{{ $product->Id }}"
                                    @if(old('ProductId') == $product->Id) selected @endif
                                    @if($product->Stock <= 0) disabled @endif>
                                    {{ $product->Name }}
                                    | {{ $product->category->Name ?? 'Brak kategorii' }}
                                    | {{ number_format($product->Price, 2) }} zł
                                    | stan: {{ $product->Stock }} szt.
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label class="form-label">Ilość</label>

                        <input type="number"
                               name="Quantity"
                               class="form-control"
                               min="1"
                               value="{{ old('Quantity', 1) }}">
                    </div>

                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100">
                            Dodaj
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection