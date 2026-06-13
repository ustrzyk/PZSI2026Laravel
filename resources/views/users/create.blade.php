@extends('main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Dodaj użytkownika</h1>

        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            Wróć
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nazwa użytkownika</label>
                    <input type="text"
                           name="Name"
                           class="form-control"
                           value="{{ old('Name') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Login</label>
                    <input type="text"
                           name="Email"
                           class="form-control"
                           value="{{ old('Email') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Hasło</label>
                    <input type="password"
                           name="Password"
                           class="form-control">
                </div>

                <button type="submit" class="btn btn-success">
                    Zapisz użytkownika
                </button>
            </form>
        </div>
    </div>
@endsection