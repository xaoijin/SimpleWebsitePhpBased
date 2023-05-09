<?php
// I, Johnson Li, certify that this submission is my own original work

// Create connection
$conn = mysqli_connect("localhost", "usersp23", "passwdsp23", "bcs350sp23");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create users table
$sql_users = "CREATE TABLE users (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(30) NOT NULL,
email VARCHAR(50) NOT NULL,
password VARCHAR(255) NOT NULL
)";

if (mysqli_query($conn, $sql_users)) {
    echo "Table users created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

// Add initial records
$sql_users_init = "INSERT INTO users (username, email, password)
VALUES ('john', 'john@example.com', '" . password_hash('password123', PASSWORD_DEFAULT) . "'),
       ('jane', 'jane@example.com', '" . password_hash('password456', PASSWORD_DEFAULT) . "'),
       ('bob', 'bob@example.com', '" . password_hash('password789', PASSWORD_DEFAULT) . "')";

if (mysqli_query($conn, $sql_users_init)) {
    echo "Users table populated successfully";
} else {
    echo "Error populating users table: " . mysqli_error($conn);
}

// Create bakery orders table
$sql_bakery_orders = "CREATE TABLE bakery_orders (
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      customer_name VARCHAR(255) NOT NULL,
      item_name VARCHAR(255) NOT NULL,
      item_quantity INT(6) NOT NULL,
      order_date DATE NOT NULL,
      total DECIMAL(10,2) NOT NULL
     );";

if (mysqli_query($conn, $sql_bakery_orders)) {
    echo "Table bakery_orders created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

// Add initial records
$sql_bakery_orders_init = "INSERT INTO bakery_orders (order_date, customer_name, item_name, item_quantity, total) VALUES
('2023-04-06', 'John Doe', 'Croissant', 2, 3.50),
('2023-04-06', 'Jane Smith', 'Baguette', 1, 2.50),
('2023-04-06', 'Bob Johnson', 'Sourdough Loaf', 1, 4.00),
('2023-04-06', 'Alice Lee', 'Blueberry Muffin', 3, 1.50),
('2023-04-06', 'Samuel Kim', 'Chocolate Eclair', 2, 2.00),
('2023-04-05', 'Jennifer Lee', 'Cinnamon Roll', 2, 2.50),
('2023-04-05', 'David Kim', 'Pain au Chocolat', 1, 3.00),
('2023-04-05', 'Grace Park', 'Croissant', 3, 3.50),
('2023-04-04', 'Alex Brown', 'Baguette', 2, 2.50),
('2023-04-04', 'Chris Evans', 'Sourdough Loaf', 2, 4.00),
('2023-04-03', 'Emily Johnson', 'Blueberry Muffin', 1, 1.50),
('2023-04-03', 'Michael Lee', 'Chocolate Eclair', 1, 2.00),
('2023-04-02', 'Sarah Kim', 'Cinnamon Roll', 3, 2.50),
('2023-04-02', 'Jason Park', 'Pain au Chocolat', 2, 3.00),
('2023-04-01', 'Jessica Brown', 'Croissant', 4, 3.50),
('2023-04-01', 'Daniel Evans', 'Baguette', 3, 2.50),
('2023-04-01', 'Lauren Johnson', 'Sourdough Loaf', 1, 4.00),
('2023-03-31', 'Ryan Lee', 'Blueberry Muffin', 2, 1.50),
('2023-03-31', 'Stephanie Kim', 'Chocolate Eclair', 3, 2.00),
('2023-03-31', 'Jonathan Park', 'Cinnamon Roll', 1, 2.50)";

if (mysqli_query($conn, $sql_bakery_orders_init)) {
    echo "bakery_orders table populated successfully";
} else {
    echo "Error populating bakery_orders table: " . mysqli_error($conn);
}

mysqli_close($conn);