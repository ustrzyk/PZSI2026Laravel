<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Sklep 3D</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap daje mi szybki wygląd strony --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('shop.index') }}">Sklep 3D</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('shop.index') }}">Start</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cart.index') }}">Koszyk</a>
                </li>

                @if(session('user_role') === 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Produkty</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categories.index') }}">Kategorie</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('accessories.index') }}">Akcesoria</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.index') }}">Zamówienia</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">Użytkownicy</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('order-items.index') }}">Pozycje zamówień</a>
                    </li>
                @endif
            </ul>

            <ul class="navbar-nav">
                @if(session('user_id'))
                    <li class="nav-item">
                        <span class="nav-link">
                            Zalogowany: {{ session('user_name') }}
                            @if(session('user_role') === 'admin')
                                (admin)
                            @else
                                (klient)
                            @endif
                        </span>
                    </li>

                    <li class="nav-item">
                        <form method="POST" action="{{ route('auth.logout') }}">
                            @csrf
                            <button class="btn btn-outline-light btn-sm mt-1" type="submit">
                                Wyloguj
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.login') }}">Logowanie</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.register') }}">Rejestracja</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<main class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Wystąpił błąd:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>