CREATE DATABASE IF NOT EXISTS pbl_ti_2025_b_zahir
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pbl_ti_2025_b_zahir;

SET time_zone = '+07:00';

CREATE TABLE IF NOT EXISTS account_type (
    id CHAR(36) PRIMARY KEY,
    name VARCHAR(128) NOT NULL,
    description TEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    deleted_at DATETIME NULL DEFAULT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS accounts (
    id CHAR(36) PRIMARY KEY,
    name VARCHAR(128) NOT NULL,
    email VARCHAR(128) NOT NULL,
    password TEXT NOT NULL,
    account_type_id CHAR(36) NOT NULL,
    status VARCHAR(128) NOT NULL DEFAULT 'Aktif',
    identification_number VARCHAR(128) NOT NULL,
    identification_type ENUM('NIM', 'NIP') NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    deleted_at DATETIME NULL DEFAULT NULL,
    UNIQUE KEY unique_email (email),
    UNIQUE KEY unique_account_type (account_type_id),
    CONSTRAINT fk_account_type FOREIGN KEY (account_type_id)
        REFERENCES account_type(id) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS actions (
    id CHAR(36) PRIMARY KEY,
    name VARCHAR(128) NOT NULL,
    description TEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    deleted_at DATETIME NULL DEFAULT NULL
) ENGINE=InnoDB;

INSERT IGNORE INTO account_type (id, name, description) VALUES
('10000000-0000-4000-8000-000000000001', 'Admin', 'Akun pengelola sistem.'),
('10000000-0000-4000-8000-000000000002', 'Dosen', 'Akun untuk dosen dengan identitas NIP.'),
('10000000-0000-4000-8000-000000000003', 'Mahasiswa', 'Akun untuk mahasiswa dengan identitas NIM.');

INSERT IGNORE INTO accounts (id, name, email, password, account_type_id, status, identification_number, identification_type) VALUES
('20000000-0000-4000-8000-000000000001', 'Administrator', 'admin@pnj.ac.id',
 '$2y$12$5eCEDjvENNKcRPxtuavSEO1tLe.KSXK6zxjaEWeBAKrtcy9Pxxuve',
 '10000000-0000-4000-8000-000000000001', 'Aktif', '520000000000000746', 'NIP');

INSERT IGNORE INTO actions (id, name, description) VALUES
('30000000-0000-4000-8000-000000000001', 'Create', 'Menambahkan data baru.'),
('30000000-0000-4000-8000-000000000002', 'Read', 'Melihat data.'),
('30000000-0000-4000-8000-000000000003', 'Update', 'Mengubah data yang sudah ada.'),
('30000000-0000-4000-8000-000000000004', 'Delete', 'Menghapus data dengan soft delete.');
