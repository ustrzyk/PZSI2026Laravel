# PZSI2026Laravel - sklep z drukarkami 3D

Projekt wykonywany na przedmiot **Programowanie Zaawansowanych Serwisów Internetowych**.

Aplikacja jest prostym sklepem internetowym z drukarkami 3D oraz akcesoriami, takimi jak filamenty, dysze i części zamienne.

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

Użytkownik może:

```txt
- przeglądać produkty,
- wyszukiwać produkty,
- dodawać produkty do koszyka,
- składać zamówienia,
- rejestrować się,
- logować się.
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

## 3. Założenia projektu

Projekt zawiera:

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
- serwisy,
- widoki Blade,
- logowanie i rejestrację użytkownika,
- role użytkowników,
- zabezpieczenie panelu administracyjnego,
- koszyk zapisany w sesji.
```

Usuwanie rekordów jest realizowane jako dezaktywacja:

```txt
IsActive = 0
```

Dzięki temu rekord zostaje w bazie danych, ale nie jest wyświetlany w aplikacji.

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
9. Utworzenie serwisów Laravel.
10. Dodanie walidacji formularzy w serwisach.
11. Dodanie logiki logowania i rejestracji.
12. Dodanie logiki obsługi zamówień z koszyka.
13. Utworzenie kontrolerów Laravel.
14. Połączenie kontrolerów z serwisami.
15. Przygotowanie tras aplikacji w pliku routes/web.php.
16. Utworzenie głównego layoutu Blade.
17. Utworzenie widoku strony głównej sklepu.
18. Utworzenie widoków logowania i rejestracji.
19. Utworzenie widoku koszyka.
20. Poprawienie widoku logowania tak, aby nie wyświetlał danych testowych.
21. Utworzenie widoków CRUD dla produktów.
22. Utworzenie widoków CRUD dla kategorii.
23. Utworzenie widoków CRUD dla akcesoriów.
24. Utworzenie widoków CRUD dla użytkowników.
25. Utworzenie widoków dla zamówień.
26. Utworzenie widoków CRUD dla pozycji zamówień.
27. Przetłumaczenie statusów zamówienia w widoku na język polski.
28. Dodanie automatycznego przeliczania wartości zamówienia po zmianie pozycji.
29. Dodanie ról użytkowników: admin i client.
30. Dodanie zabezpieczenia panelu administracyjnego middleware.
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
app/Models              - modele aplikacji
app/Http/Controllers    - kontrolery
app/Http/Middleware     - middleware zabezpieczające dostęp
app/Services            - serwisy z logiką biznesową
resources/views         - widoki Blade
routes/web.php          - trasy aplikacji
database                - plik SQL bazy danych
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

## 8. Tabela Users i role

Tabela `Users` przechowuje użytkowników aplikacji.

Najważniejsze pola:

```txt
Id
Name
Email
Password
Role
CreationDateTime
EditDateTime
IsActive
```

Pole `Email` w tym projekcie pełni funkcję loginu.

Pole `Password` przechowuje hasło w formie zahashowanej.

Pole `Role` określa uprawnienia użytkownika.

Dostępne role:

```txt
admin
client
```

Znaczenie ról:

```txt
admin  - ma dostęp do panelu administracyjnego
client - zwykły klient sklepu
```

Użytkownik startowy dodany w skrypcie SQL ma rolę:

```txt
admin
```

Nowy użytkownik utworzony przez rejestrację dostaje automatycznie rolę:

```txt
client
```

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

Przykład tabeli użytkowników z rolą:

```sql
CREATE TABLE Users (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Email VARCHAR(150) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Role VARCHAR(20) NOT NULL,
    CreationDateTime DATETIME NOT NULL,
    EditDateTime DATETIME NOT NULL,
    IsActive BIT NOT NULL
);
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

Dane logowania nie są wyświetlane w formularzu logowania.

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

W modelach ustawiono nazwy tabel:

```php
protected $table = 'Products';
```

Ustawiono też klucz główny:

```php
protected $primaryKey = 'Id';
```

Ponieważ w bazie używane są własne nazwy pól dat, w modelach ustawiono:

```php
const CREATED_AT = 'CreationDateTime';
const UPDATED_AT = 'EditDateTime';
```

Dzięki temu Laravel używa kolumn `CreationDateTime` i `EditDateTime` zamiast domyślnych `created_at` i `updated_at`.

---

## 12. Relacje w modelach

W modelach dodano relacje między tabelami.

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
return $this->hasMany(OrderItem::class, 'OrderId', 'Id')
    ->where('IsActive', 1);
```

Relacja pozycji zamówienia z zamówieniem:

```txt
OrderItem -> Order
```

W modelu `OrderItem`:

```php
return $this->belongsTo(Order::class, 'OrderId', 'Id');
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

## 13. Serwisy Laravel

Serwisy znajdują się w katalogu:

```txt
app/Services
```

Utworzone serwisy:

```txt
ProductService
CategoryService
AccessoryService
UserService
AuthService
OrderService
OrderItemService
```

Serwisy odpowiadają za logikę biznesową aplikacji.

W serwisach znajdują się metody do:

```txt
- pobierania danych,
- wyszukiwania danych,
- dodawania rekordów,
- edycji rekordów,
- dezaktywacji rekordów,
- walidacji formularzy,
- obsługi logowania,
- obsługi rejestracji,
- obsługi koszyka,
- obsługi zamówień,
- przeliczania wartości zamówienia.
```

Dzięki temu kontrolery są krótsze, bo większość logiki jest przeniesiona do serwisów.

---

## 14. AuthService

Serwis `AuthService` odpowiada za:

```txt
- rejestrację,
- logowanie,
- wylogowanie.
```

Podczas rejestracji hasło jest hashowane:

```php
Hash::make($request->input('Password'))
```

Nowy użytkownik z rejestracji otrzymuje rolę:

```txt
client
```

Podczas logowania hasło jest sprawdzane przez:

```php
Hash::check($request->input('Password'), $user->Password)
```

Po poprawnym logowaniu do sesji zapisywane są:

```php
session(['user_id' => $user->Id]);
session(['user_name' => $user->Name]);
session(['user_role' => $user->Role]);
```

Wylogowanie usuwa dane z sesji:

```php
session()->forget('user_id');
session()->forget('user_name');
session()->forget('user_role');
```

---

## 15. UserService

Serwis `UserService` odpowiada za zarządzanie użytkownikami.

Obsługuje:

```txt
- listę użytkowników,
- wyszukiwanie użytkowników,
- dodawanie użytkownika,
- edycję użytkownika,
- zmianę roli użytkownika,
- zmianę hasła,
- dezaktywację użytkownika.
```

Podczas dodawania i edycji użytkownika walidowana jest rola:

```php
'Role' => ['required', 'string', 'in:admin,client']
```

Jeżeli administrator edytuje samego siebie, dane w sesji są aktualizowane:

```php
session(['user_name' => $model->Name]);
session(['user_role' => $model->Role]);
```

---

## 16. OrderItemService i przeliczanie wartości zamówienia

W projekcie dodano poprawkę, która automatycznie przelicza wartość zamówienia po zmianie pozycji zamówienia.

Dotyczy to sytuacji, gdy:

```txt
- dodano pozycję zamówienia,
- edytowano pozycję zamówienia,
- zmieniono ilość produktu,
- zmieniono produkt,
- przeniesiono pozycję do innego zamówienia,
- zdezaktywowano pozycję zamówienia.
```

Po każdej takiej operacji przeliczane jest pole:

```txt
Orders.TotalPrice
```

Dzięki temu wartość zamówienia zgadza się z sumą pozycji zamówienia.

Metoda odpowiedzialna za przeliczanie:

```php
private function recalculateOrderTotal(int $orderId): void
```

Ogólny mechanizm:

```php
$total += $item->Price * $item->Quantity;
$order->TotalPrice = $total;
$order->save();
```

---

## 17. Walidacja formularzy

Walidacja formularzy jest wykonywana w serwisach przez:

```php
$request->validate()
```

Przykład walidacji produktu:

```php
$request->validate([
    'Name' => ['required', 'string', 'max:150'],
    'Description' => ['required', 'string', 'min:5'],
    'Price' => ['required', 'numeric', 'min:0.01'],
    'Stock' => ['required', 'integer', 'min:0'],
    'CategoryId' => ['required', 'integer', 'exists:Categories,Id'],
    'ImageUrl' => ['nullable', 'string', 'max:255'],
    'Accessories' => ['nullable', 'array'],
]);
```

W tej walidacji sprawdzane jest między innymi:

```txt
- czy nazwa produktu jest wymagana,
- czy opis ma minimum 5 znaków,
- czy cena jest większa od 0,
- czy stan magazynowy nie jest ujemny,
- czy wybrana kategoria istnieje w tabeli Categories,
- czy lista akcesoriów jest tablicą.
```

Przykład walidacji statusu zamówienia:

```php
'Status' => ['required', 'string', 'max:50', 'in:New,Paid,Sent,Finished']
```

Przykład walidacji roli użytkownika:

```php
'Role' => ['required', 'string', 'in:admin,client']
```

---

## 18. Wyszukiwanie

Wyszukiwanie jest realizowane przez query params.

Przykład:

```txt
/products?search=bambu
```

W kodzie parametr pobierany jest przez:

```php
$request->query('search')
```

Przykład z serwisu produktu:

```php
if ($request->query('search')) {
    $query->where('Name', 'like', '%' . $request->query('search') . '%');
}
```

Wyszukiwanie działa między innymi dla:

```txt
- produktów,
- kategorii,
- akcesoriów,
- użytkowników,
- zamówień,
- pozycji zamówień.
```

---

## 19. Dezaktywacja rekordów

Rekordy nie są usuwane fizycznie z bazy.

Zamiast tego ustawiane jest:

```php
$model->IsActive = 0;
$model->EditDateTime = now();
$model->save();
```

Dzięki temu rekord zostaje w bazie danych, ale nie powinien być wyświetlany w aplikacji.

Tak działa dezaktywacja:

```txt
- produktów,
- kategorii,
- akcesoriów,
- użytkowników,
- zamówień,
- pozycji zamówień.
```

---

## 20. Middleware i zabezpieczenie dostępu

Middleware znajdują się w katalogu:

```txt
app/Http/Middleware
```

Utworzone middleware:

```txt
CheckUserLogged
CheckAdmin
```

Middleware są zarejestrowane w pliku:

```txt
bootstrap/app.php
```

Alias dla middleware zalogowanego użytkownika:

```php
'user.logged' => CheckUserLogged::class
```

Alias dla middleware administratora:

```php
'admin' => CheckAdmin::class
```

---

## 21. CheckUserLogged

Middleware `CheckUserLogged` sprawdza, czy użytkownik jest zalogowany.

Jeżeli użytkownik nie jest zalogowany, zostaje przekierowany na logowanie.

Ten middleware chroni operację składania zamówienia:

```txt
/cart/order
```

Dzięki temu koszyk można przeglądać publicznie, ale zamówienie może złożyć tylko zalogowany użytkownik.

---

## 22. CheckAdmin

Middleware `CheckAdmin` sprawdza dwie rzeczy:

```txt
1. Czy użytkownik jest zalogowany.
2. Czy użytkownik ma rolę admin.
```

Jeżeli użytkownik nie jest zalogowany, zostaje przekierowany na logowanie.

Jeżeli użytkownik jest zalogowany, ale nie jest administratorem, zostaje przekierowany na stronę główną sklepu i otrzymuje komunikat o braku dostępu.

Panel administracyjny jest dostępny tylko dla roli:

```txt
admin
```

---

## 23. Dostęp publiczny i administracyjny

Publicznie dostępne strony:

```txt
/
login
register
cart
cart/add
cart/remove
```

Dostępne dla zalogowanego użytkownika:

```txt
cart/order
```

Dostępne tylko dla administratora:

```txt
/products
/categories
/accessories
/users
/orders
/order-items
```

---

## 24. Trasy aplikacji

Trasy aplikacji znajdują się w pliku:

```txt
routes/web.php
```

Strona główna sklepu:

```php
Route::get('/', [ShopController::class, 'index'])->name('shop.index');
```

Logowanie i rejestracja:

```php
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('auth.login.post');
Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/register', [AuthController::class, 'registerPost'])->name('auth.register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
```

Koszyk:

```php
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
```

Składanie zamówienia przez zalogowanego użytkownika:

```php
Route::middleware('user.logged')->group(function () {
    Route::post('/cart/order', [CartController::class, 'order'])->name('cart.order');
});
```

Panel administracyjny:

```php
Route::middleware('admin')->group(function () {
    // produkty, kategorie, akcesoria, użytkownicy, zamówienia, pozycje zamówień
});
```

---

## 25. Kontrolery Laravel

Kontrolery znajdują się w katalogu:

```txt
app/Http/Controllers
```

Utworzone kontrolery:

```txt
ShopController
ProductController
CategoryController
AccessoryController
UserController
AuthController
CartController
OrderController
OrderItemController
```

Kontrolery odpowiadają za obsługę żądań użytkownika.

Schemat działania aplikacji:

```txt
route -> controller -> service -> model -> database
```

Przykład:

```txt
/products -> ProductController -> ProductService -> Product -> Products
```

---

## 26. Widoki Blade

Widoki Blade znajdują się w katalogu:

```txt
resources/views
```

Główny layout strony znajduje się w pliku:

```txt
resources/views/main.blade.php
```

Layout zawiera:

```txt
- nagłówek HTML,
- Bootstrap,
- menu nawigacyjne,
- komunikaty sukcesu,
- komunikaty błędów,
- miejsce na treść strony.
```

Miejsce na treść strony jest oznaczone przez:

```blade
@yield('content')
```

Pozostałe widoki korzystają z layoutu przez:

```blade
@extends('main')
```

Menu panelu administracyjnego jest widoczne tylko wtedy, gdy użytkownik ma rolę:

```txt
admin
```

---

## 27. Widok strony głównej sklepu

Widok strony głównej sklepu znajduje się w pliku:

```txt
resources/views/shop/index.blade.php
```

Ten widok pokazuje produkty dostępne w sklepie.

Na stronie głównej są wyświetlane:

```txt
- nazwa produktu,
- opis produktu,
- kategoria,
- cena,
- stan magazynowy,
- powiązane akcesoria,
- przycisk dodania produktu do koszyka.
```

Na stronie głównej jest wyszukiwarka produktów.

Przykład wyszukiwania:

```txt
/?search=bambu
```

Produkt dodawany jest do koszyka przez formularz POST.

---

## 28. Widoki logowania i rejestracji

Widoki logowania i rejestracji znajdują się w folderze:

```txt
resources/views/auth
```

Utworzone pliki:

```txt
login.blade.php
register.blade.php
```

Widok logowania korzysta z trasy:

```php
route('auth.login.post')
```

W formularzu logowania są pola:

```txt
Email
Password
```

W projekcie pole `Email` działa jako login użytkownika.

W widoku logowania nie są wyświetlane dane testowe.

Pola formularza mają zwykłe placeholdery:

```txt
Login
Hasło
```

Widok rejestracji korzysta z trasy:

```php
route('auth.register.post')
```

W formularzu rejestracji są pola:

```txt
Name
Email
Password
```

Nowy użytkownik z rejestracji otrzymuje rolę:

```txt
client
```

---

## 29. Widok koszyka

Widok koszyka znajduje się w pliku:

```txt
resources/views/cart/index.blade.php
```

Koszyk pokazuje:

```txt
- nazwę produktu,
- cenę produktu,
- ilość,
- sumę dla produktu,
- łączną wartość koszyka,
- przycisk usunięcia produktu z koszyka,
- formularz złożenia zamówienia.
```

Dane zamówienia:

```txt
CustomerName
CustomerEmail
Address
```

---

## 30. Widoki produktów

Widoki produktów znajdują się w katalogu:

```txt
resources/views/products
```

Utworzone pliki:

```txt
index.blade.php
create.blade.php
edit.blade.php
```

Funkcje:

```txt
- wyświetlanie produktów,
- wyszukiwanie produktów,
- dodawanie produktów,
- edycja produktów,
- dezaktywacja produktów,
- przypisywanie kategorii,
- przypisywanie akcesoriów.
```

Adresy:

```txt
/products
/products/create
/products/edit/{id}
```

---

## 31. Widoki kategorii

Widoki kategorii znajdują się w katalogu:

```txt
resources/views/categories
```

Utworzone pliki:

```txt
index.blade.php
create.blade.php
edit.blade.php
```

Funkcje:

```txt
- wyświetlanie kategorii,
- wyszukiwanie kategorii,
- dodawanie kategorii,
- edycja kategorii,
- dezaktywacja kategorii.
```

Adresy:

```txt
/categories
/categories/create
/categories/edit/{id}
```

---

## 32. Widoki akcesoriów

Widoki akcesoriów znajdują się w katalogu:

```txt
resources/views/accessories
```

Utworzone pliki:

```txt
index.blade.php
create.blade.php
edit.blade.php
```

Funkcje:

```txt
- wyświetlanie akcesoriów,
- wyszukiwanie akcesoriów,
- dodawanie akcesoriów,
- edycja akcesoriów,
- dezaktywacja akcesoriów.
```

Adresy:

```txt
/accessories
/accessories/create
/accessories/edit/{id}
```

---

## 33. Widoki użytkowników

Widoki użytkowników znajdują się w katalogu:

```txt
resources/views/users
```

Utworzone pliki:

```txt
index.blade.php
create.blade.php
edit.blade.php
```

Widok listy użytkowników pokazuje:

```txt
- ID,
- nazwę użytkownika,
- login,
- rolę,
- przyciski akcji.
```

Hasło użytkownika nie jest wyświetlane na liście.

Widok dodawania użytkownika zawiera pola:

```txt
Name
Email
Password
Role
```

Widok edycji użytkownika pozwala zmienić:

```txt
- nazwę użytkownika,
- login,
- rolę,
- hasło.
```

Pole hasła w edycji można zostawić puste, wtedy hasło nie zostanie zmienione.

Adresy:

```txt
/users
/users/create
/users/edit/{id}
```

---

## 34. Widoki zamówień

Widoki zamówień znajdują się w katalogu:

```txt
resources/views/orders
```

Utworzone pliki:

```txt
index.blade.php
edit.blade.php
```

Widok listy zamówień pokazuje:

```txt
- ID zamówienia,
- status zamówienia,
- dane klienta,
- adres,
- użytkownika z systemu,
- datę utworzenia,
- wartość zamówienia,
- pozycje zamówienia,
- przyciski akcji.
```

Widok edycji zamówienia pozwala zmienić status zamówienia.

Statusy techniczne zapisane w bazie:

```txt
New
Paid
Sent
Finished
```

Statusy wyświetlane użytkownikowi po polsku:

```txt
Nowe
Opłacone
Wysłane
Zakończone
```

Adresy:

```txt
/orders
/orders/edit/{id}
```

---

## 35. Widoki pozycji zamówień

Widoki pozycji zamówień znajdują się w katalogu:

```txt
resources/views/orderItems
```

Utworzone pliki:

```txt
index.blade.php
create.blade.php
edit.blade.php
```

Widok listy pozycji zamówień pokazuje:

```txt
- ID pozycji,
- numer zamówienia,
- klienta,
- produkt,
- ilość,
- cenę,
- sumę,
- przyciski akcji.
```

Widok dodawania pozycji zamówienia zawiera pola:

```txt
OrderId
ProductId
Quantity
```

Widok edycji pozycji zamówienia pozwala zmienić:

```txt
- zamówienie,
- produkt,
- ilość.
```

Po zmianie pozycji zamówienia wartość całego zamówienia jest automatycznie przeliczana.

Adresy:

```txt
/order-items
/order-items/create
/order-items/edit/{id}
```

---

## 36. Query params, URL params i POST

Przykład query params:

```txt
/products?search=bambu
```

W kodzie pobierane przez:

```php
$request->query('search')
```

Przykład URL params:

```txt
/products/edit/1
```

W trasie:

```php
Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
```

W metodzie kontrolera:

```php
public function edit(Request $request, int $id)
```

Przykład POST:

```php
Route::post('/products/create', [ProductController::class, 'store'])->name('products.store');
```

Dane z formularza:

```php
$request->input('Name')
```

W projekcie używane są metody:

```txt
GET
POST
PUT
DELETE
```

---

## 37. Jak wgrać bazę danych

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

## 38. Jak zaktualizować istniejącą bazę o role

Jeżeli baza już istnieje i nie chcesz jej usuwać, należy wykonać w phpMyAdmin:

```sql
ALTER TABLE Users
ADD Role VARCHAR(20) NOT NULL DEFAULT 'client' AFTER Password;

UPDATE Users
SET Role = 'admin'
WHERE Email = 'tsaran';
```

Jeżeli kolumna `Role` już istnieje, tego polecenia `ALTER TABLE` nie trzeba wykonywać drugi raz.

---

## 39. Jak naprawić istniejące wartości zamówień

Jeżeli wcześniej były edytowane pozycje zamówienia i suma zamówienia się nie zgadzała, można wykonać SQL:

```sql
UPDATE Orders o
SET TotalPrice = (
    SELECT IFNULL(SUM(oi.Price * oi.Quantity), 0)
    FROM OrderItems oi
    WHERE oi.OrderId = o.Id
    AND oi.IsActive = 1
),
EditDateTime = NOW()
WHERE o.IsActive = 1;
```

To przeliczy wartość zamówień na podstawie aktywnych pozycji zamówienia.

---

## 40. Jak sprawdzić trasy

Po dodaniu tras można sprawdzić ich listę komendą:

```bash
php artisan route:list
```

Powinny pojawić się między innymi trasy:

```txt
/
login
register
cart
products
categories
accessories
users
orders
order-items
```

---

## 41. Jak uruchomić projekt

W terminalu trzeba wejść do katalogu projektu:

```bash
cd /c/git/PZSI2026Laravel
```

Następnie odświeżyć autoload:

```bash
composer dump-autoload
```

Wyczyścić konfigurację:

```bash
php artisan config:clear
```

Wyczyścić trasy:

```bash
php artisan route:clear
```

Wyczyścić widoki:

```bash
php artisan view:clear
```

Uruchomić projekt:

```bash
php artisan serve
```

Adres lokalny aplikacji:

```txt
http://127.0.0.1:8000
```

---

## 42. Test działania ról

Test bez logowania:

```txt
/products
```

Oczekiwany efekt:

```txt
przekierowanie na stronę logowania
```

Test po zalogowaniu jako klient:

```txt
/products
```

Oczekiwany efekt:

```txt
brak dostępu do panelu administracyjnego
```

Test po zalogowaniu jako administrator:

```txt
/products
/categories
/accessories
/users
/orders
/order-items
```

Oczekiwany efekt:

```txt
administrator ma dostęp do panelu administracyjnego
```

---

## 43. Dziennik pracy

### Krok 1 - utworzenie projektu Laravel

Utworzono nowy projekt Laravel w katalogu:

```txt
C:\git\PZSI2026Laravel
```

### Krok 2 - przygotowanie projektu

Przygotowano czysty projekt Laravel do dalszej pracy.

### Krok 3 - baza danych

Przygotowano bazę danych dla sklepu z drukarkami 3D.

Dodano tabele:

```txt
Users
Categories
Products
Accessories
ProductAccessories
Orders
OrderItems
```

### Krok 4 - modele Laravel

Dodano modele Laravel:

```txt
User
Category
Product
Accessory
Order
OrderItem
```

Dodano relacje między modelami.

### Krok 5 - serwisy Laravel

Dodano serwisy:

```txt
ProductService
CategoryService
AccessoryService
UserService
AuthService
OrderService
OrderItemService
```

### Krok 6 - kontrolery Laravel

Dodano kontrolery:

```txt
ShopController
ProductController
CategoryController
AccessoryController
UserController
AuthController
CartController
OrderController
OrderItemController
```

### Krok 7 - trasy aplikacji

Dodano trasy aplikacji w pliku:

```txt
routes/web.php
```

### Krok 8 - layout i strona główna sklepu

Dodano główny layout Blade:

```txt
resources/views/main.blade.php
```

Dodano widok strony głównej sklepu:

```txt
resources/views/shop/index.blade.php
```

### Krok 9 - logowanie, rejestracja i koszyk

Dodano widoki:

```txt
resources/views/auth/login.blade.php
resources/views/auth/register.blade.php
resources/views/cart/index.blade.php
```

### Krok 10 - poprawa widoku logowania

Usunięto wyświetlanie danych testowych z widoku logowania.

### Krok 11 - widoki produktów

Dodano widoki CRUD dla produktów:

```txt
resources/views/products/index.blade.php
resources/views/products/create.blade.php
resources/views/products/edit.blade.php
```

### Krok 12 - widoki kategorii

Dodano widoki CRUD dla kategorii:

```txt
resources/views/categories/index.blade.php
resources/views/categories/create.blade.php
resources/views/categories/edit.blade.php
```

### Krok 13 - widoki akcesoriów

Dodano widoki CRUD dla akcesoriów:

```txt
resources/views/accessories/index.blade.php
resources/views/accessories/create.blade.php
resources/views/accessories/edit.blade.php
```

### Krok 14 - widoki użytkowników

Dodano widoki CRUD dla użytkowników:

```txt
resources/views/users/index.blade.php
resources/views/users/create.blade.php
resources/views/users/edit.blade.php
```

### Krok 15 - widoki zamówień

Dodano widoki zamówień:

```txt
resources/views/orders/index.blade.php
resources/views/orders/edit.blade.php
```

Dodano polskie etykiety statusów zamówień.

### Krok 16 - widoki pozycji zamówień

Dodano widoki CRUD dla pozycji zamówień:

```txt
resources/views/orderItems/index.blade.php
resources/views/orderItems/create.blade.php
resources/views/orderItems/edit.blade.php
```

### Krok 17 - poprawa wartości zamówienia

Dodano automatyczne przeliczanie wartości zamówienia po zmianie pozycji zamówienia.

### Krok 18 - role i zabezpieczenie panelu

Dodano role użytkowników:

```txt
admin
client
```

Dodano middleware:

```txt
CheckUserLogged
CheckAdmin
```

Panel administracyjny zabezpieczono tak, aby dostęp miał tylko administrator.
