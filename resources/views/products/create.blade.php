@extends('main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Dodaj produkt</h1>

        <a href="{{ route('products.index') }}" class="btn btn-secondary">
            Wróć
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('products.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nazwa produktu</label>
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

                <div class="mb-3">
                    <label class="form-label">Cena</label>
                    <input type="number"
                           step="0.01"
                           name="Price"
                           class="form-control"
                           value="{{ old('Price') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Stan magazynowy</label>
                    <input type="number"
                           name="Stock"
                           class="form-control"
                           value="{{ old('Stock') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategoria</label>
                    <select name="CategoryId" class="form-control">
                        <option value="">-- wybierz kategorię --</option>

                        @foreach($categories as $category)
                            <option value="{{ $category->Id }}"
                                @if(old('CategoryId') == $category->Id) selected @endif>
                                {{ $category->Name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Adres obrazka</label>
                    <input type="text"
                           name="ImageUrl"
                           class="form-control"
                           value="{{ old('ImageUrl') }}">
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input"
                               type="checkbox"
                               name="IsPromoted"
                               value="1"
                               id="IsPromoted"
                               @if(old('IsPromoted')) checked @endif>

                        <label class="form-check-label" for="IsPromoted">
                            Produkt promowany na stronie głównej
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Akcesoria</label>

                    @foreach($accessories as $accessory)
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="Accessories[]"
                                   value="{{ $accessory->Id }}"
                                   id="accessory{{ $accessory->Id }}"
                                   @if(in_array($accessory->Id, old('Accessories', []))) checked @endif>

                            <label class="form-check-label" for="accessory{{ $accessory->Id }}">
                                {{ $accessory->Name }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-success">
                    Zapisz produkt
                </button>
            </form>
        </div>
    </div>
@endsection