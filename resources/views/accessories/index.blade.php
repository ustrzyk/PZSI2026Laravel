@extends('main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Akcesoria</h1>

        <a href="{{ route('accessories.create') }}" class="btn btn-primary">
            Dodaj akcesorium
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">Filtry</div>

        <div class="card-body">
            <form method="GET" action="{{ route('accessories.index') }}">
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
                        <a href="{{ route('accessories.index') }}" class="btn btn-secondary w-100">Wyczyść</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($accessories->count() == 0)
        <div class="alert alert-info">Brak akcesoriów.</div>
    @else
        <table class="table table-bordered table-striped align-middle">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nazwa</th>
                <th>Opis</th>
                <th>Cena</th>
                <th>Status</th>
                <th>Akcje</th>
            </tr>
            </thead>

            <tbody>
            @foreach($accessories as $accessory)
                <tr>
                    <td>{{ $accessory->Id }}</td>
                    <td>{{ $accessory->Name }}</td>
                    <td>{{ $accessory->Description }}</td>
                    <td>{{ number_format($accessory->Price, 2) }} zł</td>
                    <td>
                        @if((int)$accessory->IsActive == 1)
                            <span class="badge bg-success">Aktywne</span>
                        @else
                            <span class="badge bg-secondary">Ukryte</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('accessories.edit', $accessory->Id) }}" class="btn btn-warning btn-sm">
                            Edytuj
                        </a>

                        @if((int)$accessory->IsActive == 1)
                            <form method="POST"
                                  action="{{ route('accessories.delete', $accessory->Id) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('Ukryć akcesorium?');">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">
                                    Ukryj
                                </button>
                            </form>
                        @else
                            <form method="POST"
                                  action="{{ route('accessories.restore', $accessory->Id) }}"
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