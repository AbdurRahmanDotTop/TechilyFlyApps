# Techily Fly Apps 🚀

Welcome to the **Techily Fly Apps** platform! This is a modern, responsive, and dynamic web platform built to showcase mobile and web applications, highlight services, and connect with users seamlessly.

---

## 🧑‍💻 **For Users (Features & Experience)**

Our platform is designed with a premium, fluid, and user-centric approach. Here is everything the platform offers to our visitors:

### 1. Modern & Adaptive UI/UX
- **Glassmorphism Design:** A beautiful dark-themed UI with frosted glass effects and smooth gradient accents.
- **Fluid Responsiveness:** Typography, paddings, and margins automatically scale to perfectly fit any screen size (from large 4K monitors to small mobile devices) using percentage-based widths and CSS `clamp()`.
- **Smooth Navigation:** Includes a sticky header, smooth scrolling, and a convenient **Back to Top** button located on the bottom left for easy navigation.
- **Tawk.to Live Chat:** Integrated live chat on the bottom right for instant support and communication.

### 2. App Store & Showcase
- **Featured Apps:** Instantly discover our top-rated and newly launched applications right on the home page.
- **App Details:** Deep dive into each app to see detailed descriptions, categories, and direct APK download links.
- **Live Reviews & Ratings:** The platform fetches real-time total download counts, average ratings, and the top 25 user reviews directly from Google Play Store and Indus Appstore (powered by a custom API).
- **Search & Filter:** Easily find specific apps by searching or filtering through different categories directly on the Apps page.

### 3. Services Portfolio
- Explore our core expertise including UI/UX Design, App Development, Web Development, and API Integration services.

### 4. Interactive Contact System
- **Contact Form:** A fully functional form for users to send inquiries, feedback, or support requests.
- **Success Notifications:** Immediate visual feedback when a message is successfully sent to our team.

---

## 🛠️ **For Developers (Architecture & Setup)**

This platform is a custom-built PHP application utilizing a MySQL database, designed for performance, security, and easy administration.

### 1. Tech Stack
- **Frontend:** HTML5, Vanilla CSS3 (Custom Fluid Design System), Vanilla JavaScript.
- **Backend:** PHP 8+ (PDO for secure database interactions).
- **Database:** MySQL.
- **External APIs:** Integration with a custom Node.js/Playwright API hosted on Render (`IndusAppstoreAPI`) to scrape and fetch live reviews.

### 2. Admin Dashboard (Full CMS)
The platform includes a secure, password-protected Admin panel (`/admin`) with full CRUD (Create, Read, Update, Delete) capabilities:
- **Dashboard Overview:** Quick stats showing Total Apps, Total Downloads, and Published Apps.
- **Manage Apps:** Add new apps, upload logos, set download links, and toggle "Featured" status. 
- **Manage Categories & Services:** Create and organize app categories and company services dynamically.
- **Manage Messages:** View, read, and delete user submissions from the frontend Contact form. Features an unread message badge notification.
- **Website Settings:** Dynamically update global settings (like contact email, phone, and address) without touching the code.

### 3. Key Components & Integrations
- **Review Fetching API (`api_get_reviews.php`):** Communicates with the external Render API to fetch app reviews via cURL, caching the results to improve page load speed and reduce API rate-limiting.
- **Fluid CSS System (`index.css`):** Built entirely without heavy frameworks (like Bootstrap or Tailwind). Uses CSS Variables for theming and CSS Grid/Flexbox for layouts.
- **Security:** Uses PHP PDO prepared statements to prevent SQL Injection and `htmlspecialchars()` to prevent XSS attacks.

### 4. Local Setup Instructions
To run this project locally, follow these steps:
1. Clone the repository into your local server environment (e.g., `htdocs` for XAMPP).
2. Import the database schema into your MySQL server.
3. Update the database credentials located in `includes/config/database.php`.
4. Ensure the external API (`https://indus-appstore-api-0wku.onrender.com`) is live for the reviews section to function properly.
5. Access the site via `http://localhost/TechilyFlyApps` and the admin panel via `http://localhost/TechilyFlyApps/admin`.

---

*Built with ❤️ by the Techily Fly Team.*
