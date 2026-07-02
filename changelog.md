# Changelog

## Code Review & Cleanup (Refactoring)

### Removed Dead Code:
- Removed `app/Http/Controllers/ProfileController.php` (Not used, no profile UI exists).
- Removed `app/Http/Requests/ProfileUpdateRequest.php`.
- Removed `resources/views/profile/` directory.
- Removed unused methods from `app/Http/Controllers/UrlController.php`:
  - `show`, `edit`, `update`, `destroy`
- Removed unused methods from `app/Http/Controllers/CompanyController.php`:
  - `show`, `edit`, `update`, `destroy`
- Removed corresponding unused resource routes from `routes/web.php` for `urls` and `companies`.

### Bug Fixes & Security Enhancements:
- **Invitation Logic**: Fixed `InvitationController@store` to properly process the invited user's role (`Admin` or `Member`) dynamically instead of hardcoding to `Member`.
- **Validation**: Secured `StoreInvitationRequest.php` by adding strict validation for the `role` parameter (`in:Admin,Member`).
