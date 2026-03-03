-- Create database
CREATE DATABASE IF NOT EXISTS module_b_db;
USE module_b_db;

-- Companies table
CREATE TABLE companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address TEXT,
    telephone VARCHAR(50),
    email VARCHAR(255),
    owner_name VARCHAR(255),
    owner_mobile VARCHAR(50),
    owner_email VARCHAR(255),
    contact_name VARCHAR(255),
    contact_mobile VARCHAR(50),
    contact_email VARCHAR(255),
    active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name_en VARCHAR(255),
    name_fr VARCHAR(255),
    description_en TEXT,
    description_fr TEXT,
    gtin VARCHAR(14) UNIQUE NOT NULL,
    brand VARCHAR(255),
    countryOfOrigin VARCHAR(100),
    weight_gross DECIMAL(10,2),
    weight_net DECIMAL(10,2),
    weight_unit VARCHAR(10),
    image_path VARCHAR(255),
    hidden BOOLEAN DEFAULT FALSE,
    company_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

-- Index for GTIN
CREATE INDEX idx_gtin ON products(gtin);