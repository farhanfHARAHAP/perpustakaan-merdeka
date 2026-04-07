CREATE DATABASE perpus_merdeka;

USE perpus_merdeka;

CREATE TABLE perpus_book_categories(
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(255)
);

CREATE TABLE perpus_books(
    book_id INT AUTO_INCREMENT PRIMARY KEY,
    book_code VARCHAR(255),
    book_name TEXT,
    book_author VARCHAR(255),
    book_release DATE,
    book_category INT,
    book_image VARCHAR(255),
    book_lended INT
    -- FOREIGN KEY (book_category) REFERENCES perpus_book_categories(category_id)
);

CREATE TABLE perpus_member_categories(
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(255)
);

CREATE TABLE perpus_members(
    member_id INT AUTO_INCREMENT PRIMARY KEY,
    member_name TEXT,
    member_category INT,
    member_address TEXT,
    member_image VARCHAR(255)
    -- FOREIGN KEY (member_category) REFERENCES perpus_member_categories(category_id)
);

CREATE TABLE perpus_ledger_lends(
    lend_id INT AUTO_INCREMENT PRIMARY KEY,    
    member_id INT,
    book_id INT,
    lend_date DATE,
    lend_return DATE,
    lend_returned INT
);

CREATE TABLE perpus_ledger_returns(
    return_id INT AUTO_INCREMENT PRIMARY KEY,    
    member_id INT,
    book_id INT,
    return_date DATE    
);

CREATE TABLE perpus_image(
    image_id INT AUTO_INCREMENT PRIMARY KEY,
    image_name VARCHAR(255) UNIQUE
);

