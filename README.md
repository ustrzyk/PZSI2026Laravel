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
- pozycjami zamówień,
- pozycjami zamówienia bezpośrednio na stronie edycji zamówienia.
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
- historię zamówień klienta.
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

W górnym menu panel administratora jest pokazany jako rozwijana lista, żeby menu było krótsze i czytelniejsze.

---

## 9. Edycja zamówienia przez administratora

Administrator może wejść w edycję zamówienia:

```txt
/orders/edit/{id}
```

Na jednej stronie widzi:

```txt
- dane klienta,
- adres dostawy,
- status zamówienia,
- wartość zamówienia,
- pozycje zamówienia,
- produkty znajdujące się w zamówieniu,
- ilości produktów,
- ceny pozycji,
- stan magazynowy produktów.
```

Administrator może:

```txt
- zmienić status zamówienia,
- dodać produkt do zamówienia,
- zwiększyć ilość produktu w zamówieniu,
- zmniejszyć ilość produktu w zamówieniu,
- usunąć pozycję z zamówienia.
```

Po każdej zmianie pozycji zamówienia aplikacja ponownie przelicza wartość całego zamówienia.

Zmiana pozycji zamówienia wpływa też na magazyn:

```txt
- dodanie produktu zmniejsza Stock,
- zwiększenie ilości zmniejsza Stock,
- zmniejszenie ilości zwiększa Stock,
- usunięcie pozycji oddaje ilość produktu do Stock.
```

---

## 10. Koszyk i zamówienia

Koszyk jest przechowywany w sesji.

Klient może:

```txt
- dodać produkt do koszyka,
- zwiększyć ilość produktu przyciskiem plus,
- zmniejszyć ilość produktu przyciskiem minus,
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

W górnym menu obok koszyka wyświetla się licznik produktów znajdujących się w koszyku.

---

## 11. Obsługa magazynu

Produkty mają pole:

```txt
Stock
```

Pole `Stock` oznacza stan magazynowy produktu.

Aplikacja sprawdza stan magazynowy podczas dodawania produktu do koszyka, zwiększania ilości w koszyku, składania zamówienia oraz edycji pozycji zamówienia przez administratora.

Jeżeli produkt ma:

```txt
Stock = 0
```

to klient widzi komunikat:

```txt
Brak w magazynie
```

i nie może dodać produktu do koszyka.

Nie można zwiększyć ilości produktu w koszyku ani w zamówieniu ponad aktualny stan magazynowy.

Po złożeniu zamówienia stan magazynowy produktu jest automatycznie zmniejszany.

---

## 12. Szczegóły produktu

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

Na stronie szczegółów produktu pokazane są pełniejsze dane:

```txt
- nazwa produktu,
- pełny opis,
- cena,
- stan magazynowy,
- kategoria,
- obrazek,
- informacja czy produkt jest promowany,
- pasujące akcesoria,
- przycisk dodania do koszyka.
```

---

## 13. Produkty promowane

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

## 14. Górne menu

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

## 15. Usuwanie rekordów

W projekcie nie usuwam rekordów fizycznie z bazy.

Zamiast tego ustawiane jest:

```txt
IsActive = 0
```

Dzięki temu rekord zostaje w bazie danych, ale nie jest wyświetlany w aplikacji.

---

## 16. Struktura katalogów

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

## 17. Uruchomienie projektu

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

## 18. Testowe sprawdzenie aplikacji

Warto sprawdzić:

```txt
- czy działa strona główna,
- czy działają kategorie,
- czy działa strona szczegółów produktu,
- czy działają produkty promowane,
- czy działa licznik koszyka w menu,
- czy działają przyciski plus i minus w koszyku,
- czy nie można zwiększyć ilości ponad stan magazynowy,
- czy działa rozwijane menu administratora,
- czy działa koszyk,
- czy nie można kupić produktu bez stanu magazynowego,
- czy po zakupie zmniejsza się Stock,
- czy klient widzi tylko swoje zamówienia,
- czy klient nie ma dostępu do panelu admina,
- czy admin ma dostęp do panelu admina,
- czy admin może edytować zamówienie razem z pozycjami,
- czy po dodaniu pozycji zamówienia zmniejsza się Stock,
- czy po usunięciu pozycji zamówienia Stock wraca do magazynu,
- czy po zmianie pozycji zamówienia przelicza się TotalPrice,
- czy działają operacje CRUD.
```
