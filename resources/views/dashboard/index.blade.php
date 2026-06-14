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
        <h1>Panel administratora</h1>

        <a href="{{ route('orders.index') }}" class="btn btn-primary">
            Zamówienia
        </a>
    </div>

    <div class="row mb-4">
        <div class="col-md-2 mb-3">
            <a href="{{ route('products.index') }}" class="text-decoration-none text-dark">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <div class="fs-3">🖨️</div>
                        <h3>{{ $statistics['productsCount'] }}</h3>
                        <div>Produkty</div>
                        <small class="text-muted">Przejdź</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-2 mb-3">
            <a href="{{ route('categories.index') }}" class="text-decoration-none text-dark">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <div class="fs-3">🗂️</div>
                        <h3>{{ $statistics['categoriesCount'] }}</h3>
                        <div>Kategorie</div>
                        <small class="text-muted">Przejdź</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-2 mb-3">
            <a href="{{ route('accessories.index') }}" class="text-decoration-none text-dark">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <div class="fs-3">🔧</div>
                        <h3>{{ $statistics['accessoriesCount'] }}</h3>
                        <div>Akcesoria</div>
                        <small class="text-muted">Przejdź</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-2 mb-3">
            <a href="{{ route('users.index') }}" class="text-decoration-none text-dark">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <div class="fs-3">👤</div>
                        <h3>{{ $statistics['usersCount'] }}</h3>
                        <div>Użytkownicy</div>
                        <small class="text-muted">Przejdź</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-2 mb-3">
            <a href="{{ route('orders.index') }}" class="text-decoration-none text-dark">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <div class="fs-3">🧾</div>
                        <h3>{{ $statistics['ordersCount'] }}</h3>
                        <div>Zamówienia</div>
                        <small class="text-muted">Przejdź</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-2 mb-3">
            <a href="{{ route('orders.index') }}" class="text-decoration-none text-dark">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <div class="fs-3">💰</div>
                        <h5>{{ number_format($statistics['ordersTotal'], 2) }} zł</h5>
                        <div>Wartość</div>
                        <small class="text-muted">Zamówienia</small>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            Szybkie akcje
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-2">
                    <a href="{{ route('products.create') }}" class="btn btn-outline-primary w-100">
                        Dodaj produkt
                    </a>
                </div>

                <div class="col-md-3 mb-2">
                    <a href="{{ route('categories.create') }}" class="btn btn-outline-primary w-100">
                        Dodaj kategorię
                    </a>
                </div>

                <div class="col-md-3 mb-2">
                    <a href="{{ route('accessories.create') }}" class="btn btn-outline-primary w-100">
                        Dodaj akcesorium
                    </a>
                </div>

                <div class="col-md-3 mb-2">
                    <a href="{{ route('users.create') }}" class="btn btn-outline-primary w-100">
                        Dodaj użytkownika
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Ostatnie zamówienia</span>

                    <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary">
                        Wszystkie
                    </a>
                </div>

                <div class="card-body">
                    @if($statistics['latestOrders']->count() == 0)
                        <div class="alert alert-info mb-0">
                            Brak zamówień.
                        </div>
                    @else
                        <table class="table table-bordered table-striped align-middle mb-0">
                            <thead>
                            <tr>
                                <th>Numer</th>
                                <th>Klient</th>
                                <th>Status</th>
                                <th>Wartość</th>
                                <th>Akcja</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($statistics['latestOrders'] as $order)
                                <tr>
                                    <td>
                                        #{{ $order->Id }}
                                    </td>

                                    <td>
                                        {{ $order->CustomerName }}
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
                                        <a href="{{ route('orders.edit', $order->Id) }}"
                                           class="btn btn-warning btn-sm">
                                            Edytuj
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-5 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Niski stan</span>

                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-primary">
                        Produkty
                    </a>
                </div>

                <div class="card-body">
                    @if($statistics['lowStockProducts']->count() == 0)
                        <div class="alert alert-success mb-0">
                            Brak produktów.
                        </div>
                    @else
                        <table class="table table-bordered table-striped align-middle mb-0">
                            <thead>
                            <tr>
                                <th>Produkt</th>
                                <th>Kategoria</th>
                                <th>Stan</th>
                                <th>Akcja</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($statistics['lowStockProducts'] as $product)
                                <tr>
                                    <td>
                                        {{ $product->Name }}
                                    </td>

                                    <td>
                                        {{ $product->category->Name ?? 'Brak' }}
                                    </td>

                                    <td>
                                        {{ $product->Stock }}
                                    </td>

                                    <td>
                                        <a href="{{ route('products.edit', $product->Id) }}"
                                           class="btn btn-warning btn-sm">
                                            Edytuj
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection