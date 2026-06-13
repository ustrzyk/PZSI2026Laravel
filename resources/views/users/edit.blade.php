@extends('main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Edytuj użytkownika</h1>

        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            Wróć
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('users.update', $user->Id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nazwa użytkownika</label>
                    <input type="text"
                           name="Name"
                           class="form-control"
                           value="{{ old('Name', $user->Name) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Login</label>
                    <input type="text"
                           name="Email"
                           class="form-control"
                           value="{{ old('Email', $user->Email) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Rola</label>

                    <select name="Role" class="form-control">
                        <option value="client" @if(old('Role', $user->Role) == 'client') selected @endif>
                            Klient
                        </option>

                        <option value="admin" @if(old('Role', $user->Role) == 'admin') selected @endif>
                            Admin
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nowe hasło</label>
                    <input type="password"
                           name="Password"
                           class="form-control">
                    <div class="form-text">
                        Zostaw puste, gdy hasło ma zostać bez zmian.
                    </div>
                </div>

                <button type="submit" class="btn btn-success">
                    Zapisz zmiany
                </button>
            </form>
        </div>
    </div>
@endsection