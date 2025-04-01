# My Laravel API Setup

## Features

- **No Starter Kit**: A clean slate Laravel installation.
- **PHP 8.2**: Compatible with PHP 8.2.
- **Laravel 12.0**: The project uses Laravel 12.0.
- **Laravel Tinker 2.10**: Interactive REPL for Laravel.
- **Spatie/Laravel-Data 4.14**: For handling data transformation and DTOs.
- **Spatie/Laravel-Permission 6.16**: Easy role and permission management.
- **Custom Artisan Commands**: Includes commands for creating DTOs and actions.
- **SQLite**: Uses SQLite as the database for simplicity.
- **Password Validation**: Uses `Password::defaultRules()` from `Illuminate\Validation\Rules` for password validation. The default password validation rules can be customized in the `AppServiceProvider`.
- **Hashed IDs**: Instead of regular IDs, the API uses hashed IDs when communicating with the client. This helps improve security.
- **HasHashid Trait**: The `HasHashid` trait is included in models that require hashed IDs. Ensure you add a `hashid` field to the corresponding database tables.
- **Artisan Command for Models**: When generating models using Artisan commands, the `HasHashid` trait is automatically included.
- **Migrations**: The `hashid` field is included by default when generating migration files via Artisan commands.
- **Email Verification**: Email verification feature is enabled by default.

## Steps to Follow

1. **Install Dependencies**:
   - Run the following command to install the required dependencies:
   ```bash
   composer install
   ```

2. **Set Up the .env File**:
   - Copy the .env.example file to .env
   ```bash
   cp .env.example .env
   ```
   - Set the following environment variables in your .env file:
     - APP_NAME
	 - APP_URL
	 - DB_* (Database credentials)

3. **Generate Application Key**:
   - Run the following command to generate app key:
   ```bash
   php artisan key:generate
   ```

4. **Run Migrations**:
   - Run the following command to create the database tables and apply the necessary migrations:
   ```bash
   php artisan migrate:fresh
   ```