-- Resume site schema — import via phpMyAdmin or:
--   mysql -u root < db/schema.sql

CREATE DATABASE IF NOT EXISTS resume
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE resume;

CREATE TABLE IF NOT EXISTS messages (
  id         INT UNSIGNED     NOT NULL AUTO_INCREMENT,
  name       VARCHAR(70)      NOT NULL,
  email      VARCHAR(190)     NOT NULL,
  message    TEXT             NOT NULL,
  created_at TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  INDEX idx_messages_created (created_at)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
