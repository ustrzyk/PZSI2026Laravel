@extends('main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Produkty</h1>

        <a href="{{ route('products.create') }}" class="btn btn-primary">
            Dodaj produkt
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">Filtry</div>

        <div class="card-body">
            <form method="GET" action="{{ route('products.index') }}">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Szukaj</label>
                        <input type="text" name="search" class="form-control" value="{{ $search }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Widoczność</label>
                        <select name="visibility" class="form-control">
                            <option value="active" @if($visibility == 'active') selected @endif>Aktywne</option>
                            <option value="hidden" @if($visibility == 'hidden') selected @endif>Ukryte</option>
                            <option value="all" @if($visibility == 'all') selected @endif>Wszystkie</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <button class="btn btn-dark w-100 me-2" type="submit">Szukaj</button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary w-100">Wyczyść</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($products->count() == 0)
        <div class="alert alert-info">Brak produktów.</div>
    @else
        <table class="table table-bordered table-striped align-middle">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nazwa</th>
                <th>Kategoria</th>
                <th>Cena</th>
                <th>Stan</th>
                <th>Status</th>
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
                        @if((int)$product->IsActive == 1)
                            <span class="badge bg-success">Aktywny</span>
                        @else
                            <span class="badge bg-secondary">Ukryty</span>
                        @endif
                    </td>
                    <td>
                        @if((int)$product->IsPromoted == 1)
                            Tak
                        @else
                            Nie
                        @endif
                    </td>
                    <td>
                        @if($product->accessories->count() > 0)
                            @foreach($product->accessories as $accessory)
                                <span class="badge bg-secondary">{{ $accessory->Name }}</span>
                            @endforeach
                        @else
                            Brak
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('products.edit', $product->Id) }}" class="btn btn-warning btn-sm">
                            Edytuj
                        </a>

                        @if((int)$product->IsActive == 1)
                            <form method="POST"
                                  action="{{ route('products.delete', $product->Id) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('Ukryć produkt?');">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">
                                    Ukryj
                                </button>
                            </form>
                        @else
                            <form method="POST"
                                  action="{{ route('products.restore', $product->Id) }}"
                                  class="d-inline">
                                @csrf

                                <button type="submit" class="btn btn-success btn-sm">
                                    Przywróć
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection