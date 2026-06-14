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
- sprawdzać szczegóły produktu,
- dodawać produkty do koszyka,
- zwiększać i zmniejszać ilość produktów w koszyku,
- usuwać produkty z koszyka,
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
- szczegóły produktu,
- wyszukiwarkę produktów,
- koszyk,
- historię zamówień klienta,
- szczegóły zamówienia klienta.
```

Główne adresy klienta:

```txt
/
category/{id}
product/{id}
cart
my-orders
my-orders/{id}
```

---

## 8. Panel administratora

Panel administratora zawiera:

```txt
- panel startowy,
- produkty,
- kategorie,
- akcesoria,
- użytkowników,
- zamówienia,
- pozycje zamówień.
```

Adres panelu startowego:

```txt
/admin
```

Pozostałe adresy panelu administracyjnego:

```txt
/products
/categories
/accessories
/users
/orders
/order-items
```

W panelu startowym znajdują się:

```txt
- liczba produktów,
- liczba kategorii,
- liczba akcesoriów,
- liczba użytkowników,
- liczba zamówień,
- wartość zamówień,
- ostatnie zamówienia,
- produkty z niskim stanem.
```

W górnym menu panel administratora jest pokazany jako rozwijana lista.

---

## 9. Statusy zamówień

Statusy zamówienia:

```txt
New       - Nowe
Paid      - Opłacone
Sent      - Wysłane
Finished  - Zakończone
Cancelled - Anulowane
```

Statusy są wyświetlane po polsku w panelu administratora oraz w widoku klienta.

Lista zamówień administratora ma:

```txt
- wyszukiwarkę,
- filtr statusu,
- statusy po polsku,
- podgląd pozycji,
- przejście do edycji,
- anulowanie,
- przywracanie,
- ukrywanie.
```

Lista zamówień klienta ma:

```txt
- wyszukiwarkę,
- filtr statusu,
- statusy po polsku,
- przejście do szczegółów zamówienia.
```

---

## 10. Edycja zamówienia

Edycja zamówienia jest dostępna pod adresem:

```txt
/orders/edit/{id}
```

W edycji zamówienia administrator może:

```txt
- zmienić status,
- dodać produkt,
- zwiększyć ilość pozycji,
- zmniejszyć ilość pozycji,
- usunąć pozycję,
- anulować zamówienie,
- przywrócić anulowane zamówienie.
```

Akcja `Ukryj` ustawia:

```txt
IsActive = 0
```

---

## 11. Koszyk

Koszyk jest przechowywany w sesji.

Klient może:

```txt
- dodać produkt do koszyka,
- zwiększyć ilość produktu,
- zmniejszyć ilość produktu,
- usunąć produkt z koszyka,
- złożyć zamówienie.
```

W górnym menu obok koszyka wyświetla się licznik produktów znajdujących się w koszyku.

---

## 12. Obsługa magazynu

Produkty mają pole:

```txt
Stock
```

Aplikacja kontroluje stan magazynowy w koszyku, przy składaniu zamówienia i przy edycji zamówienia.

Jeżeli produkt ma:

```txt
Stock = 0
```

to klient widzi komunikat:

```txt
Brak w magazynie
```

---

## 13. Szczegóły produktu

Aplikacja ma osobną stronę szczegółów produktu:

```txt
/product/{id}
```

Na liście produktów pokazane są najważniejsze informacje:

```txt
- nazwa,
- krótki opis,
- kategoria,
- cena,
- stan magazynowy,
- przycisk szczegółów,
- przycisk dodania do koszyka.
```

Na stronie szczegółów produktu pokazane są:

```txt
- nazwa produktu,
- opis,
- cena,
- stan magazynowy,
- kategoria,
- obrazek,
- informacja czy produkt jest promowany,
- pasujące akcesoria.
```

---

## 14. Produkty promowane

Produkty mają pole:

```txt
IsPromoted
```

Pole oznacza, czy produkt ma być wyświetlany na stronie głównej jako promowany.

```txt
IsPromoted = 1 - produkt promowany
IsPromoted = 0 - produkt zwykły
```

---

## 15. Górne menu

Górne menu zawiera ikonki oraz tekst.

Przykładowe elementy menu:

```txt
🏠 Start
🛒 Koszyk
📦 Moje zamówienia
⚙️ Panel admina
🔐 Logowanie
📝 Rejestracja
🚪 Wyloguj
```

Menu pokazuje aktywną stronę przez podświetlenie linku.

Dla administratora linki panelu administracyjnego są umieszczone w rozwijanym menu.

---

## 16. Usuwanie rekordów

W projekcie rekordy są ukrywane przez pole:

```txt
IsActive
```

Aktywny rekord ma:

```txt
IsActive = 1
```

Ukryty rekord ma:

```txt
IsActive = 0
```

---

## 17. Struktura katalogów

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

## 18. Uruchomienie projektu

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

## 19. Testowe sprawdzenie aplikacji

Warto sprawdzić:

```txt
- czy działa strona główna,
- czy działają kategorie,
- czy działa strona szczegółów produktu,
- czy działają produkty promowane,
- czy działa licznik koszyka w menu,
- czy działają przyciski plus i minus w koszyku,
- czy działa rozwijane menu administratora,
- czy działa panel startowy administratora,
- czy działa filtr statusu zamówień u administratora,
- czy działa filtr statusu w Moich zamówieniach,
- czy status Anulowane wyświetla się po polsku,
- czy działa edycja zamówienia z pozycjami,
- czy działa anulowanie zamówienia,
- czy działa przywracanie zamówienia,
- czy działa ukrywanie zamówień,
- czy klient widzi tylko swoje zamówienia,
- czy klient nie ma dostępu do panelu admina,
- czy admin ma dostęp do panelu admina,
- czy działają operacje CRUD.
```
