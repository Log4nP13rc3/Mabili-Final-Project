-- Drop the database if it exists (useful for testing, be careful with this in production)
DROP DATABASE IF EXISTS artist_investigators;

-- Create the database schema
CREATE DATABASE artist_investigators;

-- Use the newly created database
USE artist_investigators;

-- Create Users table with adjusted VARCHAR lengths
-- as the original script with VARCHAR length 255 gave me this error:
-- #1071 - Specified key was too long; max key length is 1000 bytes
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id VARCHAR(191) UNIQUE NOT NULL,
  email VARCHAR(191) UNIQUE NOT NULL,
  username VARCHAR(50) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role VARCHAR(20) DEFAULT 'user' NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create Posts table
CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  post_id INT UNIQUE NOT NULL,
  user_id VARCHAR(191) NOT NULL,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(user_id)
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create Comments table
CREATE TABLE comments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  comment_id INT UNIQUE NOT NULL,
  post_id INT NOT NULL,
  user_id VARCHAR(191) NOT NULL,
  content TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (post_id) REFERENCES posts(post_id),
  FOREIGN KEY (user_id) REFERENCES users(user_id)
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create a dedicated user for the database
CREATE USER 'art_inv_admin'@'localhost' IDENTIFIED BY 'Ar7157_1nv3571ga70r5_Adm1n!';

-- Grant necessary privileges to the new user on the artist_investigators database
GRANT SELECT, INSERT, UPDATE, DELETE ON artist_investigators.* TO 'art_inv_admin'@'localhost';

-- Apply changes
FLUSH PRIVILEGES;