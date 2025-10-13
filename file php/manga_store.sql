CREATE DATABASE IF NOT EXISTS manga_store;
USE manga_store;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS manga (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    author VARCHAR(100) NOT NULL,
    genre VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    volumes INT DEFAULT 1,
    status ENUM('Ongoing', 'Completed', 'Hiatus') DEFAULT 'Ongoing',
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    manga_id INT,
    quantity INT DEFAULT 1,
    total_price DECIMAL(10,2) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Pending', 'Processing', 'Shipped', 'Delivered') DEFAULT 'Pending',
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (manga_id) REFERENCES manga(id)
);

INSERT INTO users (username, password, email) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@mangastore.com');

INSERT INTO manga (title, author, genre, price, volumes, status, description) VALUES 
('One Piece', 'Eiichiro Oda', 'Adventure, Fantasy', 45000.00, 104, 'Ongoing', 'Petualangan Monkey D. Luffy dan kru bajak lautnya mencari harta karun legendaris One Piece.'),
('Naruto', 'Masashi Kishimoto', 'Adventure, Martial Arts', 42000.00, 72, 'Completed', 'Kisah Naruto Uzumaki, ninja muda yang bercita-cita menjadi Hokage desanya.'),
('Bleach', 'Tite Kubo', 'Adventure, Supernatural', 40000.00, 74, 'Completed', 'Ichigo Kurosaki mendapatkan kekuatan Shinigami dan bertugas melindungi manusia dari roh jahat.'),
('Berserk', 'Kentaro Miura', 'Dark Fantasy', 50000.00, 41, 'Hiatus', 'Perjalanan Guts, seorang prajurit bayaran dalam dunia yang gelap dan penuh bahaya.');