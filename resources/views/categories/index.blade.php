@extends('main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Kategorie</h1>

        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            Dodaj kategorię
        </a>
    </div>

    <form method="GET" action="{{ route('categories.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-10">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Szukaj kategorii"
                       value="{{ $search }}">
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-dark w-100">
                    Szukaj
                </button>
            </div>
        </div>
    </form>

    @if($categories->count() == 0)
        <div class="alert alert-info">
            Brak kategorii do wyświetlenia.
        </div>
    @else
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nazwa</th>
                <th>Opis</th>
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
                        <a href="{{ route('categories.edit', $category->Id) }}"
                           class="btn btn-warning btn-sm">
                            Edytuj
                        </a>

                        <form method="POST"
                              action="{{ route('categories.delete', $category->Id) }}"
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