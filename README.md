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
app/Http/Controllers    - tutaj są kontrolery
app/Services            - tutaj są serwisy z logiką biznesową
resources/views         - tutaj są widoki Blade
routes/web.php          - tutaj są trasy strony
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

W bazie jest dodany użytkownik testowy.

W tabeli `Users` login jest zapisany w kolumnie:

```txt
Email
```

Czyli w bazie użytkownik ma uzupełnione między innymi pola:

```txt
Name
Email
Password
```

Hasło nie jest zapisane zwykłym tekstem.
W SQL jest zapisany hash hasła.

W kodzie logowania hasło będzie sprawdzane przez:

```php
Hash::check()
```

Dane testowe nie są wyświetlane na formularzu logowania.

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
- obsługi zamówień z koszyka.
```

Dzięki temu kontrolery są krótsze, bo większość logiki jest przeniesiona do serwisów.

---

## 14. Walidacja w serwisach

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

W tej walidacji sprawdzam między innymi:

```txt
- czy nazwa produktu jest wymagana,
- czy opis ma minimum 5 znaków,
- czy cena jest większa od 0,
- czy stan magazynowy nie jest ujemny,
- czy wybrana kategoria istnieje w tabeli Categories,
- czy lista akcesoriów jest tablicą.
```

---

## 15. Wyszukiwanie w serwisach

Wyszukiwanie jest realizowane przez query params.

Przykładowy adres:

```txt
/products?search=bambu
```

W serwisie pobieram parametr:

```php
$request->query('search')
```

Przykład z serwisu produktu:

```php
if ($request->query('search')) {
    $query->where('Name', 'like', '%' . $request->query('search') . '%');
}
```

Dzięki temu można wyszukiwać dane po nazwie.

---

## 16. Dezaktywacja rekordów

Rekordy nie są usuwane fizycznie z bazy.

Zamiast tego ustawiam:

```php
$model->IsActive = 0;
$model->EditDateTime = now();
$model->save();
```

Dzięki temu rekord zostaje w bazie danych, ale nie powinien być wyświetlany w aplikacji.

---

## 17. Logowanie i rejestracja

Logika logowania i rejestracji znajduje się w serwisie:

```txt
AuthService
```

Podczas rejestracji hasło jest zapisywane jako hash:

```php
Hash::make($request->input('Password'))
```

Podczas logowania hasło jest sprawdzane przez:

```php
Hash::check($request->input('Password'), $user->Password)
```

Po poprawnym logowaniu dane użytkownika są zapisywane w sesji:

```php
session(['user_id' => $user->Id]);
session(['user_name' => $user->Name]);
```

Wylogowanie usuwa dane z sesji:

```php
session()->forget('user_id');
session()->forget('user_name');
```

---

## 18. Obsługa koszyka i zamówień

Koszyk będzie przechowywany w sesji Laravel.

W serwisie `OrderService` dodana jest metoda:

```txt
createFromCart()
```

Metoda ta tworzy zamówienie na podstawie produktów zapisanych w koszyku.

Najpierw pobierany jest koszyk z sesji:

```php
$cart = session('cart', []);
```

Potem liczona jest suma zamówienia:

```php
$total += $product->Price * $quantity;
```

Następnie tworzony jest rekord w tabeli:

```txt
Orders
```

oraz pozycje zamówienia w tabeli:

```txt
OrderItems
```

Po złożeniu zamówienia koszyk jest czyszczony:

```php
session()->forget('cart');
```

---

## 19. Kontrolery Laravel

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

Schemat działania aplikacji wygląda tak:

```txt
route -> controller -> service -> model -> database
```

Kontroler odbiera żądanie z trasy, przekazuje dane do serwisu, a na końcu zwraca odpowiedni widok Blade.

Przykład:

```txt
/products -> ProductController -> ProductService -> Product -> Products
```

---

## 20. Rola poszczególnych kontrolerów

`ShopController` odpowiada za stronę główną sklepu i wyświetlanie produktów.

`ProductController` odpowiada za CRUD produktów.

`CategoryController` odpowiada za CRUD kategorii.

`AccessoryController` odpowiada za CRUD akcesoriów.

`UserController` odpowiada za CRUD użytkowników.

`AuthController` odpowiada za logowanie, rejestrację i wylogowanie.

`CartController` odpowiada za koszyk, dodawanie produktów do koszyka, usuwanie produktów z koszyka i składanie zamówienia.

`OrderController` odpowiada za listę zamówień, edycję statusu zamówienia i dezaktywację zamówienia.

`OrderItemController` odpowiada za pozycje zamówień.

---

## 21. Trasy aplikacji

Trasy aplikacji znajdują się w pliku:

```txt
routes/web.php
```

Trasy łączą adresy URL z odpowiednimi kontrolerami.

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

Przykład tras produktów:

```php
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products/create', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/edit/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/delete/{id}', [ProductController::class, 'delete'])->name('products.delete');
```

Przykład tras pozycji zamówień:

```php
Route::get('/order-items', [OrderItemController::class, 'index'])->name('order-items.index');
Route::get('/order-items/create', [OrderItemController::class, 'create'])->name('order-items.create');
Route::post('/order-items/create', [OrderItemController::class, 'store'])->name('order-items.store');
Route::get('/order-items/edit/{id}', [OrderItemController::class, 'edit'])->name('order-items.edit');
Route::put('/order-items/edit/{id}', [OrderItemController::class, 'update'])->name('order-items.update');
Route::delete('/order-items/delete/{id}', [OrderItemController::class, 'delete'])->name('order-items.delete');
```

W trasach używam:

```txt
- GET do wyświetlania stron,
- POST do dodawania danych,
- PUT do aktualizacji danych,
- DELETE do dezaktywacji danych,
- query params do wyszukiwania,
- url params do pobierania konkretnego rekordu.
```

---

## 22. Query params, URL params i POST

Przykład query params:

```txt
/products?search=bambu
```

W kodzie pobieram to przez:

```php
$request->query('search')
```

Przykład URL params:

```txt
/products/edit/1
```

W trasie jest to zapisane jako:

```php
Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
```

W metodzie kontrolera odbieram to jako:

```php
public function edit(Request $request, int $id)
```

Przykład POST:

```php
Route::post('/products/create', [ProductController::class, 'store'])->name('products.store');
```

Dane z formularza są odbierane przez:

```php
$request->input('Name')
```

---

## 23. Widoki Blade

Widoki Blade znajdują się w katalogu:

```txt
resources/views
```

Główny layout strony znajduje się w pliku:

```txt
resources/views/main.blade.php
```

Layout zawiera wspólne elementy strony:

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

---

## 24. Widok strony głównej sklepu

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

Na stronie głównej jest też wyszukiwarka produktów.

Przykład wyszukiwania:

```txt
/?search=bambu
```

Produkt dodawany jest do koszyka przez formularz POST:

```blade
<form method="POST" action="{{ route('cart.add', $product->Id) }}">
    @csrf
</form>
```

---

## 25. Widoki logowania i rejestracji

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

---

## 26. Widok koszyka

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

Usunięcie produktu z koszyka jest wykonywane przez formularz POST:

```blade
<form method="POST" action="{{ route('cart.remove', $product->Id) }}">
    @csrf
</form>
```

Złożenie zamówienia jest wykonywane przez formularz POST:

```blade
<form method="POST" action="{{ route('cart.order') }}">
    @csrf
</form>
```

Dane zamówienia:

```txt
CustomerName
CustomerEmail
Address
```

---

## 27. Widoki produktów

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

Widok listy produktów pokazuje produkty w tabeli.

Na liście produktów są wyświetlane:

```txt
- ID,
- nazwa produktu,
- kategoria,
- cena,
- stan magazynowy,
- akcesoria,
- przyciski akcji.
```

Widok dodawania produktu zawiera pola:

```txt
Name
Description
Price
Stock
CategoryId
ImageUrl
Accessories[]
```

Widok edycji produktu pozwala zmienić dane produktu oraz jego akcesoria.

Akcesoria produktu są wybierane przez checkboxy:

```txt
Accessories[]
```

Dzięki temu można przypisać do produktu wiele akcesoriów.

---

## 28. CRUD produktów

Dla produktów przygotowano widoki potrzebne do operacji CRUD.

Wyświetlanie produktów:

```txt
/products
```

Dodawanie produktu:

```txt
/products/create
```

Edycja produktu:

```txt
/products/edit/{id}
```

Dezaktywacja produktu:

```txt
/products/delete/{id}
```

Dezaktywacja jest wykonywana przez formularz z metodą DELETE.

Dodawanie i edycja produktów używa formularzy POST oraz PUT.

---

## 29. Widoki kategorii

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

Widok listy kategorii pokazuje kategorie w tabeli.

Na liście kategorii są wyświetlane:

```txt
- ID,
- nazwa kategorii,
- opis kategorii,
- przyciski akcji.
```

Widok dodawania kategorii zawiera pola:

```txt
Name
Description
```

Widok edycji kategorii zawiera formularz edycji istniejącej kategorii.

---

## 30. CRUD kategorii

Dla kategorii przygotowano widoki potrzebne do operacji CRUD.

Wyświetlanie kategorii:

```txt
/categories
```

Dodawanie kategorii:

```txt
/categories/create
```

Edycja kategorii:

```txt
/categories/edit/{id}
```

Dezaktywacja kategorii:

```txt
/categories/delete/{id}
```

Dezaktywacja jest wykonywana przez formularz z metodą DELETE.

Dodawanie kategorii używa formularza POST, a edycja kategorii używa formularza PUT.

---

## 31. Widoki akcesoriów

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

Widok listy akcesoriów pokazuje akcesoria w tabeli.

Na liście akcesoriów są wyświetlane:

```txt
- ID,
- nazwa akcesorium,
- opis akcesorium,
- cena,
- przyciski akcji.
```

Widok dodawania akcesorium zawiera pola:

```txt
Name
Description
Price
```

Widok edycji akcesorium zawiera formularz edycji istniejącego akcesorium.

---

## 32. CRUD akcesoriów

Dla akcesoriów przygotowano widoki potrzebne do operacji CRUD.

Wyświetlanie akcesoriów:

```txt
/accessories
```

Dodawanie akcesorium:

```txt
/accessories/create
```

Edycja akcesorium:

```txt
/accessories/edit/{id}
```

Dezaktywacja akcesorium:

```txt
/accessories/delete/{id}
```

Dezaktywacja jest wykonywana przez formularz z metodą DELETE.

Dodawanie akcesorium używa formularza POST, a edycja akcesorium używa formularza PUT.

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

Widok listy użytkowników pokazuje użytkowników w tabeli.

Na liście użytkowników są wyświetlane:

```txt
- ID,
- nazwa użytkownika,
- login,
- przyciski akcji.
```

Hasło użytkownika nie jest wyświetlane na liście.

Widok dodawania użytkownika zawiera pola:

```txt
Name
Email
Password
```

W tym projekcie pole `Email` pełni funkcję loginu.

Widok edycji użytkownika pozwala zmienić:

```txt
- nazwę użytkownika,
- login,
- hasło.
```

Pole hasła w edycji można zostawić puste, wtedy hasło nie zostanie zmienione.

---

## 34. CRUD użytkowników

Dla użytkowników przygotowano widoki potrzebne do operacji CRUD.

Wyświetlanie użytkowników:

```txt
/users
```

Dodawanie użytkownika:

```txt
/users/create
```

Edycja użytkownika:

```txt
/users/edit/{id}
```

Dezaktywacja użytkownika:

```txt
/users/delete/{id}
```

Dezaktywacja jest wykonywana przez formularz z metodą DELETE.

Dodawanie użytkownika używa formularza POST, a edycja użytkownika używa formularza PUT.

Hasło jest zapisywane w bazie jako hash.

---

## 35. Widoki zamówień

Widoki zamówień znajdują się w katalogu:

```txt
resources/views/orders
```

Utworzone pliki:

```txt
index.blade.php
edit.blade.php
```

Widok listy zamówień pokazuje zamówienia razem z danymi klienta i pozycjami zamówienia.

Na liście zamówień są wyświetlane:

```txt
- ID zamówienia,
- status zamówienia,
- dane klienta,
- adres,
- użytkownik z systemu,
- data utworzenia,
- wartość zamówienia,
- pozycje zamówienia,
- przyciski akcji.
```

Widok edycji zamówienia pozwala zmienić status zamówienia.

Dostępne statusy:

```txt
New
Paid
Sent
Finished
```

---

## 36. Obsługa zamówień

Zamówienia można wyświetlić pod adresem:

```txt
/orders
```

Edycja statusu zamówienia:

```txt
/orders/edit/{id}
```

Dezaktywacja zamówienia:

```txt
/orders/delete/{id}
```

Dezaktywacja jest wykonywana przez formularz z metodą DELETE.

Edycja statusu zamówienia używa formularza PUT.

Wyszukiwanie zamówień działa przez query params:

```txt
/orders?search=Jan
```

Wyszukiwanie jest wykonywane po nazwie klienta.

---

## 37. Widoki pozycji zamówień

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

Widok listy pozycji zamówień:

```txt
resources/views/orderItems/index.blade.php
```

Ten widok pokazuje pozycje zamówień w tabeli.

Na liście pozycji zamówień są wyświetlane:

```txt
- ID pozycji,
- numer zamówienia,
- klient,
- produkt,
- ilość,
- cena,
- suma,
- przyciski akcji.
```

Widok dodawania pozycji zamówienia:

```txt
resources/views/orderItems/create.blade.php
```

Ten widok zawiera formularz dodania pozycji do zamówienia.

W formularzu dodawania pozycji zamówienia są pola:

```txt
OrderId
ProductId
Quantity
```

Widok edycji pozycji zamówienia:

```txt
resources/views/orderItems/edit.blade.php
```

Ten widok pozwala zmienić zamówienie, produkt oraz ilość.

---

## 38. CRUD pozycji zamówień

Dla pozycji zamówień przygotowano widoki potrzebne do operacji CRUD.

Wyświetlanie pozycji zamówień:

```txt
/order-items
```

Dodawanie pozycji zamówienia:

```txt
/order-items/create
```

Edycja pozycji zamówienia:

```txt
/order-items/edit/{id}
```

Dezaktywacja pozycji zamówienia:

```txt
/order-items/delete/{id}
```

Dezaktywacja jest wykonywana przez formularz z metodą DELETE.

Dodawanie pozycji zamówienia używa formularza POST.

Edycja pozycji zamówienia używa formularza PUT.

Wyszukiwanie pozycji zamówień działa przez query params:

```txt
/order-items?search=ender
```

Wyszukiwanie jest wykonywane po nazwie produktu.

---

## 39. Dziennik pracy

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

W modelach ustawiłem nazwy tabel, klucze główne, pola dat oraz relacje.

### Krok 5 - serwisy Laravel

Dodałem serwisy Laravel, które odpowiadają za logikę biznesową aplikacji.

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

### Krok 6 - kontrolery Laravel

Dodałem kontrolery Laravel, które łączą trasy aplikacji z serwisami.

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

### Krok 7 - trasy aplikacji

Dodałem trasy aplikacji w pliku:

```txt
routes/web.php
```

Trasy łączą adresy URL z kontrolerami.

Dodałem trasy dla strony głównej, logowania, rejestracji, produktów, kategorii, akcesoriów, użytkowników, koszyka, zamówień i pozycji zamówień.

### Krok 8 - layout i strona główna sklepu

Dodałem główny layout Blade:

```txt
resources/views/main.blade.php
```

Dodałem też widok strony głównej sklepu:

```txt
resources/views/shop/index.blade.php
```

### Krok 9 - logowanie, rejestracja i koszyk

Dodałem widoki logowania i rejestracji:

```txt
resources/views/auth/login.blade.php
resources/views/auth/register.blade.php
```

Dodałem też widok koszyka:

```txt
resources/views/cart/index.blade.php
```

### Krok 10 - poprawa widoku logowania

Poprawiłem widok logowania:

```txt
resources/views/auth/login.blade.php
```

Usunąłem z widoku logowania wyświetlanie danych testowych.

### Krok 11 - widoki produktów

Dodałem widoki CRUD dla produktów:

```txt
resources/views/products/index.blade.php
resources/views/products/create.blade.php
resources/views/products/edit.blade.php
```

Na tym etapie działa część CRUD dla produktów.

### Krok 12 - widoki kategorii

Dodałem widoki CRUD dla kategorii:

```txt
resources/views/categories/index.blade.php
resources/views/categories/create.blade.php
resources/views/categories/edit.blade.php
```

Na tym etapie działa część CRUD dla kategorii.

### Krok 13 - widoki akcesoriów

Dodałem widoki CRUD dla akcesoriów:

```txt
resources/views/accessories/index.blade.php
resources/views/accessories/create.blade.php
resources/views/accessories/edit.blade.php
```

Na tym etapie działa część CRUD dla akcesoriów.

### Krok 14 - widoki użytkowników

Dodałem widoki CRUD dla użytkowników:

```txt
resources/views/users/index.blade.php
resources/views/users/create.blade.php
resources/views/users/edit.blade.php
```

Widok listy użytkowników pokazuje użytkowników w tabeli i nie pokazuje haseł.

### Krok 15 - widoki zamówień

Dodałem widoki zamówień:

```txt
resources/views/orders/index.blade.php
resources/views/orders/edit.blade.php
```

Widok listy zamówień pokazuje dane zamówienia, dane klienta i pozycje zamówienia.

Widok edycji zamówienia pozwala zmienić status zamówienia.

### Krok 16 - widoki pozycji zamówień

Dodałem widoki CRUD dla pozycji zamówień:

```txt
resources/views/orderItems/index.blade.php
resources/views/orderItems/create.blade.php
resources/views/orderItems/edit.blade.php
```

Widok listy pozycji zamówień pokazuje numer zamówienia, klienta, produkt, ilość, cenę i sumę.

Widok dodawania pozycji zamówienia pozwala wybrać zamówienie, produkt i ilość.

Widok edycji pozycji zamówienia pozwala zmienić zamówienie, produkt i ilość.

Na tym etapie przygotowane są już widoki dla wszystkich głównych tabel projektu.

---

## 40. Jak wgrać bazę danych

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

## 41. Jak sprawdzić trasy

Po dodaniu tras można sprawdzić ich listę komendą:

```bash
php artisan route:list
```

Powinny pojawić się między innymi trasy:

```txt
/
login
register
products
categories
accessories
users
cart
orders
order-items
```

---

## 42. Jak uruchomić projekt

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

Uruchomić projekt:

```bash
php artisan serve
```

Adres lokalny aplikacji:

```txt
http://127.0.0.1:8000
```

Na tym etapie aplikacja ma już przygotowane główne modele, serwisy, kontrolery, trasy i widoki CRUD.

---

## 43. Następny krok

Następnie trzeba wykonać test całej aplikacji i poprawić ewentualne błędy.

Do sprawdzenia będą:

```txt
- strona główna sklepu,
- logowanie,
- rejestracja,
- koszyk,
- składanie zamówienia,
- lista zamówień,
- CRUD produktów,
- CRUD kategorii,
- CRUD akcesoriów,
- CRUD użytkowników,
- CRUD pozycji zamówień,
- wyszukiwanie na listach,
- walidacja formularzy,
- dezaktywacja rekordów.
```

Po testach można dodać ostatnie poprawki i przygotować opis projektu do obrony.
