CREATE DATABASE IF NOT EXISTS techilyfly_app;
USE techilyfly_app;

CREATE TABLE IF NOT EXISTS website_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    site_name VARCHAR(255) NOT NULL,
    logo_url VARCHAR(255),
    contact_email VARCHAR(255),
    contact_phone VARCHAR(50),
    contact_address TEXT,
    social_facebook VARCHAR(255),
    social_twitter VARCHAR(255),
    social_instagram VARCHAR(255),
    social_linkedin VARCHAR(255),
    social_github VARCHAR(255),
    primary_color VARCHAR(50) DEFAULT '#007bff'
);

CREATE TABLE IF NOT EXISTS app_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    icon VARCHAR(100),
    status ENUM('active', 'inactive') DEFAULT 'active'
);

CREATE TABLE IF NOT EXISTS apps (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    developer VARCHAR(255),
    version VARCHAR(50),
    logo_url VARCHAR(255),
    banner_url VARCHAR(255),
    description TEXT,
    requirements TEXT,
    play_store_link VARCHAR(255),
    app_store_link VARCHAR(255),
    indus_store_link VARCHAR(255),
    apk_download_link VARCHAR(255),
    rating DECIMAL(3, 2) DEFAULT 0.00,
    downloads INT DEFAULT 0,
    is_featured BOOLEAN DEFAULT FALSE,
    status ENUM('published', 'draft') DEFAULT 'published',
    publish_date DATE NULL DEFAULT NULL,
    app_update_date DATE NULL DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES app_categories(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    icon VARCHAR(100),
    description TEXT,
    status ENUM('active', 'inactive') DEFAULT 'active'
);

-- Insert dummy data for preview
INSERT IGNORE INTO website_settings (site_name, logo_url, contact_email, contact_phone, contact_address, social_facebook, social_twitter, social_instagram, social_linkedin, social_github) 
VALUES ('Techily Fly Apps', 'https://techilyfly.com/uploads/logo/Techily%20Fly%20Logo%20HD%20Large.svg', 'support@techilyfly.com', '+91-8825164657', 'Ward No. 07, Lahsaniya, Khoripakar, Dewapur, Motihari, Bihar 845427, IN', 'https://facebook.com/techilyfly', 'https://twitter.com/techilyfly', 'https://instagram.com/techilyfly', 'https://linkedin.com/company/techilyfly', 'https://github.com/techilyfly');

INSERT IGNORE INTO app_categories (name, slug, description, icon) VALUES 
('Games', 'games', 'Action, adventure, and puzzle games.', 'bx-game'),
('Productivity', 'productivity', 'Tools to boost your workflow.', 'bx-briefcase'),
('Social', 'social', 'Connect with friends and family.', 'bx-message-rounded');

INSERT IGNORE INTO services (name, slug, description, icon) VALUES 
('Mobile App Development', 'mobile-app-development', 'Custom native and cross-platform apps.', 'bx-mobile'),
('Web App Development', 'web-app-development', 'Scalable full-stack web solutions.', 'bx-laptop'),
('UI/UX Design', 'ui-ux-design', 'Premium, modern aesthetic designs.', 'bx-palette');

INSERT IGNORE INTO apps (category_id, name, slug, developer, version, logo_url, description, is_featured, rating, downloads) VALUES 
(1, 'Cyber Racer', 'cyber-racer', 'TechilyFly', '1.0.0', 'https://placehold.co/150x150/1e1e2e/00d2ff?text=CR', 'High speed neon racing game.', TRUE, 4.8, 12500),
(2, 'TaskFlow', 'taskflow', 'TechilyFly', '2.1.0', 'https://placehold.co/150x150/1e1e2e/ff0055?text=TF', 'Ultimate productivity and task manager.', TRUE, 4.9, 8400),
(3, 'ConnectMe', 'connectme', 'TechilyFly', '1.5.2', 'https://placehold.co/150x150/1e1e2e/00ffaa?text=CM', 'Social network for professionals.', FALSE, 4.2, 5000);

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Default admin: admin / password (using password_hash('password', PASSWORD_DEFAULT))
INSERT IGNORE INTO admins (username, password_hash) VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
