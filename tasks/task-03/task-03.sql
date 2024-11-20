-- Typy użytkowników
CREATE TABLE user_types (
    id INT PRIMARY KEY,
    type_name VARCHAR(50) NOT NULL UNIQUE
);

-- Wspólne dane
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE,
    user_type_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_type_id) REFERENCES user_types(id),
    CHECK (email REGEXP '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$')
);

-- Osoby fizyczne
CREATE TABLE individual_users (
    user_id INT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    birth_date DATE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    CHECK (birth_date <= CURRENT_DATE),
    CHECK (birth_date >= '1900-01-01')
);

-- Firmy
CREATE TABLE company_users (
    user_id INT PRIMARY KEY,
    company_name VARCHAR(255) NOT NULL,
    nip VARCHAR(10) NOT NULL UNIQUE,
    FOREIGN KEY (user_id) REFERENCES users(id),
    CHECK (nip REGEXP '^[0-9]{10}$')
);