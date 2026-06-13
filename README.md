# PZSI2026Laravel - sklep z drukarkami 3D

Projekt wykonywany na przedmiot **Programowanie Zaawansowanych Serwisów Internetowych**.

Aplikacja będzie prostym sklepem internetowym z drukarkami 3D oraz akcesoriami, takimi jak filamenty, dysze i części zamienne.

Projekt jest wykonywany w frameworku **Laravel** z wykorzystaniem architektury **MVC**.

---

## 1. Informacje podstawowe

Nazwa projektu lokalnie:

```txt
C:\git\PZSI2026Laravel
```

Nazwa bazy danych:

```txt
pzsi-druk-3d
```

Technologie użyte w projekcie:

```txt
PHP
Laravel
MySQL / MariaDB
XAMPP
phpMyAdmin
Bootstrap
Visual Studio Code
Git
```

---

## 2. Cel projektu

Celem projektu jest stworzenie prostego sklepu internetowego z drukarkami 3D.

Użytkownik będzie mógł:

```txt
- przeglądać produkty,
- wyszukiwać produkty,
- dodawać produkty do koszyka,
- składać zamówienia,
- rejestrować się,
- logować się.
```

Dodatkowo od strony administracyjnej będzie można zarządzać produktami, kategoriami, akcesoriami, użytkownikami i zamówieniami.

---

## 3. Założenia projektu

Projekt będzie zawierał:

```txt
- bazę danych z minimum 5 tabelami,
- klucze obce między tabelami,
- relację wiele-do-wielu,
- operacje CRUD,
- wyszukiwanie danych,
- walidację formularzy,
- routing,
- kontrolery,
- modele,
- widoki Blade,
- logowanie i rejestrację użytkownika,
- koszyk zapisany w sesji.
```

Usuwanie rekordów będzie realizowane jako dezaktywacja:

```txt
IsActive = 0
```

Dzięki temu rekord zostaje w bazie, ale nie jest wyświetlany w aplikacji.

---

## 4. Aktualny etap projektu

Aktualnie wykonano:

```txt
1. Utworzenie nowego projektu Laravel.
2. Umieszczenie projektu w katalogu C:\git\PZSI2026Laravel.
3. Przygotowanie projektu do dalszej pracy.
4. Przygotowanie konfiguracji bazy danych w pliku .env.
5. Przygotowanie skryptu SQL bazy danych.
6. Dodanie danych testowych do bazy.
7. Utworzenie modeli Laravel.
8. Dodanie relacji między modelami.
```

---

## 5. Struktura projektu Laravel

Najważniejsze katalogi projektu:

```txt
app
bootstrap
config
database
public
resources
routes
storage
```

Opis wybranych katalogów:

```txt
app/Models              - tutaj są modele
app/Http/Controllers    - tutaj będą kontrolery
app/Services            - tutaj będzie logika biznesowa
resources/views         - tutaj będą widoki Blade
routes/web.php          - tutaj będą trasy strony
database                - tutaj jest plik SQL bazy danych
```

---

## 6. Konfiguracja bazy danych

Nazwa bazy danych:

```txt
pzsi-druk-3d
```

Baza jest tworzona w MySQL/MariaDB przez phpMyAdmin.

Port MySQL w XAMPP:

```txt
3307
```

Dlatego w pliku `.env` ustawiam:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE="pzsi-druk-3d"
DB_USERNAME=root
DB_PASSWORD=
```

Plik `.env` jest lokalny i nie powinien być udostępniany publicznie.

Do projektu dodany jest tylko plik przykładowy:

```txt
.env.example
```

Po zmianie `.env` czyszczę konfigurację Laravel:

```bash
php artisan config:clear
```

---

## 7. Struktura bazy danych

Skrypt SQL znajduje się w pliku:

```txt
database/pzsi-druk-3d.sql
```

W bazie danych są tabele:

```txt
Users
Categories
Products
Accessories
ProductAccessories
Orders
OrderItems
```

Opis tabel:

```txt
Users              - użytkownicy sklepu
Categories         - kategorie produktów
Products           - produkty, np. drukarki 3D, filamenty
Accessories        - akcesoria, np. dysze, stoły, filamenty
ProductAccessories - tabela łącząca produkty z akcesoriami
Orders             - zamówienia
OrderItems         - pozycje zamówienia
```

Relacje jeden-do-wielu:

```txt
Categories -> Products
Users -> Orders
Orders -> OrderItems
Products -> OrderItems
```

Relacja wiele-do-wielu:

```txt
Products <-> Accessories
```

Relacja wiele-do-wielu jest zrobiona przez tabelę:

```txt
ProductAccessories
```

Czyli jeden produkt może mieć wiele akcesoriów, a jedno akcesorium może pasować do wielu produktów.

---

## 8. Plik SQL

Plik SQL tworzy bazę danych:

```sql
CREATE DATABASE IF NOT EXISTS `pzsi-druk-3d`
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

Następnie wybierana jest baza:

```sql
USE `pzsi-druk-3d`;
```

W pliku SQL najpierw usuwam stare tabele, żeby można było łatwo odtworzyć bazę:

```sql
DROP TABLE IF EXISTS OrderItems;
DROP TABLE IF EXISTS Orders;
DROP TABLE IF EXISTS ProductAccessories;
DROP TABLE IF EXISTS Accessories;
DROP TABLE IF EXISTS Products;
DROP TABLE IF EXISTS Categories;
DROP TABLE IF EXISTS Users;
```

Przykład klucza obcego:

```sql
FOREIGN KEY (CategoryId) REFERENCES Categories(Id)
```

Przykład relacji wiele-do-wielu:

```sql
CREATE TABLE ProductAccessories (
    ProductId INT NOT NULL,
    AccessoryId INT NOT NULL,
    PRIMARY KEY(ProductId, AccessoryId),
    FOREIGN KEY (ProductId) REFERENCES Products(Id),
    FOREIGN KEY (AccessoryId) REFERENCES Accessories(Id)
);
```

Dodałem też dane testowe, żeby od razu było co wyświetlać w aplikacji.

---

## 9. Użytkownik testowy

W bazie jest dodany użytkownik testowy:

```txt
Login: tsaran
Hasło: dalej
```

W tabeli `Users` login jest zapisany w kolumnie:

```txt
Email
```

Czyli w bazie wygląda to tak:

```txt
Name: tsaran
Email: tsaran
Password: zahashowane hasło
```

Hasło nie jest zapisane zwykłym tekstem.
W SQL jest zapisany hash hasła `dalej`.

W kodzie logowania później będę sprawdzał hasło przez:

```php
Hash::check()
```

---

## 10. Dane testowe

W bazie dodane są przykładowe kategorie:

```txt
Drukarki 3D
Filamenty
Części zamienne
```

Przykładowe produkty:

```txt
Creality Ender 3 V3
Bambu Lab A1 Mini
Filament PETG Czarny
```

Przykładowe akcesoria:

```txt
Filament PLA 1kg
Dysza 0.4mm
Stół magnetyczny
```

Przykładowe połączenia produktów z akcesoriami:

```txt
Creality Ender 3 V3 -> Filament PLA 1kg
Creality Ender 3 V3 -> Dysza 0.4mm
Bambu Lab A1 Mini -> Filament PLA 1kg
Bambu Lab A1 Mini -> Stół magnetyczny
```

---

## 11. Modele Laravel

Modele znajdują się w katalogu:

```txt
app/Models
```

Utworzone modele:

```txt
User
Category
Product
Accessory
Order
OrderItem
```

Każdy model odpowiada jednej tabeli w bazie danych.

Przykładowo model `Product` odpowiada tabeli:

```txt
Products
```

W modelach ustawiłem nazwy tabel:

```php
protected $table = 'Products';
```

Ustawiłem też klucz główny:

```php
protected $primaryKey = 'Id';
```

Ponieważ w bazie używam własnych nazw pól dat, w modelach ustawiłem:

```php
const CREATED_AT = 'CreationDateTime';
const UPDATED_AT = 'EditDateTime';
```

Dzięki temu Laravel wie, że ma używać moich kolumn dat zamiast domyślnych `created_at` i `updated_at`.

---

## 12. Relacje w modelach

W modelach dodałem relacje między tabelami.

Relacja kategorii z produktami:

```txt
Category -> Products
```

W modelu `Category`:

```php
return $this->hasMany(Product::class, 'CategoryId', 'Id');
```

Relacja produktu z kategorią:

```txt
Product -> Category
```

W modelu `Product`:

```php
return $this->belongsTo(Category::class, 'CategoryId', 'Id');
```

Relacja produktu z akcesoriami:

```txt
Product -> Accessories
```

W modelu `Product`:

```php
return $this->belongsToMany(
    Accessory::class,
    'ProductAccessories',
    'ProductId',
    'AccessoryId'
);
```

Relacja akcesorium z produktami:

```txt
Accessory -> Products
```

W modelu `Accessory`:

```php
return $this->belongsToMany(
    Product::class,
    'ProductAccessories',
    'AccessoryId',
    'ProductId'
);
```

Relacja użytkownika z zamówieniami:

```txt
User -> Orders
```

W modelu `User`:

```php
return $this->hasMany(Order::class, 'UserId', 'Id');
```

Relacja zamówienia z użytkownikiem:

```txt
Order -> User
```

W modelu `Order`:

```php
return $this->belongsTo(User::class, 'UserId', 'Id');
```

Relacja zamówienia z pozycjami:

```txt
Order -> OrderItems
```

W modelu `Order`:

```php
return $this->hasMany(OrderItem::class, 'OrderId', 'Id');
```

Relacja pozycji zamówienia z produktem:

```txt
OrderItem -> Product
```

W modelu `OrderItem`:

```php
return $this->belongsTo(Product::class, 'ProductId', 'Id');
```

---

## 13. Dziennik pracy

### Krok 1 - utworzenie projektu Laravel

Utworzyłem nowy projekt Laravel w katalogu:

```txt
C:\git\PZSI2026Laravel
```

Projekt uruchamiam komendą:

```bash
php artisan serve
```

Adres lokalny aplikacji:

```txt
http://127.0.0.1:8000
```

### Krok 2 - przygotowanie projektu

Przygotowałem czysty projekt Laravel do dalszej pracy.

Na tym etapie projekt zawierał podstawową strukturę katalogów Laravel.

### Krok 3 - baza danych

Przygotowałem bazę danych dla projektu sklepu z drukarkami 3D.

Nazwa bazy danych:

```txt
pzsi-druk-3d
```

Skrypt SQL znajduje się w pliku:

```txt
database/pzsi-druk-3d.sql
```

W bazie utworzyłem tabele:

```txt
Users
Categories
Products
Accessories
ProductAccessories
Orders
OrderItems
```

Zastosowałem klucze obce między tabelami oraz relację wiele-do-wielu między produktami i akcesoriami.

Relacja wiele-do-wielu jest wykonana przez tabelę:

```txt
ProductAccessories
```

Dodałem też przykładowe dane startowe:

```txt
- użytkownik testowy,
- kategorie produktów,
- produkty,
- akcesoria,
- powiązania produktów z akcesoriami.
```

Użytkownik testowy:

```txt
Login: tsaran
Hasło: dalej
```

### Krok 4 - modele Laravel

Dodałem modele Laravel dla tabel z bazy danych.

Modele znajdują się w folderze:

```txt
app/Models
```

Utworzone modele:

```txt
User
Category
Product
Accessory
Order
OrderItem
```

W modelach ustawiłem nazwy tabel, klucze główne oraz pola dat.

Dodałem też relacje między modelami:

```txt
Category -> Products
Product -> Category
Product -> Accessories
Accessory -> Products
User -> Orders
Order -> User
Order -> OrderItems
OrderItem -> Order
OrderItem -> Product
```

Najważniejszą relacją jest relacja wiele-do-wielu między produktami i akcesoriami.

Ta relacja jest obsługiwana przez tabelę:

```txt
ProductAccessories
```

Na tym etapie projekt ma już przygotowaną warstwę modeli do dalszej pracy z serwisami i kontrolerami.

---

## 14. Jak wgrać bazę danych

W XAMPP trzeba uruchomić:

```txt
Apache
MySQL
```

Następnie wejść do phpMyAdmin:

```txt
http://localhost/phpmyadmin
```

W zakładce SQL trzeba wkleić zawartość pliku:

```txt
database/pzsi-druk-3d.sql
```

Po wykonaniu skryptu powinna powstać baza:

```txt
pzsi-druk-3d
```

---

## 15. Jak uruchomić projekt

W terminalu trzeba wejść do katalogu projektu:

```bash
cd /c/git/PZSI2026Laravel
```

Następnie uruchomić projekt:

```bash
php artisan serve
```

Adres lokalny aplikacji:

```txt
http://127.0.0.1:8000
```

---

## 16. Następny krok

Następnie zostaną przygotowane serwisy Laravel.

Serwisy będą znajdować się w katalogu:

```txt
app/Services
```

Planowane serwisy:

```txt
ProductService
CategoryService
AccessoryService
UserService
AuthService
OrderService
OrderItemService
```

W serwisach będzie logika biznesowa, między innymi:

```txt
- pobieranie danych,
- dodawanie rekordów,
- edycja rekordów,
- dezaktywacja rekordów,
- wyszukiwanie,
- walidacja formularzy.
```

Po dodaniu serwisów ten README zostanie ponownie zaktualizowany o kolejny krok.
