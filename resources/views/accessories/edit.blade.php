@extends('main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Edytuj akcesorium</h1>

        <a href="{{ route('accessories.index') }}" class="btn btn-secondary">
            Wróć
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('accessories.update', $accessory->Id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nazwa akcesorium</label>
                    <input type="text"
                           name="Name"
                           class="form-control"
                           value="{{ old('Name', $accessory->Name) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Opis</label>
                    <textarea name="Description"
                              class="form-control"
                              rows="4">{{ old('Description', $accessory->Description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cena</label>
                    <input type="number"
                           step="0.01"
                           name="Price"
                           class="form-control"
                           value="{{ old('Price', $accessory->Price) }}">
                </div>

                <button type="submit" class="btn btn-success">
                    Zapisz zmiany
                </button>
            </form>
        </div>
    </div>
@endsection