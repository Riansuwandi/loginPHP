    -- Buat database
    CREATE DATABASE rianGanteng;

    USE rianGanteng;

    -- Buat tabel users
    CREATE TABLE users(
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100),
        email VARCHAR(100),
        password VARCHAR(100),
        role VARCHAR(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    -- Insert admin default
    INSERT INTO users (username, email, password, role)
    VALUES ('admin', 'admin@uns.com', 'admin123', 'admin');