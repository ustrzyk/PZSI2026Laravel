@extends('main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Dodaj kategorię</h1>

        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            Wróć
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('categories.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nazwa kategorii</label>
                    <input type="text"
                           name="Name"
                           class="form-control"
                           value="{{ old('Name') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Opis</label>
                    <textarea name="Description"
                              class="form-control"
                              rows="4">{{ old('Description') }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">
                    Zapisz kategorię
                </button>
            </form>
        </div>
    </div>
@endsection