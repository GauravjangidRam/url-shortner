# URL Shortener

A multi-company URL shortener built with **Laravel 13** and **PHP 8.3+**. It supports three roles with strict visibility scoping, a token-based invitation system, CSV export, and public short-URL redirection with hit tracking.

---

## Tech Stack

| Layer       | Technology                          |
|-------------|-------------------------------------|
| Backend     | Laravel 13 (PHP 8.3+)               |
| Auth        | Laravel Breeze                      |
| Database    | SQLite (dev) / any Laravel-supported DB |
| Frontend    | Bootstrap 5.3, Blade templates      |
| Testing     | PHPUnit (Laravel Feature Tests)     |

---

## Roles & Permissions

| Action                          | SuperAdmin | Admin | Member |
|---------------------------------|:----------:|:-----:|:------:|
| Manage companies                | ✅          | ❌    | ❌     |
| Invite Admin / Member           | ❌          | ✅    | ❌     |
| Generate short URLs             | ❌          | ✅    | ✅     |
| View all URLs (all companies)   | ✅          | ❌    | ❌     |
| View company URLs               | ❌          | ✅    | ❌     |
| View own URLs only              | ❌          | ❌    | ✅     |
| Export URLs as CSV              | ✅          | ✅    | ✅     |
| Public short-URL redirect       | Public     | Public | Public |

---

## Features

- **Role-based dashboard** — each role sees a tailored view (companies, team members, or own URLs)
- **Invitation system** — Admin sends an invitation link; invited user registers via the token URL; no email server required (link is shown on dashboard for manual sharing)
- **Pending invitations panel** — Admin can see all pending invitations with a one-click copy button for the invite link
- **URL visibility scoping** — SuperAdmin sees all, Admin sees company-only, Member sees own only
- **Short URL redirect** — public `GET /{shortCode}` redirects to the original URL and increments hit counter
- **CSV export** — download filtered URLs scoped to the current user's role
- **Date filters** — Today / Last Week / This Month / Last Month on the dashboard and export

---

## Database Relations

```
companies
  └── users (many)         — users.company_id → companies.id
  └── invitations (many)   — invitations.company_id → companies.id
  └── urls (many)          — urls.company_id → companies.id

users
  └── urls (many)          — urls.user_id → users.id

invitations
  token (string, unique)   — used as the registration link key
  accepted_at (nullable)   — null = pending, set = accepted
```

---

## Installation & Setup

```bash
# 1. Clone and install dependencies
composer install

# 2. Copy environment file
cp .env.example .env

# 3. Generate app key
php artisan key:generate

# 4. Create the SQLite database file (if using SQLite)
touch database/database.sqlite

# 5. Run migrations and seed default accounts
php artisan migrate --seed

# 6. Build frontend assets
npm install && npm run build

# 7. Start the development server
php artisan serve
```

Or use the single setup script:

```bash
composer run setup
```

---

## Seeded Accounts

After running `php artisan migrate --seed`, the following accounts are available:

| Role       | Email                     | Password      |
|------------|---------------------------|---------------|
| SuperAdmin | superadmin@example.com    | password      |
| Admin      | admin@semberk.tech        | semberk@123   |

The demo Admin belongs to a company called **Semberk**. Use it to test invitations, URL creation, and team member management.

---

## Key Routes

| Method   | Route                          | Description                        | Access          |
|----------|--------------------------------|------------------------------------|-----------------|
| GET      | `/`                            | Redirects to login                 | Guest           |
| GET      | `/dashboard`                   | Role-based dashboard               | Auth            |
| GET/POST | `/companies`                   | List / create companies            | SuperAdmin      |
| GET/POST | `/members`                     | Send invitations                   | Admin           |
| GET/POST | `/invitations/accept/{token}`  | Accept invitation & register       | Guest           |
| GET/POST | `/urls`                        | List / create short URLs           | Admin, Member   |
| GET      | `/urls/export`                 | Download CSV export                | Auth            |
| GET      | `/{shortCode}`                 | Public redirect + hit tracking     | Public          |

---

## Running Tests

```bash
php artisan test
```

The test suite covers:
- Admin and Member can create short URLs
- SuperAdmin is blocked from creating short URLs (403)
- Admin sees only their company's URLs
- Member sees only their own URLs
- Public short-URL resolves and redirects correctly

---

## Known Limitations

- **No email delivery** — invitations are not emailed. The invite link must be copied manually from the Admin dashboard.
- **SQLite only in dev** — the default setup uses a local SQLite file. Switch `DB_CONNECTION` in `.env` for MySQL/PostgreSQL in production.
- **No URL expiry** — short URLs do not expire. There is no TTL or deactivation feature.
- **No password change UI** — password resets are handled via the direct reset form at `/reset-password-direct`.

---

## AI Assistance Disclosure

This project was developed with the assistance of AI tools — ChatGPT and Claude. AI tooling was used for code review, bug identification, security hardening, test-case suggestions, and documentation drafting.
