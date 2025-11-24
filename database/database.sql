-- Create database
CREATE DATABASE IF NOT EXISTS user_management_test;

-- Use the database
USE user_management_test;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO users (name, email, phone) VALUES
('Monkey D Luffy', 'monkey.d.luffy@example.com', '123-456-7890'),
('Roronoa Zoro', 'roronoa.zoro@example.com', '123-456-7891'),
('Vinsmoke Sanji', 'vinsmoke.sanji@example.com', '123-456-7892');