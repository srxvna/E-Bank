SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `ebank`;

USE `ebank`;

CREATE TABLE customers (
  customer_id INT NOT NULL AUTO_INCREMENT,
  first_name VARCHAR(255) NOT NULL,
  last_name VARCHAR(255) NOT NULL,
  username VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  account_number INT(8) UNIQUE,
  encryption_key BINARY(32),
  iv BINARY(16),
  PRIMARY KEY (customer_id)
);


CREATE TABLE accounts (
  account_id INT NOT NULL AUTO_INCREMENT,
  customer_id INT NOT NULL,
  account_type VARCHAR(255) NOT NULL,
  balance DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (account_id),
  FOREIGN KEY (customer_id) REFERENCES customers(customer_id)
);


CREATE TABLE transactions (
  transaction_id INT NOT NULL AUTO_INCREMENT,
  account_id INT NOT NULL,
  transaction_type VARCHAR(255) NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  details VARCHAR(255) NOT NULL,
  timestamp TIMESTAMP NOT NULL,
  PRIMARY KEY (transaction_id),
  FOREIGN KEY (account_id) REFERENCES accounts(account_id)
);
