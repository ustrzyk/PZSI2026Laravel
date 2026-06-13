@extends('main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Pozycje zamówień</h1>

        <a href="{{ route('order-items.create') }}" class="btn btn-primary">
            Dodaj pozycję
        </a>
    </div>

    <form method="GET" action="{{ route('order-items.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-10">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Szukaj po nazwie produktu"
                       value="{{ $search }}">
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-dark w-100">
                    Szukaj
                </button>
            </div>
        </div>
    </form>

    @if($items->count() == 0)
        <div class="alert alert-info">
            Brak pozycji zamówień do wyświetlenia.
        </div>
    @else
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Zamówienie</th>
                <th>Klient</th>
                <th>Produkt</th>
                <th>Ilość</th>
                <th>Cena</th>
                <th>Razem</th>
                <th>Akcje</th>
            </tr>
            </thead>

            <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->Id }}</td>

                    <td>
                        #{{ $item->OrderId }}
                    </td>

                    <td>
                        {{ $item->order->CustomerName ?? 'Brak' }}
                    </td>

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

                    <td>
                        <a href="{{ route('order-items.edit', $item->Id) }}"
                           class="btn btn-warning btn-sm">
                            Edytuj
                        </a>

                        <form method="POST"
                              action="{{ route('order-items.delete', $item->Id) }}"
                              class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm">
                                Dezaktywuj
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection