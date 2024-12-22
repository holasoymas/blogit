CREATE TABLE IF NOT EXISTS report_blogs(
report_id char(36)  PRIMARY KEY DEFAULT (uuid()),
reported_blog char(36) NOT NULL,
  reported_by char(36) NOT NULL,
  report_reason VARCHAR(200) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY(reported_by) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY(reported_blog) REFERENCES blogs(pid) ON DELETE CASCADE,
);
