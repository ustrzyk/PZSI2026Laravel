@extends('main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Kategorie</h1>

        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            Dodaj kategorię
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">Filtry</div>

        <div class="card-body">
            <form method="GET" action="{{ route('categories.index') }}">
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
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary w-100">Wyczyść</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($categories->count() == 0)
        <div class="alert alert-info">Brak kategorii.</div>
    @else
        <table class="table table-bordered table-striped align-middle">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nazwa</th>
                <th>Opis</th>
                <th>Status</th>
                <th>Akcje</th>
            </tr>
            </thead>

            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->Id }}</td>
                    <td>{{ $category->Name }}</td>
                    <td>{{ $category->Description }}</td>
                    <td>
                        @if((int)$category->IsActive == 1)
                            <span class="badge bg-success">Aktywna</span>
                        @else
                            <span class="badge bg-secondary">Ukryta</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('categories.edit', $category->Id) }}" class="btn btn-warning btn-sm">
                            Edytuj
                        </a>

                        @if((int)$category->IsActive == 1)
                            <form method="POST"
                                  action="{{ route('categories.delete', $category->Id) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('Ukryć kategorię?');">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">
                                    Ukryj
                                </button>
                            </form>
                        @else
                            <form method="POST"
                                  action="{{ route('categories.restore', $category->Id) }}"
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