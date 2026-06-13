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

Repozytorium GitHub:

```txt
https://github.com/ustrzyk/PZSI2026Laravel
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
Git / GitHub
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
3. Utworzenie repozytorium GitHub.
4. Połączenie projektu lokalnego z repozytorium GitHub.
5. Przygotowanie projektu do dalszej pracy.
6. Przygotowanie konfiguracji bazy danych w pliku .env.
7. Przygotowanie skryptu SQL bazy danych.
8. Dodanie danych testowych do bazy.
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
app/Models              - tutaj będą modele
app/Http/Controllers    - tutaj będą kontrolery
app/Services            - tutaj będzie logika biznesowa
resources/views         - tutaj będą widoki Blade
routes/web.php          - tutaj będą trasy strony
database                - tutaj jest plik SQL bazy danych
```

---

## 6. Git i GitHub

Projekt został połączony z repozytorium:

```txt
https://github.com/ustrzyk/PZSI2026Laravel
```

Podstawowe komendy używane w projekcie:

```bash
git status
git add .
git commit -m "Opis zmian"
git push
```

Na tym etapie repozytorium zawiera początkowy projekt Laravel, konfigurację przykładową `.env.example`, plik SQL oraz opis projektu w README.

---

## 7. Konfiguracja bazy danych

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

Plik `.env` jest lokalny i nie trafia na GitHub, ponieważ jest dodany do `.gitignore`.

Do repozytorium trafia tylko plik przykładowy:

```txt
.env.example
```

Po zmianie `.env` czyszczę konfigurację Laravel:

```bash
php artisan config:clear
```

---

## 8. Struktura bazy danych

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

## 9. Plik SQL

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

## 10. Użytkownik testowy

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

## 11. Dane testowe

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

## 12. Dziennik pracy

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

### Krok 2 - GitHub

Dodałem projekt do repozytorium GitHub:

```txt
https://github.com/ustrzyk/PZSI2026Laravel
```

Na tym etapie mam czysty projekt Laravel i mogę zaczynać dodawanie funkcjonalności sklepu.

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

---

## 13. Jak wgrać bazę danych

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

## 14. Jak uruchomić projekt

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

## 15. Następny krok

Następnie zostaną przygotowane modele Laravel dla tabel:

```txt
User
Category
Product
Accessory
Order
OrderItem
```

Modele będą znajdować się w katalogu:

```txt
app/Models
```

W modelach zostaną dodane relacje między tabelami, np.:

```txt
Product -> Category
Product -> Accessories
Order -> User
Order -> OrderItems
OrderItem -> Product
```

Po dodaniu modeli ten README zostanie ponownie zaktualizowany o kolejny krok.
