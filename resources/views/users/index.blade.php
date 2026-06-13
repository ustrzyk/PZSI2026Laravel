@extends('main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Użytkownicy</h1>

        <a href="{{ route('users.create') }}" class="btn btn-primary">
            Dodaj użytkownika
        </a>
    </div>

    <form method="GET" action="{{ route('users.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-10">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Szukaj użytkownika"
                       value="{{ $search }}">
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-dark w-100">
                    Szukaj
                </button>
            </div>
        </div>
    </form>

    @if($users->count() == 0)
        <div class="alert alert-info">
            Brak użytkowników do wyświetlenia.
        </div>
    @else
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nazwa</th>
                <th>Login</th>
                <th>Rola</th>
                <th>Akcje</th>
            </tr>
            </thead>

            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->Id }}</td>
                    <td>{{ $user->Name }}</td>
                    <td>{{ $user->Email }}</td>
                    <td>
                        @if($user->Role == 'admin')
                            <span class="badge bg-danger">Admin</span>
                        @else
                            <span class="badge bg-secondary">Klient</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('users.edit', $user->Id) }}"
                           class="btn btn-warning btn-sm">
                            Edytuj
                        </a>

                        <form method="POST"
                              action="{{ route('users.delete', $user->Id) }}"
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