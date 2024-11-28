-- Create comments table
CREATE TABLE IF NOT EXISTS comments (
    cid char(36)   PRIMARY KEY DEFAULT (UUID()) ,
    blog_id char(36) NOT NULL,
    user_id char(36) NOT NULL,
    comment varchar(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (blog_id) REFERENCES blogs(pid) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
