# PZSI2026Laravel - sklep z drukarkami 3D

Projekt wykonany na przedmiot **Programowanie Zaawansowanych Serwisów Internetowych**.

Aplikacja jest sklepem internetowym z drukarkami 3D, filamentami i akcesoriami.
Projekt został wykonany w frameworku **Laravel** z wykorzystaniem architektury **MVC**.

---

## 1. Technologie

W projekcie wykorzystano:

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

Skrypt SQL znajduje się w pliku:

```txt
database/pzsi-druk-3d.sql
```

W bazie znajdują się tabele:

```txt
Users
Categories
Products
Accessories
ProductAccessories
Orders
OrderItems
```

Projekt zawiera relacje:

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

Przykładowa konfiguracja w pliku `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE="pzsi-druk-3d"
DB_USERNAME=root
DB_PASSWORD=
```

Po zmianie konfiguracji można wyczyścić cache:

```bash
php artisan config:clear
```

---

## 4. Najważniejsze funkcje aplikacji

Użytkownik może:

```txt
- przeglądać sklep,
- wybierać kategorie produktów,
- przeglądać produkty promowane,
- wyszukiwać produkty,
- dodawać produkty do koszyka,
- składać zamówienia,
- przeglądać swoje zamówienia,
- sprawdzać szczegóły swoich zamówień,
- rejestrować się,
- logować się,
- wylogować się.
```

Administrator może zarządzać:

```txt
- produktami,
- kategoriami,
- akcesoriami,
- użytkownikami,
- zamówieniami,
- pozycjami zamówień.
```

---

## 5. Role użytkowników

W projekcie są dwie role:

```txt
admin
client
```

Rola `admin` ma dostęp do panelu administracyjnego.

Rola `client` to zwykły klient sklepu.

Nowy użytkownik utworzony przez rejestrację dostaje automatycznie rolę:

```txt
client
```

Użytkownik startowy `tsaran` ma rolę:

```txt
admin
```

---

## 6. Logowanie i bezpieczeństwo

Hasła użytkowników są zapisywane w bazie jako hash.

Do hashowania haseł używany jest mechanizm Laravel:

```php
Hash::make()
```

Podczas logowania hasło jest sprawdzane przez:

```php
Hash::check()
```

Po zalogowaniu dane użytkownika są zapisane w sesji:

```txt
user_id
user_name
user_role
```

Panel administracyjny jest zabezpieczony middleware i dostępny tylko dla użytkownika z rolą `admin`.

---

## 7. Widoki klienta

Strona klienta zawiera:

```txt
- stronę główną sklepu,
- kafelki kategorii,
- produkty promowane,
- karuzelę produktów promowanych,
- stronę wybranej kategorii,
- wyszukiwarkę produktów,
- koszyk,
- historię zamówień klienta.
```

Główne adresy klienta:

```txt
/
category/{id}
cart
my-orders
my-orders/{id}
```

---

## 8. Panel administratora

Panel administratora zawiera operacje CRUD dla:

```txt
products
categories
accessories
users
orders
order-items
```

Adresy panelu administracyjnego:

```txt
/products
/categories
/accessories
/users
/orders
/order-items
```

Zwykły klient nie ma dostępu do tych stron.

---

## 9. Koszyk i zamówienia

Koszyk jest przechowywany w sesji.

Klient może:

```txt
- dodać produkt do koszyka,
- usunąć produkt z koszyka,
- złożyć zamówienie,
- sprawdzić swoje zamówienia.
```

Po złożeniu zamówienia aplikacja tworzy rekord w tabeli:

```txt
Orders
```

oraz pozycje zamówienia w tabeli:

```txt
OrderItems
```

---

## 10. Obsługa magazynu

Produkty mają pole:

```txt
Stock
```

Pole `Stock` oznacza stan magazynowy produktu.

Aplikacja sprawdza stan magazynowy podczas dodawania produktu do koszyka i podczas składania zamówienia.

Jeżeli produkt ma:

```txt
Stock = 0
```

to klient widzi komunikat:

```txt
Brak w magazynie
```

i nie może dodać produktu do koszyka.

Po złożeniu zamówienia stan magazynowy produktu jest automatycznie zmniejszany.

---

## 11. Produkty promowane

Produkty mają pole:

```txt
IsPromoted
```

Pole oznacza, czy produkt ma być wyświetlany na stronie głównej jako promowany.

```txt
IsPromoted = 1 - produkt promowany
IsPromoted = 0 - produkt zwykły
```

Dzięki temu strona główna nie pokazuje wszystkich produktów, tylko wybrane produkty promowane.

---

## 12. Usuwanie rekordów

W projekcie nie usuwam rekordów fizycznie z bazy.

Zamiast tego ustawiane jest:

```txt
IsActive = 0
```

Dzięki temu rekord zostaje w bazie danych, ale nie jest wyświetlany w aplikacji.

---

## 13. Struktura katalogów

Najważniejsze katalogi:

```txt
app/Models              - modele
app/Http/Controllers    - kontrolery
app/Http/Middleware     - middleware
app/Services            - serwisy z logiką aplikacji
resources/views         - widoki Blade
routes/web.php          - trasy aplikacji
database                - skrypt SQL bazy danych
```

---

## 14. Uruchomienie projektu

Wejście do katalogu projektu:

```bash
cd /c/git/PZSI2026Laravel
```

Odświeżenie autoload:

```bash
composer dump-autoload
```

Wyczyszczenie cache:

```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

Uruchomienie projektu:

```bash
php artisan serve
```

Adres aplikacji:

```txt
http://127.0.0.1:8000
```

---

## 15. Testowe sprawdzenie aplikacji

Warto sprawdzić:

```txt
- czy działa strona główna,
- czy działają kategorie,
- czy działają produkty promowane,
- czy działa koszyk,
- czy nie można kupić produktu bez stanu magazynowego,
- czy po zakupie zmniejsza się Stock,
- czy klient widzi tylko swoje zamówienia,
- czy klient nie ma dostępu do panelu admina,
- czy admin ma dostęp do panelu admina,
- czy działają operacje CRUD.
```

---

## 16. Najważniejsze elementy do obrony

W projekcie warto umieć wyjaśnić:

```txt
- strukturę bazy danych,
- relacje między tabelami,
- relację wiele-do-wielu,
- działanie MVC,
- działanie modeli, kontrolerów i serwisów,
- logowanie i hashowanie haseł,
- role admin/client,
- middleware,
- koszyk w sesji,
- składanie zamówienia,
- historię zamówień klienta,
- obsługę magazynu,
- produkty promowane,
- dezaktywację przez IsActive.
```
