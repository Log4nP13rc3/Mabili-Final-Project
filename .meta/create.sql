-- Drop the database if it exists
DROP DATABASE IF EXISTS artist_investigators;

-- Create the database
CREATE DATABASE artist_investigators;

-- Use the newly created database
USE artist_investigators;

-- Create Users table
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,         -- Primary key (auto-incremented integer)
  user_id VARCHAR(191) UNIQUE NOT NULL,      -- Unique email identifier (used as a foreign key in other tables)
  email VARCHAR(191) UNIQUE NOT NULL,        -- Email address (must be unique)
  username VARCHAR(50) UNIQUE NOT NULL,      -- Unique username
  password_hash VARCHAR(255) NOT NULL,       -- Password hash for security
  role VARCHAR(20) DEFAULT 'user' NOT NULL,  -- User role, default is 'user'
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Timestamp of creation
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create Posts table
CREATE TABLE posts (
  post_id INT AUTO_INCREMENT PRIMARY KEY,    -- Primary key (auto-incremented integer)
  user_id VARCHAR(191) NOT NULL,             -- Foreign key (references users.user_id)
  title VARCHAR(100) NOT NULL,               -- Post title
  content TEXT NOT NULL,                     -- Post content
  image_url VARCHAR(255) NOT NULL,           -- URL of the image associated with the post
  media_categories VARCHAR(255) NOT NULL,    -- Categories related to media
  themes_categories VARCHAR(255) NOT NULL,   -- Categories related to themes
  art_movements_categories VARCHAR(255) NOT NULL, -- Categories related to art movements
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp of creation
  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE  -- Foreign key constraint
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create Comments table
CREATE TABLE comments (
  comment_id INT AUTO_INCREMENT PRIMARY KEY, -- Primary key (auto-incremented integer)
  post_id INT NOT NULL,                      -- Foreign key (references posts.post_id)
  user_id VARCHAR(191) NOT NULL,             -- Foreign key (references users.user_id)
  content TEXT NOT NULL,                     -- Comment content
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp of creation
  FOREIGN KEY (post_id) REFERENCES posts(post_id) ON DELETE CASCADE, -- Foreign key constraint
  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE  -- Foreign key constraint
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create Likes table
CREATE TABLE likes (
  like_id INT AUTO_INCREMENT PRIMARY KEY,    -- Primary key (auto-incremented integer)
  post_id INT NOT NULL,                      -- Foreign key (references posts.post_id)
  user_id VARCHAR(191) NOT NULL,             -- Foreign key (references users.user_id)
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp of creation
  FOREIGN KEY (post_id) REFERENCES posts(post_id) ON DELETE CASCADE, -- Foreign key constraint
  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE  -- Foreign key constraint
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create Settings table
CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    bio TEXT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    FOREIGN KEY (email) REFERENCES users(email)
);

-- Create Newsletters table
CREATE TABLE newsletters (
  id INT AUTO_INCREMENT PRIMARY KEY,         -- Primary key (auto-incremented integer)
  email VARCHAR(191) UNIQUE NOT NULL,        -- Email address (must be unique)
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Timestamp of creation
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create a dedicated user for the database
DROP USER IF EXISTS 'art_inv_admin'@'localhost';

CREATE USER 'art_inv_admin'@'localhost' IDENTIFIED BY 'Ar7157_1nv3571ga70r5_Adm1n!';

-- Grant necessary privileges to the new user
GRANT SELECT, INSERT, UPDATE, DELETE ON artist_investigators.* TO 'art_inv_admin'@'localhost';

-- Apply changes
FLUSH PRIVILEGES;