# Personal Resume Website

A minimal, dark-premium resume site with an electric-lime accent. Server-rendered PHP (no framework), MySQL storage for contact messages, built to run on XAMPP.

```
home  →  hero + career stat strip (signature detail)
about →  story, quick facts, coaching principles
work  →  experience timeline + selected projects
contact →  validated form → MySQL (CSRF + honeypot + rate limited)
```

## Tech

- **Backend** — PHP 8.1+ (PDO, prepared statements, session flash, PRG)
- **Frontend** — HTML + CSS (custom design system) + vanilla JS (enhancement only)
- **Database** — MySQL (`messages` table)
- **Server** — XAMPP (Apache + PHP + MySQL)

## Run it (XAMPP)

1. Copy the project to `C:\xampp\htdocs\resume` (any name works).
2. **Point the Apache document root at `public/`** — or use Apache VirtualHost:
   ```apache
   DocumentRoot "C:/xampp/htdocs/resume/public"
   <Directory "C:/xampp/htdocs/resume/public">
       AllowOverride All
       Require all granted
   </Directory>
   ```
3. Create the database — open `http://localhost/phpmyadmin`, run `db/schema.sql` (or `mysql -u root < db/schema.sql`).
4. Verify DB credentials in `app/config/database.php` (XAMPP defaults: root / empty).
5. Visit `http://localhost/` — you should see the home page. Check `http://localhost/contact` form posts into the `messages` table.

No XAMPP? `php -S localhost:8000 -t public` with PHP CLI works too (routes via the front controller; add a rewrite fallback or use the built-in server's default routing — the front controller handles `/` through `/index.php?path=` if mod_rewrite is absent).

## Personalize

Everything you'd edit lives in **one file**: `app/config/content.php`

- Name, role, tagline, location, email, phone, social links
- Stat strip numbers (years, athletes, PB, podiums)
- Work history, wins, projects

Swap `name` and the pages update automatically (brand, titles, resume filename, 404 page).

## Deployment checklist

- [ ] Document root points at `public/` (`app/`, `db/` are never web-exposed)
- [ ] MySQL database created from `db/schema.sql`; credentials set in `app/config/database.php`
- [ ] Production: set `DB_*` env vars; use a real mail/SMTP send instead of the inbox table if needed
- [ ] TLS enabled (session cookie `secure` flag turns on automatically over HTTPS)
- [ ] `public/assets/resume.pdf` — replace the placeholder PDF (route `/resume.pdf`)
- [ ] Verify headers: `curl -I https://your-site/` → CSP, nosniff, X-Frame-Options present
- [ ] Smoke test: GET `/`, GET `/about`, GET `/work`, POST `/contact` (invalid + valid), GET `/nope` → 404, POST `/about` → 405, `curl -I /` → 200
- [ ] `git init` + push; CI workflow lints all PHP on every push

## Routes

| Method | Path | Result |
|---|---|---|
| GET | `/` `/about` `/work` `/contact` | pages |
| GET | `/resume.pdf` | placeholder PDF |
| POST | `/contact` | validate → store → redirect (PRG) |
| HEAD | any GET route | mirrors GET, no body |
| — | unknown path | 404 |
| — | path exists under another verb | 405 + `Allow` header |
