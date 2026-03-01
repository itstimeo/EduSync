# EduSync

Student management application built with PHP and MySQL.

## Features

- User accounts with email/password authentication
- New IP detection with email verification code
- **Courses** — subjects > themes > chapters > documents
- **Grades** — per-subject grade tracking with coefficients
- **Planning** — calendar with exams, school trips, holidays, etc.
- **Revision** — spaced repetition system (customizable intervals)

## Requirements

- PHP >= 8.1
- MySQL >= 8.0
- Composer
- A Gmail account with an App Password (for email sending)

## Installation

```bash
# 1. Install dependencies
composer install

# 2. Copy environment file and fill in your values
cp .env.example .env

# 3. Import database schema
mysql -u root -p < database/migrations/001_create_initial_schema.sql

# 4. Point your web server document root to /public
```

## Gmail SMTP setup

1. Go to [myaccount.google.com](https://myaccount.google.com) → Security
2. Enable 2-Step Verification
3. Security → App passwords → create one for "EduSync"
4. Copy the 16-character password into `MAIL_PASSWORD` in your `.env`

## Project structure

```
public/         Web root (index.php + assets)
src/
  Controllers/  HTTP request handlers
  Models/       Database models
  Views/        PHP templates
  Services/     Mail, Auth, etc.
  Core/         Router, Database, Session, View
config/         Application configuration
database/
  migrations/   SQL schema files
```

## License

See [LICENSE](LICENSE).
