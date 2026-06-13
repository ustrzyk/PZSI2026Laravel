@extends('main')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="mb-4">Rejestracja</h1>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('auth.register.post') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nazwa użytkownika</label>
                            <input type="text"
                                   name="Name"
                                   class="form-control"
                                   value="{{ old('Name') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Login / email</label>
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

                        <button type="submit" class="btn btn-dark w-100">
                            Zarejestruj
                        </button>
                    </form>
                </div>
            </div>

            <p class="mt-3">
                Masz już konto?
                <a href="{{ route('auth.login') }}">Zaloguj się</a>
            </p>
        </div>
    </div>
@endsection