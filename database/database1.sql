-- Active: 1769521603640@@localhost@5432@linkup

ALTER TABLE users ADD COLUMN username VARCHAR(100) NOT NULL AFTER name;

ALTER TABLE users DROP username;


  SELECT * FROM users;