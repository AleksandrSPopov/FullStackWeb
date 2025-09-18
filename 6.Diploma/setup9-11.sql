-- Создание таблиц для интернет-магазина
-- Выполнить в phpMyAdmin во вкладке SQL

-- 9. Таблица смартфонов
CREATE TABLE smartphone (
    id INT PRIMARY KEY AUTO_INCREMENT,
    smartphone VARCHAR(100) NOT NULL,
    brand_id INT,
    model_id INT,
    ram_size_id INT,
    screen_diagonal_id INT,

    FOREIGN KEY (brand_id) REFERENCES brand(id) ON DELETE CASCADE,
    FOREIGN KEY (model_id) REFERENCES model(id) ON DELETE CASCADE,
    FOREIGN KEY (ram_size_id) REFERENCES ram_size(id) ON DELETE CASCADE,
    FOREIGN KEY (screen_diagonal_id) REFERENCES screen_diagonal(id) ON DELETE CASCADE,
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. Таблица заказа
CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    orders VARCHAR(100) NOT NULL,
    order_number INT(100) NOT NULL,
    order_creation_date DATE NOT NULL,
    order_payment_date DATE NOT NULL,
    order_delivery_date DATE NOT NULL,
    order_receipt_date DATE NOT NULL,
    order_status_id INT,
    payment_method_id INT,
    customer_id INT,

    FOREIGN KEY (order_status_id) REFERENCES order_status(id) ON DELETE CASCADE,
    FOREIGN KEY (payment_method_id) REFERENCES payment_method(id) ON DELETE CASCADE,
    FOREIGN KEY (customer_id) REFERENCES customer(id) ON DELETE CASCADE,
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11. Таблица экземпляра смартфона
CREATE TABLE smartphone_unit (
    id INT PRIMARY KEY AUTO_INCREMENT,
    smartphone_unit VARCHAR(100) NOT NULL,
    price VARCHAR(100) NOT NULL,
    smartphone_id INT,
    smartphone_status_id INT,
    orders_id INT,
    order_status_id INT,
    payment_method_id INT,
    customer_id INT,
       
    FOREIGN KEY (smartphone_id) REFERENCES smartphone(id) ON DELETE CASCADE,
    FOREIGN KEY (smartphone_status_id) REFERENCES smartphone_status(id) ON DELETE CASCADE,
    FOREIGN KEY (orders_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (order_status_id) REFERENCES order_status(id) ON DELETE CASCADE,
    FOREIGN KEY (payment_method_id) REFERENCES payment_method(id) ON DELETE CASCADE,
    FOREIGN KEY (customer_id) REFERENCES customer(id) ON DELETE CASCADE,
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;