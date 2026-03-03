# UITS Research Archive

A comprehensive web-based platform designed for managing and showcasing research papers, capstone projects, articles, and theses for the University of Information Technology and Sciences (UITS).

## 🚀 Features

- **Public Archive**: Browse and search through approved research submissions.
- **Submission System**: Students and faculty can submit their research works with details like title, abstract, authors, and external links (PDF, Drive).
- **User Dashboard**: Users can track the status of their submissions and manage their profile.
- **Admin Panel**: 
    - Review and manage submissions (Approve/Reject).
    - Advanced statistics and reporting.
    - User management and role assignment.
- **Role-based Access**: Support for Student, Faculty, and Admin roles.
- **Responsive Design**: Built with a modern, premium aesthetic that works across all devices.

## 🛠️ Technology Stack

- **Framework**: [Laravel 12](https://laravel.com)
- **Frontend**: Blade Templates with Vanilla CSS and Bootstrap 5
- **Authentication**: Laravel Breeze
- **Database**: MySQL
- **Build Tool**: Vite

## 📥 Installation

Follow these steps to set up the project locally:

1. **Clone the repository**:
   ```bash
   git clone [repository-url]
   cd uits-research-archive
   ```

2. **Install dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure Database**:
   Update the `DB_*` variables in your `.env` file to match your local database settings.

5. **Run Migrations & Seeders**:
   ```bash
   php artisan migrate
   ```

6. **Build Assets**:
   ```bash
   npm run build
   ```

7. **Start the Development Server**:
   ```bash
   php artisan serve
   ```

## 📋 Project Structure

- `app/Http/Controllers`: Contains the logic for handling requests (Admin, Submissions, Home).
- `app/Models`: Database structure and relationships (User, Submission, Department, Domain).
- `resources/views`: UI templates using Blade.
- `routes/web.php`: Application routing.

## 🔐 Admin Access

To access the admin panel, a user must have the `admin` role. You can assign roles via the database or the User Management section within the panel.

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👥 Authors

- **[Azhar]** - [azhar_uddin1120@uits.edu.bd]
