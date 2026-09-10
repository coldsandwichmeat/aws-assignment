CREATE DATABASE IF NOT EXISTS shuttle_db;
USE shuttle_db;

CREATE TABLE IF NOT EXISTS routes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    route_name VARCHAR(100) NOT NULL,
    origin VARCHAR(100) NOT NULL,
    destination VARCHAR(100) NOT NULL,
    departure_time TIME NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    available_seats INT NOT NULL
);

CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_reference VARCHAR(20) NOT NULL UNIQUE,
    route_id INT NOT NULL,
    passenger_name VARCHAR(100) NOT NULL,
    passenger_email VARCHAR(100) NOT NULL,
    tickets_booked INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (route_id) REFERENCES routes(id) ON DELETE CASCADE
);

INSERT IGNORE INTO routes (id, route_name, origin, destination, departure_time, price, available_seats) VALUES
(1, 'Campus Express A', 'Main Campus Block AB', 'LRT Wangsa Maju', '08:00:00', 1.50, 40),
(2, 'Campus Express B', 'LRT Wangsa Maju', 'Main Campus Block AB', '08:45:00', 1.50, 40),
(3, 'Hostel Shuttle 1', 'East Campus Hostel', 'DK Senat Complex', '09:15:00', 1.00, 30),
(4, 'Night Route C', 'Main Library', 'PV12 Condominium', '21:30:00', 2.00, 25);