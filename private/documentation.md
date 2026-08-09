# Techily Fly Apps Platform - Comprehensive Documentation

## 1. Project Overview
**Techily Fly Apps Platform** is a centralized web application designed for showcasing mobile and web applications and generating leads for full-stack app development services. The platform is designed to emulate modern App Stores (like Google Play or Apple App Store) and allows users to browse apps, view details, and download APKs/redirect to official stores. 

It is built as a Traditional Full Stack application without heavy frameworks to ensure maximum performance and compatibility with shared hosting environments like Hostinger/cPanel.

## 2. Technology Stack
*   **Frontend:** HTML5, CSS3, Vanilla JavaScript. Custom CSS framework featuring premium UI/UX aesthetics (glassmorphism, dark/light themes, CSS variables).
*   **Backend:** PHP 8.x
*   **Database:** MySQL
*   **Architecture:** Custom Modular PHP Architecture

## 3. Directory Structure
```text
c:\xampp\htdocs\TechilyFly\TechilyFlyApp\
├── assets/
│   ├── css/          # Contains index.css (Main stylesheet with theming)
│   ├── js/           # Contains main.js (Theme toggling, micro-interactions)
│   └── images/       # Static images/logos
├── database/         # Contains schema.sql (Initial database setup)
├── includes/
│   ├── config/       # Contains database.php (PDO configuration)
│   └── helpers/      # Contains functions.php (Reusable database queries & formatting)
├── modules/          # Core feature modules
│   └── apps/         # App store logic (index.php for listing, details.php for single view)
├── private/          # Secure/Internal documentation folder (You are here)
├── templates/        # Reusable view components
│   ├── header.php    # Global header with navigation and theme toggle
│   └── footer.php    # Global footer with newsletter and links
└── index.php         # Application entry point (Homepage)
```

## 4. Database Schema
*   **Database Name:** `techilyfly_app`
*   **Core Tables:**
    *   `website_settings`: Global configuration (site name, branding).
    *   `app_categories`: Categorization for the applications.
    *   `apps`: The core applications table holding all app metadata (links, requirements, downloads, rating).
    *   `services`: Agency services offered by Techily Fly.

## 5. Credentials & Environment Details (Local Development)

### Database Configuration (XAMPP Default)
*   **Host:** `localhost`
*   **Database Name:** `techilyfly_app`
*   **Username:** `root`
*   **Password:** *(Blank / No Password)*

> **Note on Deployment:** When deploying to production (e.g., Hostinger/cPanel), you MUST update the credentials in `includes/config/database.php` with the secure production database details.

### Security Configurations
Currently, the application connects via PDO with `PDO::ERRMODE_EXCEPTION` and disabled emulated prepares to prevent SQL Injection attacks natively. Future phases should include CSRF tokens and XSS protection on form submissions.

## 6. Application Features (Phase 1 Implemented)

### Theming System
The application features a built-in Dark/Light mode toggle located in the navigation header.
*   The state is stored in the browser's `localStorage` (key: `theme`).
*   It automatically detects the user's OS-level preference (`prefers-color-scheme`).
*   The entire UI is built on CSS variables (e.g., `--bg-primary`, `--accent-primary`), allowing seamless transitioning between themes without page reloads.

### Page Routes
1.  **Homepage (`/index.php`)**: Features a modern hero section, dynamic grid of "Featured Apps" pulled from the DB, and a "Services" highlight section.
2.  **App Store Listing (`/modules/apps/index.php`)**: Displays all published applications. (UI designed for upcoming search/filter integration).
3.  **App Details (`/modules/apps/details.php?slug=...`)**: Dynamic page rendering specific app details, downloading links, system requirements, and developer information based on the `slug` parameter.

## 7. Future Phases (Pending Implementation)

According to the PRD, the following modules are planned for subsequent phases:
*   **Admin Panel:** Full CRUD management system with a secure login, dashboard, and role-based access control (RBAC).
*   **Contact & Quote Systems:** Forms to capture leads securely into the database and notify admins.
*   **Blog & Portfolio CMS:** Content management modules for articles and agency work.
*   **Analytics & SEO:** Built-in tracking capabilities and dynamic metadata management per page.
