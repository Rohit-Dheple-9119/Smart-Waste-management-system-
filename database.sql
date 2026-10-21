-- Run this file in phpMyAdmin (Import) or paste it in the SQL tab

CREATE DATABASE IF NOT EXISTS waste_db;
USE waste_db;

-- table for registered users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- table for waste collection requests
CREATE TABLE requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    waste_type VARCHAR(50) NOT NULL,
    name VARCHAR(100) NOT NULL,
    area VARCHAR(50) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    description TEXT,
    request_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- table for complaints
CREATE TABLE complaints (
    id INT AUTO_INCREMENT PRIMARY KEY,
    complaint_type VARCHAR(50) NOT NULL,
    area VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    complaint_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
