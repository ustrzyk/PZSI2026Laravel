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

---

## 4. Aktualny etap projektu

Aktualnie wykonano:

```txt
1. Utworzenie nowego projektu Laravel.
2. Umieszczenie projektu w katalogu C:\git\PZSI2026Laravel.
3. Utworzenie repozytorium GitHub.
4. Połączenie projektu lokalnego z repozytorium GitHub.
5. Przygotowanie projektu do dalszej pracy.
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
resources/views         - tutaj będą widoki Blade
routes/web.php          - tutaj będą trasy strony
database                - tutaj będzie plik SQL bazy danych
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

Na tym etapie repozytorium zawiera początkowy projekt Laravel.

---

## 7. Baza danych

Planowana nazwa bazy danych:

```txt
pzsi-druk-3d
```

Baza będzie tworzona w MySQL/MariaDB przez phpMyAdmin.

Port MySQL w XAMPP:

```txt
3307
```

Dlatego w pliku `.env` ustawiam:

```env
DB_PORT=3307
DB_DATABASE="pzsi-druk-3d"
```

Szczegółowy skrypt SQL zostanie dodany w następnym kroku do pliku:

```txt
database/pzsi-druk-3d.sql
```

---

## 8. Dziennik pracy

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

---

## 9. Następny krok

Następnie zostanie przygotowana baza danych dla sklepu z drukarkami 3D.

Planowane tabele:

```txt
Users
Categories
Products
Accessories
ProductAccessories
Orders
OrderItems
```

Tabela `ProductAccessories` będzie realizowała relację wiele-do-wielu między produktami i akcesoriami.
