@extends('main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Produkty</h1>

        <a href="{{ route('products.create') }}" class="btn btn-primary">
            Dodaj produkt
        </a>
    </div>

    <form method="GET" action="{{ route('products.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-10">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Szukaj produktu"
                       value="{{ $search }}">
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-dark w-100">
                    Szukaj
                </button>
            </div>
        </div>
    </form>

    @if($products->count() == 0)
        <div class="alert alert-info">
            Brak produktów do wyświetlenia.
        </div>
    @else
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nazwa</th>
                <th>Kategoria</th>
                <th>Cena</th>
                <th>Stan</th>
                <th>Promowany</th>
                <th>Akcesoria</th>
                <th>Akcje</th>
            </tr>
            </thead>

            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->Id }}</td>
                    <td>{{ $product->Name }}</td>
                    <td>{{ $product->category->Name ?? 'Brak' }}</td>
                    <td>{{ number_format($product->Price, 2) }} zł</td>
                    <td>{{ $product->Stock }}</td>
                    <td>
                        @if((int)$product->IsPromoted == 1)
                            <span class="badge bg-warning text-dark">Tak</span>
                        @else
                            <span class="badge bg-secondary">Nie</span>
                        @endif
                    </td>
                    <td>
                        @if($product->accessories->count() > 0)
                            @foreach($product->accessories as $accessory)
                                <span class="badge bg-secondary">
                                    {{ $accessory->Name }}
                                </span>
                            @endforeach
                        @else
                            Brak
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('products.edit', $product->Id) }}"
                           class="btn btn-warning btn-sm">
                            Edytuj
                        </a>

                        <form method="POST"
                              action="{{ route('products.delete', $product->Id) }}"
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