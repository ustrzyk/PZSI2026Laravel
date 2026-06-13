@extends('main')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h1 class="mb-4">Logowanie</h1>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('auth.login.post') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Login</label>
                            <input type="text"
                                   name="Email"
                                   class="form-control"
                                   value="{{ old('Email') }}"
                                   placeholder="Login">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Hasło</label>
                            <input type="password"
                                   name="Password"
                                   class="form-control"
                                   placeholder="Hasło">
                        </div>

                        <button type="submit" class="btn btn-dark w-100">
                            Zaloguj
                        </button>
                    </form>
                </div>
            </div>

            <p class="mt-3">
                Nie masz konta?
                <a href="{{ route('auth.register') }}">Zarejestruj się</a>
            </p>
        </div>
    </div>
@endsection