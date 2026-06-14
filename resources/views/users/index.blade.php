@extends('main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Użytkownicy</h1>

        <a href="{{ route('users.create') }}" class="btn btn-primary">
            Dodaj użytkownika
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">Filtry</div>

        <div class="card-body">
            <form method="GET" action="{{ route('users.index') }}">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Szukaj</label>
                        <input type="text" name="search" class="form-control" value="{{ $search }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Widoczność</label>
                        <select name="visibility" class="form-control">
                            <option value="active" @if($visibility == 'active') selected @endif>Aktywni</option>
                            <option value="hidden" @if($visibility == 'hidden') selected @endif>Zablokowani</option>
                            <option value="all" @if($visibility == 'all') selected @endif>Wszyscy</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <button class="btn btn-dark w-100 me-2" type="submit">Szukaj</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary w-100">Wyczyść</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($users->count() == 0)
        <div class="alert alert-info">Brak użytkowników.</div>
    @else
        <table class="table table-bordered table-striped align-middle">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nazwa</th>
                <th>Login</th>
                <th>Rola</th>
                <th>Status</th>
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
                            Admin
                        @else
                            Klient
                        @endif
                    </td>
                    <td>
                        @if((int)$user->IsActive == 1)
                            <span class="badge bg-success">Aktywny</span>
                        @else
                            <span class="badge bg-secondary">Zablokowany</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('users.edit', $user->Id) }}" class="btn btn-warning btn-sm">
                            Edytuj
                        </a>

                        @if((int)$user->IsActive == 1)
                            <form method="POST"
                                  action="{{ route('users.delete', $user->Id) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('Zablokować użytkownika?');">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        @if(session('user_id') == $user->Id) disabled @endif>
                                    Zablokuj
                                </button>
                            </form>
                        @else
                            <form method="POST"
                                  action="{{ route('users.restore', $user->Id) }}"
                                  class="d-inline">
                                @csrf

                                <button type="submit" class="btn btn-success btn-sm">
                                    Odblokuj
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