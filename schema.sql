CREATE DATABASE IF NOT EXISTS filtratex_db
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE filtratex_db;

CREATE TABLE IF NOT EXISTS inquiries (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  company VARCHAR(160) NULL,
  contact_name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL,
  phone VARCHAR(50) NULL,
  filter_type ENUM('air','liquid','custom') NOT NULL DEFAULT 'custom',
  reuse_need ENUM('single','reusable','unsure') NOT NULL DEFAULT 'unsure',
  temperature ENUM('normal','hot','unknown') NOT NULL DEFAULT 'unknown',
  chemical_exposure ENUM('yes','no','unknown') NOT NULL DEFAULT 'unknown',
  target_description TEXT NULL,
  status ENUM('new','in_progress','replied','closed') NOT NULL DEFAULT 'new',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS admins (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(80) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Starter login: admin / ChangeMe123!
-- Password is stored as a PHP password_hash-compatible bcrypt hash.
INSERT INTO admins (username, password_hash)
SELECT 'admin', '$2y$12$.k2kkZqBjcqEFrSY01sp/uTTIXp6KPIA6d4cHWFU/axBfU96XzJDO'
WHERE NOT EXISTS (SELECT 1 FROM admins WHERE username = 'admin');
