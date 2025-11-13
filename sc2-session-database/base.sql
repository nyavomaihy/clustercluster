CREATE DATABASE session_cluster;
DROP TABLE IF EXISTS sessions;

CREATE TABLE sessions (
    session_id VARCHAR(128) NOT NULL PRIMARY KEY,
    session_value TEXT NOT NULL,
    modified_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_modified (modified_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Vérifier
DESCRIBE sessions;