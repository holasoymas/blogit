-- Create likes table
CREATE TABLE IF NOT EXISTS likes (
    lid char(36) PRIMARY KEY DEFAULT (UUID()),
    bid char(36) NOT NULL,
    uid char(36) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bid) REFERENCES blogs(pid) ON DELETE CASCADE,
    FOREIGN KEY (uid) REFERENCES users(id) ON DELETE CASCADE
);
