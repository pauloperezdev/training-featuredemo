-- Poblar tabla: authors
INSERT IGNORE INTO authors (name, bio, birth_date, death_date) VALUES
('Gabriel García Márquez', 'Escritor colombiano', '1927-03-06', '2014-04-17'),
('J.K. Rowling', 'Escritora británica', '1965-07-31', NULL),
('George Orwell', 'Escritor británico', '1903-06-25', '1950-01-21');

-- Poblar tabla: categories
INSERT IGNORE INTO categories (name, description) VALUES
('Ficción', 'Libros de ficción y novelas'),
('Ciencia', 'Libros de ciencia y tecnología'),
('Historia', 'Libros históricos y biografías');

-- Poblar tabla: books
INSERT IGNORE INTO books (title, author_id, category_id, isbn, publish_date, price, stock) VALUES
('Cien años de soledad', 1, 1, '9780060883287', '1967-06-05', 15.99, 10),
('Harry Potter y la piedra filosofal', 2, 1, '9780747532699', '1997-06-26', 9.99, 20),
('1984', 3, 1, '9780451524935', '1949-06-08', 12.99, 15);

-- Poblar tabla: customers
INSERT IGNORE INTO customers (first_name, last_name, email, phone, address, city, country) VALUES
('Juan', 'Pérez', 'juan.perez@example.com', '123456789', 'Calle Falsa 123', 'Bogotá', 'Colombia'),
('María', 'López', 'maria.lopez@example.com', '987654321', 'Avenida Siempre Viva 456', 'Ciudad de México', 'México');

-- Poblar tabla: orders
INSERT IGNORE INTO orders (customer_id, order_date, status, total_amount) VALUES
(1, '2024-06-01 10:30:00', 'Pendiente', 25.98),
(2, '2024-06-02 15:45:00', 'Completada', 12.99);

-- Poblar tabla: order_details
INSERT IGNORE INTO order_details (order_id, book_id, quantity, price) VALUES
(1, 1, 1, 15.99),
(1, 3, 1, 9.99),
(2, 3, 1, 12.99);

