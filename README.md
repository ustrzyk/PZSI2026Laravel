# PZSI2026Laravel - sklep z drukarkami 3D

Projekt wykonany na przedmiot **Programowanie Zaawansowanych Serwisów Internetowych**.

Aplikacja jest sklepem internetowym z drukarkami 3D, filamentami i akcesoriami.
Projekt został wykonany w frameworku **Laravel** z wykorzystaniem architektury **MVC**.

---

## 1. Technologie

```txt
PHP
Laravel
MySQL / MariaDB
XAMPP
phpMyAdmin
Bootstrap
Blade
Git
```

---

## 2. Baza danych

Nazwa bazy danych:

```txt
pzsi-druk-3d
```

Skrypt SQL:

```txt
database/pzsi-druk-3d.sql
```

Tabele:

```txt
Users
Categories
Products
Accessories
ProductAccessories
Orders
OrderItems
```

Relacje:

```txt
Categories -> Products
Users -> Orders
Orders -> OrderItems
Products -> OrderItems
Products <-> Accessories
```

Relacja wiele-do-wielu między produktami i akcesoriami jest zrobiona przez tabelę:

```txt
ProductAccessories
```

---

## 3. Konfiguracja bazy danych

Przykładowa konfiguracja `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE="pzsi-druk-3d"
DB_USERNAME=root
DB_PASSWORD=
```

Wyczyszczenie cache konfiguracji:

```bash
php artisan config:clear
```

---

## 4. Funkcje użytkownika

```txt
- przeglądanie sklepu,
- wybór kategorii,
- produkty promowane,
- wyszukiwarka produktów,
- szczegóły produktu,
- koszyk,
- zmiana ilości produktów w koszyku,
- składanie zamówień,
- historia zamówień,
- szczegóły zamówienia,
- rejestracja,
- logowanie,
- wylogowanie.
```

---

## 5. Funkcje administratora

```txt
- panel startowy,
- zarządzanie produktami,
- zarządzanie kategoriami,
- zarządzanie akcesoriami,
- zarządzanie użytkownikami,
- zarządzanie zamówieniami,
- edycja pozycji z poziomu zamówienia.
```

Panel startowy administratora:

```txt
/admin
```

Na panelu startowym znajdują się klikalne karty:

```txt
Produkty
Kategorie
Akcesoria
Użytkownicy
Zamówienia
Wartość zamówień
```

Panel startowy ma też szybkie akcje:

```txt
Dodaj produkt
Dodaj kategorię
Dodaj akcesorium
Dodaj użytkownika
```

Techniczna ścieżka CRUD dla pozycji zamówień:

```txt
/order-items
```

---

## 6. Role użytkowników

Role:

```txt
admin
client
```

Nowy użytkownik utworzony przez rejestrację dostaje rolę:

```txt
client
```

Użytkownik startowy `tsaran` ma rolę:

```txt
admin
```

---

## 7. Logowanie

Hasła są zapisywane jako hash.

Mechanizmy Laravel:

```php
Hash::make()
Hash::check()
```

Po zalogowaniu w sesji zapisywane są:

```txt
user_id
user_name
user_role
```

Po zalogowaniu:

```txt
admin  -> panel administratora
client -> strona główna sklepu
```

Wylogowanie przekierowuje na stronę główną sklepu.

---

## 8. Widoki klienta

Adresy:

```txt
/
category/{id}
product/{id}
cart
my-orders
my-orders/{id}
```

---

## 9. Panel administratora

Adresy widoczne w menu administratora:

```txt
/admin
/products
/categories
/accessories
/users
/orders
```

Dodatkowa ścieżka techniczna:

```txt
/order-items
```

Panel administracyjny jest zabezpieczony middleware i dostępny tylko dla roli `admin`.

---

## 10. Ukrywanie i przywracanie

W panelu administratora można ukrywać i przywracać:

```txt
- produkty,
- kategorie,
- akcesoria,
- zamówienia.
```

Użytkowników można:

```txt
- zablokować,
- odblokować.
```

Listy w panelu mają filtr widoczności:

```txt
Aktywne
Ukryte
Wszystkie
```

---

## 11. Statusy zamówień

```txt
New       - Nowe
Paid      - Opłacone
Sent      - Wysłane
Finished  - Zakończone
Cancelled - Anulowane
```

Statusy są wyświetlane po polsku w panelu administratora oraz w widoku klienta.

---

## 12. Zamówienia

Administrator może:

```txt
- filtrować zamówienia,
- zmieniać status,
- edytować pozycje zamówienia,
- anulować zamówienie,
- przywrócić anulowane zamówienie,
- ukryć zamówienie,
- przywrócić ukryte zamówienie.
```

Klient może:

```txt
- przeglądać swoje zamówienia,
- filtrować swoje zamówienia,
- sprawdzać szczegóły zamówienia.
```

---

## 13. Koszyk

Koszyk jest przechowywany w sesji.

Klient może:

```txt
- dodać produkt,
- zwiększyć ilość,
- zmniejszyć ilość,
- usunąć produkt,
- złożyć zamówienie.
```

W górnym menu widoczny jest licznik produktów w koszyku.

---

## 14. Magazyn

Produkty mają pole:

```txt
Stock
```

Produkt bez stanu magazynowego nie może zostać dodany do koszyka.

---

## 15. Szczegóły produktu

Adres:

```txt
/product/{id}
```

Na stronie szczegółów produktu widoczne są:

```txt
- nazwa,
- opis,
- cena,
- stan magazynowy,
- kategoria,
- obrazek,
- informacja o promowaniu,
- pasujące akcesoria.
```

---

## 16. Produkty promowane

Produkty mają pole:

```txt
IsPromoted
```

Wartości:

```txt
IsPromoted = 1 - produkt promowany
IsPromoted = 0 - produkt zwykły
```

---

## 17. Górne menu

Menu zawiera ikonki oraz tekst.

Przykładowe elementy:

```txt
🏠 Start
🛒 Koszyk
📦 Moje zamówienia
⚙️ Panel admina
🔐 Logowanie
📝 Rejestracja
🚪 Wyloguj
```

Dla administratora linki panelu są w rozwijanym menu.

---

## 18. Pole IsActive

Rekordy są ukrywane przez pole:

```txt
IsActive
```

Wartości:

```txt
IsActive = 1
IsActive = 0
```

---

## 19. Struktura katalogów

```txt
app/Models              - modele
app/Http/Controllers    - kontrolery
app/Http/Middleware     - middleware
app/Services            - serwisy
resources/views         - widoki Blade
routes/web.php          - trasy
database                - skrypt SQL
```

---

## 20. Uruchomienie projektu

```bash
cd /c/git/PZSI2026Laravel
composer dump-autoload
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan serve
```

Adres:

```txt
http://127.0.0.1:8000
```

---

## 21. Test

```txt
- strona główna,
- kategorie,
- szczegóły produktu,
- koszyk,
- licznik koszyka,
- logowanie klienta,
- logowanie administratora,
- przekierowanie administratora do panelu,
- dashboard administratora,
- klikalne karty dashboardu,
- szybkie akcje dashboardu,
- Moje zamówienia,
- panel administratora,
- CRUD,
- filtry widoczności,
- ukrywanie i przywracanie,
- blokowanie i odblokowanie użytkownika,
- statusy zamówień,
- anulowanie i przywracanie zamówień.
```
