CREATE TABLE IF NOT EXISTS blogs (
    pid CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    uid CHAR(36) NOT NULL,  -- Match the data type with 'id' in users table
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (uid) REFERENCES users(id) ON DELETE CASCADE
);

