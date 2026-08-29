# Living RT

A web-based neighborhood administration system built with Laravel to streamline resident management, administrative services, announcements, complaints, payments, and RT/RW operational workflows.

The application centralizes common neighborhood administrative processes into a single platform, providing structured access for administrators and residents.

## Overview

Living RT was developed to reduce manual administrative work commonly found in neighborhood management.

The system provides functionality for managing resident information, processing administrative requests, publishing announcements, handling complaints, monitoring account approvals, and supporting payment workflows.

The project follows Laravel's MVC architecture and uses MySQL/MariaDB for persistent data storage.

## Key Features

### Resident Management
- Manage resident and family member information
- Create, update, and maintain resident records
- Organize resident-related administrative data

### Administrative Letters
- Submit administrative letter requests
- Review and approve submitted requests
- Track request status and approval information

### Complaint Management
- Submit complaints or reports
- Review and respond to complaints
- Track complaint status and responses

### Announcement Management
- Publish community announcements
- Manage information distributed to residents

### Family Approval
- Submit family-related approval requests
- Review and approve submitted information
- Track approval status

### Payment Management
- Manage resident payment records
- Support online payment workflows through Midtrans integration

### Authentication and Access Control
- User authentication
- Role-based access
- Account approval workflow
- Protected administrative pages

### Administrative Dashboard
- Centralized access to RT administrative functions
- Account approval monitoring
- Navigation for resident, letter, complaint, and payment management

## Tech Stack

| Technology | Usage |
|---|---|
| Laravel | Backend framework |
| PHP | Server-side application logic |
| MySQL / MariaDB | Relational database |
| Blade | Server-side templating |
| JavaScript | Client-side interaction |
| CSS | User interface styling |
| Vite | Frontend asset bundling |
| Font Awesome | Interface icons |
| Midtrans | Payment gateway integration |
| Composer | PHP dependency management |
| NPM | Frontend dependency management |

## Architecture

The application follows Laravel's MVC architecture:

```text
app/
├── Http/
│   └── Controllers/
├── Models/
└── Providers/

database/
├── factories/
├── migrations/
└── seeders/

resources/
├── css/
├── js/
└── views/

routes/
```

Database schema changes are managed through Laravel migrations, while seeders and factories are used to generate development data.

## Local Installation

### Requirements

Make sure the following are installed:

- PHP
- Composer
- MySQL or MariaDB
- Node.js
- NPM

### Clone the repository

```bash
git clone https://github.com/rajsfanopriariyabarisky/rtapp.git
cd rtapp
```

### Install backend dependencies

```bash
composer install
```

### Install frontend dependencies

```bash
npm install
```

### Configure the environment

Create a local environment file:

```bash
cp .env.example .env
```

On Windows:

```bash
copy .env.example .env
```

Generate the Laravel application key:

```bash
php artisan key:generate
```

### Configure the database

Create a MySQL or MariaDB database and update the following values in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=
```

Run the migrations:

```bash
php artisan migrate
```

Seed development data if required:

```bash
php artisan db:seed
```

### Configure Midtrans

Add your own Midtrans credentials:

```env
MIDTRANS_SERVER_KEY=
MIDTRANS_CLIENT_KEY=
MIDTRANS_IS_PRODUCTION=false
```

Never commit production credentials or secret keys to the repository.

### Run the application

Start Laravel:

```bash
php artisan serve
```

Start the frontend development server in a separate terminal:

```bash
npm run dev
```

The application will be available at:

```text
http://127.0.0.1:8000
```

## Production Build

Build frontend assets with:

```bash
npm run build
```

Clear Laravel caches when required:

```bash
php artisan optimize:clear
```

## Security

Sensitive configuration is stored in `.env` and is excluded from version control.

Credentials such as database passwords, SMTP credentials, API keys, and payment gateway secrets should never be stored directly in the source code.

## Screenshots

Screenshots of the application interface can be added here.

Recommended examples:

- Login page
- RT dashboard
- Resident management
- Letter management
- Complaint management
- Payment management

Example:

```markdown
![RT Dashboard](docs/images/dashboard.png)
```

## Engineering Highlights

This project demonstrates practical experience with:

- Laravel MVC architecture
- Relational database design
- Authentication and role-based access control
- CRUD application development
- Laravel migrations and seeders
- Eloquent ORM relationships
- Blade component development
- Payment gateway integration
- Frontend asset management with Vite
- Git-based development workflow

## Repository

GitHub:  
https://github.com/rajsfanopriariyabarisky/rtapp
