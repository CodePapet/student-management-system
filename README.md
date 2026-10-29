# Student Management System

A Laravel web application for managing students, courses, lecturers and course registrations at Makerere University Business School.

**Course:** BUC3131 Advanced Web Application Development, Coursework Two (2026/2027)
**Group:** [group name]
**Repository:** [GitHub repository URL]

## Features

- Authentication with three roles: Administrator, Lecturer and Student
- Role and permission management with spatie/laravel-permission
- Student and course CRUD with form validation
- Course registration that blocks duplicate registrations and full courses
- Role-based records: lecturers see only their own courses, students see only their own registrations
- Reusable Blade layout with sidebar navigation that changes with the user's permissions
- Success and error messages after every action

## Requirements

- PHP 8.2 or newer
- Composer 2
- MySQL (for example through XAMPP)
- Git

## Installation

```bash
git clone [repository URL]
cd student-management-system
composer install
cp .env.example .env
php artisan key:generate
```

On Windows PowerShell, use `copy .env.example .env` instead of `cp`.

## Database setup

1. Start MySQL (XAMPP Control Panel, then Start next to MySQL).
2. Open http://localhost/phpmyadmin and create an empty database named `student_management`.
3. Open `.env` and set:

```properties
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=student_management
DB_USERNAME=root
DB_PASSWORD=
```

4. Create the tables and load the sample data:

```bash
php artisan migrate:fresh --seed
```

5. Start the application:

```bash
php artisan serve
```

Open http://127.0.0.1:8000 in your browser.

The seeders use `firstOrCreate`, so running `php artisan db:seed` again does not create duplicate records.

## User roles

| Role | What they can do |
|---|---|
| Administrator | Manage students, courses and registrations, and manage user access |
| Lecturer | View assigned courses and the students registered for them |
| Student | View available courses, register for courses, and view or drop their own registrations |

### Permissions

| Role | Permissions |
|---|---|
| admin | view, create, edit and delete students; view, create, edit and delete courses; manage registrations; manage users |
| lecturer | view assigned courses |
| student | view available courses; register courses; view own registrations |

## Sample login credentials

The password for every account is `password`.

| Role | Email |
|---|---|
| Administrator | admin@mubs.ac.ug |
| Lecturer | lecturer1@mubs.ac.ug |
| Lecturer | lecturer2@mubs.ac.ug |
| Student | student1@mubs.ac.ug to student6@mubs.ac.ug |


## Screenshots

![Login page](docs/screenshots/login.png)
![Admin dashboard](docs/screenshots/admin-dashboard.png)
![Students list](docs/screenshots/students.png)
![Courses](docs/screenshots/courses.png)
![Registrations](docs/screenshots/registrations.png)
![Lecturer course view](docs/screenshots/lecturer-course.png)
![Student registrations](docs/screenshots/student-registrations.png)

## Team and contributions

| Member | Responsibility | Branch |
|---|---|---|
| [name] | Database design and relationships | feature/relationships |
| [name] | Seeders, roles and permissions | feature/seeders-roles |
| [name] | Student management | feature/student-management |
| [name] | Course and registration management | feature/course-registration |
| [name] | Layout, validation and documentation | feature/layout-docs |

## GitHub workflow

- `main` holds stable code; `develop` is used for integration.
- Each member works on their own feature branch and opens pull requests into `develop`.
- Pull requests are reviewed by a teammate before merging.
- The integrated application is tested before `develop` is merged into `main`.

## Technologies

Laravel, PHP, MySQL, Blade, Bootstrap 5, spatie/laravel-permission