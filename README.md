# anom-post-security-lock

A WordPress plugin that enables administrators and editors to lock any post, page, or custom post type, preventing edits or updates by any user except designated unlock admins. The plugin provides robust post security, supporting lock control both within WP-Admin and via AJAX or direct database modification attempts.

***

## Features

- **Lock Any Post/Page/CPT:** Restrict editing and updating on selected post types.
- **Admin-Configurable Unlock Users:** Only users listed in `POST_SECURITY_USERNAMES` (defined in `wp-config.php`) may unlock posts.
- **Anyone Can Lock:** Any user with post editing capability can lock a post.
- **Comprehensive Protection:** Blocks changes in WP-Admin, via AJAX, REST API, and direct requests.
- **Easy Integration:** Installable via Composer and NPM for development and code standards compliance.

***

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/djm56/anom-post-security-lock.git
cd anom-post-security-lock
```

### 2. Install Composer Dependencies

```bash
composer install
```

### 3. Install NPM Packages

```bash
npm install
```

***

## Configuration

### Set Unlock Admin Usernames

Edit your `wp-config.php` and add a serialized array of usernames who can unlock posts:

```php
define('POST_SECURITY_USERNAMES', serialize(['admin1', 'admin2']));
```

Replace `'admin1', 'admin2'` with the WordPress usernames for users who should be able to unlock posts.

- **Note:** Any user can lock a post. Only “unlock admins” from the above list can unlock a locked post.

***

## Usage

1. **Lock a Post:**  
   Edit any post/page/custom post type and use the “Lock” option to secure it.

2. **Unlock a Post:**  
   Only users listed in `POST_SECURITY_USERNAMES` will see the “Unlock” action on locked posts.

3. **How Locks Work:**  
   - Locked posts cannot be updated, edited, or deleted from any entry point (WP-Admin, AJAX, REST, etc.).
   - Locks are persistent—regular users (not in the allowed list) cannot unlock posts.
   - Unlock admins can freely unlock any locked post.

***

## Development

- Codebase adheres to WP Coding Standards (PHP_CodeSniffer, WordPress Coding Standards).
- Use Composer and NPM scripts for linting and code quality:
    - `composer install` (set up PHP dependencies, code standards)
    - `npm run phpcs` (run PHP_CodeSniffer)
    - `npm run phpcbf` (auto-fix code standards)

***

## Contributing

Contributions and pull requests are welcome. Please ensure code style compliance using the provided Composer and NPM scripts, and update documentation as needed.

***

**Questions or Issues?**  
Create an issue in the GitHub repository or submit a pull request for improvements.
