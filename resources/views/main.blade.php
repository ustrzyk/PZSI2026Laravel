<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Sklep 3D TSaran</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap daje mi szybki wygląd strony --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
@php
    $cartCount = array_sum(session('cart', []));
@endphp

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('shop.index') }}">
            🖨️ Sklep 3D
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('shop.index') ? 'active fw-bold' : '' }}"
                       href="{{ route('shop.index') }}">
                        🏠 Start
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('cart.index') ? 'active fw-bold' : '' }}"
                       href="{{ route('cart.index') }}">
                        🛒 Koszyk

                        @if($cartCount > 0)
                            <span class="badge rounded-pill bg-warning text-dark ms-1">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                </li>

                @if(session('user_id'))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('my-orders.*') ? 'active fw-bold' : '' }}"
                           href="{{ route('my-orders.index') }}">
                            📦 Moje zamówienia
                        </a>
                    </li>
                @endif

                @if(session('user_role') === 'admin')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle
                            @if(
                                request()->routeIs('dashboard.*') ||
                                request()->routeIs('products.*') ||
                                request()->routeIs('categories.*') ||
                                request()->routeIs('accessories.*') ||
                                request()->routeIs('orders.*') ||
                                request()->routeIs('users.*') ||
                                request()->routeIs('order-items.*')
                            )
                                active fw-bold
                            @endif"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown">
                            ⚙️ Panel admina
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('dashboard.*') ? 'active' : '' }}"
                                   href="{{ route('dashboard.index') }}">
                                    📊 Panel
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ request()->routeIs('products.*') ? 'active' : '' }}"
                                   href="{{ route('products.index') }}">
                                    🖨️ Produkty
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ request()->routeIs('categories.*') ? 'active' : '' }}"
                                   href="{{ route('categories.index') }}">
                                    🗂️ Kategorie
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ request()->routeIs('accessories.*') ? 'active' : '' }}"
                                   href="{{ route('accessories.index') }}">
                                    🔧 Akcesoria
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ request()->routeIs('orders.*') ? 'active' : '' }}"
                                   href="{{ route('orders.index') }}">
                                    🧾 Zamówienia
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ request()->routeIs('users.*') ? 'active' : '' }}"
                                   href="{{ route('users.index') }}">
                                    👤 Użytkownicy
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ request()->routeIs('order-items.*') ? 'active' : '' }}"
                                   href="{{ route('order-items.index') }}">
                                    📋 Pozycje zamówień
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>

            <ul class="navbar-nav align-items-lg-center">
                @if(session('user_id'))
                    <li class="nav-item">
                        <span class="nav-link">
                            👋 {{ session('user_name') }}

                            @if(session('user_role') === 'admin')
                                <span class="badge bg-warning text-dark">admin</span>
                            @else
                                <span class="badge bg-info text-dark">klient</span>
                            @endif
                        </span>
                    </li>

                    <li class="nav-item">
                        <form method="POST" action="{{ route('auth.logout') }}">
                            @csrf

                            <button class="btn btn-outline-light btn-sm ms-lg-2" type="submit">
                                🚪 Wyloguj
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('auth.login') ? 'active fw-bold' : '' }}"
                           href="{{ route('auth.login') }}">
                            🔐 Logowanie
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('auth.register') ? 'active fw-bold' : '' }}"
                           href="{{ route('auth.register') }}">
                            📝 Rejestracja
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<main class="container flex-grow-1">
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

<footer class="bg-dark text-light mt-5 py-3">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            TSaran - projekt Laravel PZSI
        </div>

        <div>
            Data i godzina: {{ now()->format('d.m.Y H:i') }}
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>