-- Resume site schema (PostgreSQL) — for Vercel/Neon/other Postgres hosts.
--   psql "$DATABASE_URL" -f db/schema.pgsql.sql
-- MySQL on XAMPP uses db/schema.sql instead.

CREATE TABLE IF NOT EXISTS messages (
  id         BIGSERIAL    PRIMARY KEY,
  name       VARCHAR(70)  NOT NULL,
  email      VARCHAR(190) NOT NULL,
  message    TEXT         NOT NULL,
  created_at TIMESTAMPTZ  NOT NULL DEFAULT now()
);

CREATE INDEX IF NOT EXISTS idx_messages_created ON messages (created_at);
