-- Baza do mojego projektu sklepu drukarek 3D
CREATE DATABASE IF NOT EXISTS `pzsi-druk-3d`
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE `pzsi-druk-3d`;

-- czyszcze tabele od końca, bo są klucze obce
DROP TABLE IF EXISTS OrderItems;
DROP TABLE IF EXISTS Orders;
DROP TABLE IF EXISTS ProductAccessories;
DROP TABLE IF EXISTS Accessories;
DROP TABLE IF EXISTS Products;
DROP TABLE IF EXISTS Categories;
DROP TABLE IF EXISTS Users;

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

CREATE TABLE Categories (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Description TEXT,
    CreationDateTime DATETIME NOT NULL,
    EditDateTime DATETIME NOT NULL,
    IsActive BIT NOT NULL
);

CREATE TABLE Products (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(150) NOT NULL,
    Description TEXT NOT NULL,
    Price DECIMAL(10,2) NOT NULL,
    Stock INT NOT NULL,
    CategoryId INT NOT NULL,
    ImageUrl VARCHAR(255),
    IsPromoted BIT NOT NULL,
    CreationDateTime DATETIME NOT NULL,
    EditDateTime DATETIME NOT NULL,
    IsActive BIT NOT NULL,
    FOREIGN KEY (CategoryId) REFERENCES Categories(Id)
);

CREATE TABLE Accessories (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(150) NOT NULL,
    Description TEXT NOT NULL,
    Price DECIMAL(10,2) NOT NULL,
    CreationDateTime DATETIME NOT NULL,
    EditDateTime DATETIME NOT NULL,
    IsActive BIT NOT NULL
);

-- tutaj robie połączenie wiele do wielu
CREATE TABLE ProductAccessories (
    ProductId INT NOT NULL,
    AccessoryId INT NOT NULL,
    PRIMARY KEY(ProductId, AccessoryId),
    FOREIGN KEY (ProductId) REFERENCES Products(Id),
    FOREIGN KEY (AccessoryId) REFERENCES Accessories(Id)
);

CREATE TABLE Orders (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    UserId INT NOT NULL,
    CustomerName VARCHAR(150) NOT NULL,
    CustomerEmail VARCHAR(150) NOT NULL,
    Address TEXT NOT NULL,
    Status VARCHAR(50) NOT NULL,
    TotalPrice DECIMAL(10,2) NOT NULL,
    CreationDateTime DATETIME NOT NULL,
    EditDateTime DATETIME NOT NULL,
    IsActive BIT NOT NULL,
    FOREIGN KEY (UserId) REFERENCES Users(Id)
);

CREATE TABLE OrderItems (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    OrderId INT NOT NULL,
    ProductId INT NOT NULL,
    Quantity INT NOT NULL,
    Price DECIMAL(10,2) NOT NULL,
    CreationDateTime DATETIME NOT NULL,
    EditDateTime DATETIME NOT NULL,
    IsActive BIT NOT NULL,
    FOREIGN KEY (OrderId) REFERENCES Orders(Id),
    FOREIGN KEY (ProductId) REFERENCES Products(Id)
);

-- dane startowe, żebym miał co klikac w aplikacji
INSERT INTO Users (Name, Email, Password, Role, CreationDateTime, EditDateTime, IsActive)
VALUES
('tsaran', 'tsaran', '$2y$12$FqQTxohofHG25bOU0c0/Z.HZlBXDJYnNgCaANhzytXPVk3fsRXSXu', 'admin', NOW(), NOW(), 1);

INSERT INTO Categories (Name, Description, CreationDateTime, EditDateTime, IsActive)
VALUES
('Drukarki 3D', 'Drukarki FDM i resin do domu oraz firmy.', NOW(), NOW(), 1),
('Filamenty', 'Materiały do druku 3D: PLA, PETG i ABS.', NOW(), NOW(), 1),
('Części zamienne', 'Dysze, paski, ekstrudery i inne elementy.', NOW(), NOW(), 1);

INSERT INTO Accessories (Name, Description, Price, CreationDateTime, EditDateTime, IsActive)
VALUES
('Filament PLA 1kg', 'Uniwersalny filament do codziennego druku.', 79.99, NOW(), NOW(), 1),
('Dysza 0.4mm', 'Standardowa dysza do drukarek FDM.', 19.99, NOW(), NOW(), 1),
('Stół magnetyczny', 'Elastyczna powierzchnia robocza do drukarki.', 89.99, NOW(), NOW(), 1);

INSERT INTO Products (Name, Description, Price, Stock, CategoryId, ImageUrl, IsPromoted, CreationDateTime, EditDateTime, IsActive)
VALUES
('Creality Ender 3 V3', 'Popularna drukarka 3D dla początkujących.', 999.99, 10, 1, '', 1, NOW(), NOW(), 1),
('Bambu Lab A1 Mini', 'Szybka drukarka 3D do małego warsztatu.', 1499.99, 5, 1, '', 1, NOW(), NOW(), 1),
('Filament PETG Czarny', 'Filament odporny i dobry do części technicznych.', 89.99, 30, 2, '', 1, NOW(), NOW(), 1);

INSERT INTO ProductAccessories (ProductId, AccessoryId)
VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 3);