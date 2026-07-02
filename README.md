# URL Shortener

A multi-company URL shortener built with Laravel 12. 
It supports multiple roles with strict visibility scoping and an invitation system.

## Setup Instructions
1. `composer install`
2. `cp .env.example .env`
3. Configure your database (`DB_CONNECTION=sqlite` is the default).
4. `php artisan key:generate`
5. `php artisan migrate --seed`
6. `npm install && npm run build` (optional, as minimal UI is used)
7. `php artisan serve`

## Seeded Credentials (SuperAdmin)
- **Email:** `superadmin@example.com`
- **Password:** `password`

## Core Features & Scoping
- **SuperAdmin:** Can view and manage *all* Companies and *all* URLs.
- **Admin:** Can invite Members to their specific Company. Can view/manage *only* their Company's URLs.
- **Member:** Can create URLs, but can view/manage *only* the URLs they created.

## Key Routes
| Method | Route | Description | Role Access |
|--------|-------|-------------|-------------|
| GET | `/` | Login page | Guest |
| GET | `/dashboard` | Role-based Dashboard | All Auth |
| GET/POST | `/companies` | Manage Companies | SuperAdmin |
| GET/POST | `/members` | Invite Members | Admin |
| GET/POST | `/urls` | Manage URLs | SuperAdmin, Admin, Member |
| GET | `/{shortCode}` | Public redirect and hit tracking | Public |

## Automated Testing
Run `php artisan test` to execute the full Feature test suite ensuring Role middleware, CRUD operations, Invitations, and Visibility Scoping.
