@extends('main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Akcesoria</h1>

        <a href="{{ route('accessories.create') }}" class="btn btn-primary">
            Dodaj akcesorium
        </a>
    </div>

    <form method="GET" action="{{ route('accessories.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-10">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Szukaj akcesorium"
                       value="{{ $search }}">
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-dark w-100">
                    Szukaj
                </button>
            </div>
        </div>
    </form>

    @if($accessories->count() == 0)
        <div class="alert alert-info">
            Brak akcesoriów do wyświetlenia.
        </div>
    @else
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nazwa</th>
                <th>Opis</th>
                <th>Cena</th>
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
                        <a href="{{ route('accessories.edit', $accessory->Id) }}"
                           class="btn btn-warning btn-sm">
                            Edytuj
                        </a>

                        <form method="POST"
                              action="{{ route('accessories.delete', $accessory->Id) }}"
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