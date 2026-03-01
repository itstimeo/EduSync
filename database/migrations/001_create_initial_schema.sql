-- EduSync - Initial database schema
-- Run this file to create all required tables

CREATE DATABASE IF NOT EXISTS edusync
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE edusync;

-- ============================================================
-- AUTH
-- ============================================================

CREATE TABLE IF NOT EXISTS users (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email       VARCHAR(255) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    first_name  VARCHAR(100) NOT NULL,
    last_name   VARCHAR(100) NOT NULL,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Stores IPs that have been verified for a user
CREATE TABLE IF NOT EXISTS user_trusted_ips (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id      INT UNSIGNED NOT NULL,
    ip_address   VARCHAR(45) NOT NULL,
    user_agent   VARCHAR(512) DEFAULT NULL,
    last_seen_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY uq_user_ip (user_id, ip_address)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Temporary codes for email verification (new IP, password reset, etc.)
CREATE TABLE IF NOT EXISTS verification_codes (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id    INT UNSIGNED NOT NULL,
    code       VARCHAR(10) NOT NULL,
    type       ENUM('new_ip', 'password_reset', 'email_verify') NOT NULL,
    expires_at DATETIME NOT NULL,
    used_at    DATETIME DEFAULT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- COURSES
-- ============================================================

CREATE TABLE IF NOT EXISTS subjects (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id    INT UNSIGNED NOT NULL,
    name       VARCHAR(150) NOT NULL,
    color      VARCHAR(7) NOT NULL DEFAULT '#6366f1',
    icon       VARCHAR(50) DEFAULT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS themes (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    subject_id INT UNSIGNED NOT NULL,
    name       VARCHAR(150) NOT NULL,
    position   SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS chapters (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    theme_id   INT UNSIGNED NOT NULL,
    name       VARCHAR(150) NOT NULL,
    position   SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (theme_id) REFERENCES themes(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS documents (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    chapter_id  INT UNSIGNED NOT NULL,
    title       VARCHAR(255) NOT NULL,
    description TEXT DEFAULT NULL,
    file_path   VARCHAR(512) DEFAULT NULL,
    file_type   VARCHAR(50) DEFAULT NULL,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (chapter_id) REFERENCES chapters(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- GRADES
-- ============================================================

CREATE TABLE IF NOT EXISTS grades (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id     INT UNSIGNED NOT NULL,
    subject_id  INT UNSIGNED NOT NULL,
    name        VARCHAR(150) NOT NULL,
    value       DECIMAL(5,2) NOT NULL,
    max_value   DECIMAL(5,2) NOT NULL DEFAULT 20.00,
    coefficient DECIMAL(4,2) NOT NULL DEFAULT 1.00,
    graded_at   DATE NOT NULL,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id)   REFERENCES users(id)    ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- PLANNING
-- ============================================================

CREATE TABLE IF NOT EXISTS events (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id     INT UNSIGNED NOT NULL,
    title       VARCHAR(255) NOT NULL,
    type        ENUM('exam', 'school_trip', 'holiday', 'assignment', 'other') NOT NULL DEFAULT 'other',
    description TEXT DEFAULT NULL,
    start_date  DATETIME NOT NULL,
    end_date    DATETIME NOT NULL,
    all_day     TINYINT(1) NOT NULL DEFAULT 0,
    color       VARCHAR(7) DEFAULT NULL,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- REVISION (spaced repetition)
-- ============================================================

-- Default method: J+1, J+3, J+7, J+15, J+30
-- intervals stored as JSON array of days, e.g. [1, 3, 7, 15, 30]
CREATE TABLE IF NOT EXISTS revision_methods (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id    INT UNSIGNED NOT NULL,
    name       VARCHAR(100) NOT NULL,
    intervals  JSON NOT NULL,
    is_default TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- item_type: 'document' or 'chapter'
CREATE TABLE IF NOT EXISTS revision_sessions (
    id                 INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id            INT UNSIGNED NOT NULL,
    method_id          INT UNSIGNED NOT NULL,
    item_type          ENUM('document', 'chapter') NOT NULL,
    item_id            INT UNSIGNED NOT NULL,
    revision_count     SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    next_revision_date DATE NOT NULL,
    last_revised_at    DATETIME DEFAULT NULL,
    created_at         DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at         DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id)  REFERENCES users(id)             ON DELETE CASCADE,
    FOREIGN KEY (method_id) REFERENCES revision_methods(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
